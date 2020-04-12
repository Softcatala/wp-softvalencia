<?php
// Register Custom Post Type
function guies()
{
    $labels = array(
        'name' => _x('Guies', 'Post Type General Name', 'softvalencia'),
        'singular_name' => _x('Guia', 'Post Type Singular Name', 'softvalencia'),
        'menu_name' => __('Guies', 'softvalencia'),
        'name_admin_bar' => __('Guies', 'softvalencia'),
        'archives' => __('Item Archives', 'softvalencia'),
        'attributes' => __('Item Attributes', 'softvalencia'),
        'parent_item_colon' => __('Parent Item:', 'softvalencia'),
        'all_items' => __('All Items', 'softvalencia'),
        'add_new_item' => __('Add New Item', 'softvalencia'),
        'add_new' => __('Add New', 'softvalencia'),
        'new_item' => __('New Item', 'softvalencia'),
        'edit_item' => __('Edit Item', 'softvalencia'),
        'update_item' => __('Update Item', 'softvalencia'),
        'view_item' => __('View Item', 'softvalencia'),
        'view_items' => __('View Items', 'softvalencia'),
        'search_items' => __('Search Item', 'softvalencia'),
        'not_found' => __('Not found', 'softvalencia'),
        'not_found_in_trash' => __('Not found in Trash', 'softvalencia'),
        'featured_image' => __('Featured Image', 'softvalencia'),
        'set_featured_image' => __('Set featured image', 'softvalencia'),
        'remove_featured_image' => __('Remove featured image', 'softvalencia'),
        'use_featured_image' => __('Use as featured image', 'softvalencia'),
        'insert_into_item' => __('Insert into item', 'softvalencia'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'softvalencia'),
        'items_list' => __('Items list', 'softvalencia'),
        'items_list_navigation' => __('Items list navigation', 'softvalencia'),
        'filter_items_list' => __('Filter items list', 'softvalencia'),
    );
    $args = array(
        'label' => __('Guia', 'softvalencia'),
        'description' => __('Guies', 'softvalencia'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields'),
        'taxonomies' => array('category'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'guies'),
    );
    register_post_type('guies', $args);

}

add_action('init', 'guies', 0);