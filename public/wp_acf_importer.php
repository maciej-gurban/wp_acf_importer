<?php
/**
 * Wordpress ACF importer
 *
 * @package   Wordpress ACF importer
 * @author    Maciej Gurban <maciej.gurban@gmail.com>
 * @license   GPL-2.0+
 * @link      https://github.com/maciej-gurban/acf_create_field/
 * @copyright 2013 Maciej Gurban
 */


class WP_ACF_Importer {

	/**
	 * Plugin version
	 *
	 * @since   0.1.1
	 *
	 * @var     string
	 */
	const VERSION = '0.1.1';

	/**
	 * @since   0.1.1
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'wp_acf_importer';

	/**
	 * Instance of this class.
	 *
	 * @since   0.1.1
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since   0.1.1
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		add_action( 'wp_acf_importer', array( $this, 'acf_create_field' ) );

	}


	/**
	 * Return the plugin slug.
	 *
	 * @since   0.1.1
	 *
	 *@return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since   0.1.1
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since   0.1.1
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since   0.1.1
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since   0.1.1
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since   0.1.1
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since   0.1.1
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since   0.1.1
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since   0.1.1
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	}




	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since   0.1.1
	 *
	 * @param	string    	$xml_string    		Contents of the XML file
	 * @param   bool    	$allow_duplicates   Allows overriding custom post type setting requiring posts to have unique post_name attribute
	 * @param   bool    	$update_if_exists   Specify whether to overwrite existing post's fields. If true passed, every function run, the post matching post_name will be updated with XML-originating fields
	 *
	 * @return 	true|false 						Return TRUE upon successful field creation, and FALSE upon failure	 
	 */
	public function acf_create_field( $xml_string, $allow_duplicates = false, $update_if_exists = false ) {

	    // Parse ACF post's XML
	    $content = simplexml_load_string( $xml_string, 'SimpleXMLElement', LIBXML_NOCDATA); 

	    // @TODO: add a check on $content

	    // Parse XML post attributes containing fields
	    $wp_post_attributes = $content->channel->item->children('wp', true);

	    # Copy basic properties from the exported field
	    $wp_post_data = array(
	        'post_type'   => 'acf',
	        'post_title'  => $content->channel->item->title,
	        'post_name'   => $wp_post_attributes->post_name,
	        'post_status' => 'publish',
	        'post_author' => 1

	    );

	    $the_post = get_page_by_title( $content->channel->item->title, 'OBJECT', 'acf' );

	    # Create a new post if doesn't exist
	    if ( !$the_post || $allow_duplicates == true ) {
	        $post_id = wp_insert_post( $wp_post_data );
	    }
	    # If exists, update post_meta (the actual editable fields created )
	    else {
	        $post_id = $the_post->ID;
	    }

	    # Prevents overwriting if post already exists
	    if( $update_if_exists === true ) {

	    	$wp_post_meta = $content->channel->item->children( 'wp', true );

		    if( $wp_post_meta ) {
		        foreach ( $wp_post_meta as $row ) {
		            // Choose only arrays (postmeta)
		            if( count($row) > 0) {
		                // using addlashes on meta values to compensate for stripslashes() that will be run upon import
		                update_post_meta( $post_id, $row->meta_key, addslashes( $row->meta_value ) );
		            }
		        }
		        return true;
		    }	
	    }


	    return false;

	}





} // end of class


