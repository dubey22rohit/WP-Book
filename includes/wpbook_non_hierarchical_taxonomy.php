<?php
function wpbook_non_hierarchical_taxonomy() {
 $labels = array(
    'name' => __('Book Tags', 'wp-book'),
    'singular_name' => __('Book Tag', 'wp-book'),
    'all_items' => __('All Book Tags', 'wp-book'),
    'parent_item' => __('Parent Book Tag', 'wp-book'),
    'parent_item_colon' => __('Parent Book Tag:', 'wp-book'),
    'add_new_item' => __('Add New Book Tag', 'wp-book'),
    'new_item_name' => __('New Book Tag Name', 'wp-book'),
    'edit_item' => __('Edit Book Tag', 'wp-book'),
    'update_item' => __('Update Book Tag', 'wp-book'),
    'search_items' =>  __('Search Book Tag', 'wp-book'),
    'menu_name' => __('Book Tags', 'wp-book'),
  );    

  $args = array(
    'rewrite' => array( 'slug' => 'book_tags' ),
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
  );
register_taxonomy('book_tags',array('book'), $args);
 
}
add_action( 'init', 'wpbook_non_hierarchical_taxonomy' );
