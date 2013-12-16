<?php
/**
 * Wordpress ACF importer
 *
 * @package   Wordpress ACF importer
 * @author    Maciej Gurban <maciej.gurban@gmail.com>
 * @license   GPL-2.0+
 * @link      https://github.com/maciej-gurban/acf_create_field/
 * @copyright 2013 Maciej Gurban
 *
 * @wp_acf_importer
 * Plugin Name:       Wordpress ACF importer
 * Plugin URI:        https://github.com/maciej-gurban/acf_create_field
 * Description:       ACF (Advanced Custom Fields) importer. Allows programmatical import of XML files containing ACF fields into Wordpress, previously exported by the plugin itself. Expects one ACF field (post of 'acf' post type) at a time.
 * Version:           0.1.1
 * Author:            Maciej Gurban
 * Author URI:        http://dihdesign.com
 * Text Domain:       en
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/maciej-gurban/acf_create_field
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/*
	This plugin is based upon: 
	https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate
	
	For some insight, visit:
	http://wp.tutsplus.com/tutorials/creative-coding/design-patterns-in-wordpress-the-singleton-pattern/
*/

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 *  Plugin's class file
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/wp_acf_importer.php' );


/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * Class name from wp_acf_importer.php
 */
register_activation_hook( __FILE__, array( 'WP_ACF_Importer', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_ACF_Importer', 'deactivate' ) );

/*
 * Class name from wp_acf_importer.php
 */
add_action( 'plugins_loaded', array( 'WP_ACF_Importer', 'get_instance' ) );


?>