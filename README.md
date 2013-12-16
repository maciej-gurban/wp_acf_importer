Wordpress ACF importer
==============

The plugin allows programmatical import of XML files containing ACF (Advanced Custom Fields) into Wordpress. It expects one ACF field (post of 'acf' type) at a time. XML syntax expected by the plugin needs to be the output of ACF plugin's export function.


Installation
------------

**Uploading in WordPress Dashboard**

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `wp_acf_importer.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

**Using FTP**

1. Download `wp_acf_importer.zip`
2. Extract the `wp_acf_importer` directory to your computer
3. Upload the `wp_acf_importer` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


Plugin usage
------------

Plugin expects $xml_string parameter to be passed. It should contain the contents of the XML file that is produced by ACF plugin upon export of an ACF field. The plugin will try to create one new ACF post unless one already exists, and then populate it with fields. To insert more than one field (a clone) with the same title, you should pass true as a second parameter.

Sample code (to be used in, for example, theme's functions.php file):
            
    $acf_import = WP_ACF_Importer::get_instance();
    
    $acf_field = file_get_contents('advanced-custom-field-export.xml');
    
    if( $acf_import->acf_create_field( $acf_field) ) {
        echo 'Field created successfully.';
    }
    else {
        echo 'Import has not been performed.';
    }


Parameters
------------

Plugin source code extract:

    acf_create_field( $xml_string, $allow_duplicates = false, $update_if_exists = false )

1. `$xml_string` (required | `string` | default: empty) - a string containing the imported XML
2. `$allow_duplicates` (optional | `true/false` | default: false) - decides if to allow creating posts with identical post_name or not
3. `$update_if_exists` (optional | `true/false` | default: false) - decides if to update and overwrite post's meta (sets of fields created to be edited in the back-end) or not
