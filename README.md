WP ACF Importer
==============

The plugin allows programmatical import of XML files containing ACF (Advanced Custom Fields) into Wordpress. It expects one ACF field (post of 'acf' type) at a time. XML syntax expected by the plugin needs to be the output of ACF plugin's export function.

The plugin supports Wordpress Multisite Network and auto updates if [GitHub Updater][1] plugin is installed.

[1]: https://github.com/afragen/github-updater

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

| Parameter name      | Type     | Default value | Required | Description |
| ------------------- | -------- | ------------- |:--------:| ----------- |
| `$xml_string`       | `string` | `null`        | yes      | string containing the imported XML
| `$allow_duplicates` | `bool`   | `false`       | no       | set to `true` to allow posts with identical post_name |
| `$update_if_exists` | `bool`   | `false`       | no       | set to `true` to overwrite existing ACF post with new post_meta (sets of fields to be edited in the back-end)
