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

Sample code:

    $acf_field = file_get_contents('advanced-custom-field-export.xml');
            
    $aim = WP_ACF_Importer();
    
    if( $aim->acf_create_field( $acf_field ) ) {
        echo 'Field created successfully.';
    }
    else {
        echo 'Import failed.';
    }


            
