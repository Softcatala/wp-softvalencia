<?php
/*
Template Name: foobar
*/

$args = array(
    'post_type' => array('guies'),
    'post_status' => 'publish',
    'order' => 'DESC',
    'orderby' => 'date',
    'posts_per_page' => 30
);

// WP_Query
$eq_query = new WP_Query( $args );
if ($eq_query->have_posts()) {

    while ($eq_query->have_posts()) {
        $eq_query->the_post();

        $photo_name = get_field("mf-imatge");

        $field_hash = 'field_5e93012f98762';

        if ($photo_name != "") {

            $ff = '/var/www/softvalencia.org/htdocs/wp-content/files_mf/' . $photo_name;
            $handle = fopen($ff, "r");
            $ffcontents = fread($handle, filesize($ff));
            $attachment = wp_upload_bits($photo_name, null, $ffcontents);

            $filetype = wp_check_filetype(basename($attachment['file']), null);

            $postinfo = array(
                'post_mime_type' => $filetype['type'],
                'post_title' => $post->post_title . ' ' . "> Imatge",
                'post_content' => '',
                'post_status' => 'inherit'
            );
            echo $filename = $attachment['file'];
            echo $attach_id = wp_insert_attachment($postinfo, $filename, $post->ID);

            if (!function_exists('wp_generate_attachment_data'))
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
            wp_update_attachment_metadata($attach_id, $attach_data);

            update_post_meta($post->ID, "_imatge", $field_hash);
            update_post_meta($post->ID, "imatge", $attach_id);
            update_field($field_hash, $attach_id, $post->ID);
        }
    }
    wp_reset_query();
}


