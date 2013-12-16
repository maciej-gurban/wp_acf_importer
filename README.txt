=== Wordpress ACF importer ===
Tags: acf, xml, import, custom fields
Requires at least: 3.6
Tested up to: 3.7.1
Stable tag: 0.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Here is a short description of the plugin.  This should be no more than 150 characters.  No markup here.

== Description ==

The plugin allows programmatical import of XML files containing ACF fields into Wordpress. Expects one ACF field (post of 'acf' post type) at a time. 


== Installation ==

This section describes how to install the plugin and get it working.

= Using The WordPress Dashboard =

(Currently not available)
1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'wp_acf_importer.zip'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `wp_acf_importer.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `wp_acf_importer.zip`
2. Extract the `wp_acf_importer` directory to your computer
3. Upload the `wp_acf_importer` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


== Frequently Asked Questions ==

= How to use the plugin? =

Plugin expects $xml_string parameter to be passed. It should contain the contents of the XML file that is produced by ACF plugin upon export of an ACF field.

The plugin will try to create one new ACF post unless one already exists, and then populate it with fields. To insert more than one field (a clone) with the same title, you should pass true as a second parameter.

Sample code:

    $acf_field = file_get_contents('advanced-custom-field-export.xml');
            
    $aim = WP_ACF_Importer();
    
    if( $aim->acf_create_field( $acf_field ) ) {
        echo 'Field created successfully.';
    }
    else {
        echo 'Import failed.';
    }


== Changelog ==

= 0.1.1 =
* Turning the function into a plugin
* Making the plugin Multisite-enabled

= 0.1 =
* Initial functionality offered as a function

== Upgrade Notice ==

= 0.1.1 =
Plugin support for Wordpress Multisite.


== Updates ==

This plugin supports the [GitHub Updater](https://github.com/afragen/github-updater) plugin, so if you install that, this plugin becomes automatically updateable from GitHub. Any submission to WP.org repo will make this redundant.

== A brief Markdown Example ==

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"


`<?php code(); // goes in backticks ?>`
