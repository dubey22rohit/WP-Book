<?php
 function wpbook_hierarchical_taxonomy() {
 

  $labels = array(
    'name' => __('Categories', 'wp-book'),
    'singular_name' => __('Category', 'wp-book'),
    'all_items' => __('All Categories', 'wp-book'),
    'parent_item' => __('Parent Category','wp-book'),
    'parent_item_colon' => __('Parent Category:', 'wp-book'),
    'add_new_item' => __('Add New Category', 'wp-book'),
    'new_item_name' => __('New Category Name', 'wp-book'),
    'edit_item' => __('Edit Category', 'wp-book'),
    'update_item' => __('Update Category', 'wp-book'),
    'menu_name' => __('Categories', 'wp-book'),
    'search_items' =>  __('Search Category', 'wp-book'),
    'orderby' => 'count',
  );   

  $args = array(
    'rewrite' => array( 'slug' => 'book_category' ),
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
  ); 
register_taxonomy('book_category',array('book'), $args);
 
}
add_action( 'init', 'wpbook_hierarchical_taxonomy' );

function wpbook_order_by_args( $args, $taxonomies ) 
{
    
    $args['orderby'] = 'count';
    $args['order'] = 'DESC';
    return $args; 
    
}
add_filter( 'get_terms_args', 'wpbook_order_by_args', 10, 2 );