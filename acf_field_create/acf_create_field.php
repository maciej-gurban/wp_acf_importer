<?php

function insert_acf_field( $xml_string, $allow_duplicates = false ) {

    // Parse ACF post's XML
    $content = simplexml_load_string( $xml_string, 'SimpleXMLElement', LIBXML_NOCDATA); 

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

    $the_post = get_page_by_title($content->channel->item->title, 'OBJECT', 'acf');

    # Execute only if doesn't exist already
    if ( !$the_post || $allow_duplicates == true ) {
        $post_id = wp_insert_post( $wp_post_data );
    }
    else {
        $post_id = $the_post->ID;
    }

    $wp_post_meta = $content->channel->item->children('wp', true);

    if( $wp_post_meta ) {
        foreach ( $wp_post_meta as $row) {

            // Choose only arrays (postmeta)
            if( count($row) > 0) {
                // using addlashes on meta values to compensate for stripslashes() that will be run upon import
                update_post_meta( $post_id, $row->meta_key, addslashes( $row->meta_value ) );
            }

        }
    }
}

?>