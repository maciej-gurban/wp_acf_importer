<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Wordpress ACF importer
 * @author    Maciej Gurban <maciej.gurban@gmail.com>
 * @license   GPL-2.0+
 * @link      https://github.com/maciej-gurban/acf_create_field/
 * @copyright 2013 Maciej Gurban
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

