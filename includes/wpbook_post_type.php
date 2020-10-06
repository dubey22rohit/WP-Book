<?php
function wpbook_register_post_type() {
 
	$labels = array(
		'name'               => __('Books', 'wp-book'),
		'singular_name'      => __('Book', 'wp-book') ,
		'menu_name'          => __('Books', 'wp-book'),
		'new_item'           => __('New Book', 'wp-book'),
		'add_new'            => __('Add New', 'wp-book'),
		'add_new_item'       => __('Add New Book', 'wp-book'),
		'all_items'          => __('All Books', 'wp-book'),
		'view_item'          => __('View Book', 'wp-book'),
		'edit_item'          => __('Edit Book', 'wp-book'),
		'search_items'       => __('Search Books', 'wp-book'),
		'not_found'          =>  __('Looks like there are no books','wp-book'),
		'not_found_in_trash' => __('Looks like there are no books in Trash', 'wp-book'),
		'parent_item_colon'  => __('', 'wp-book'),
	);
 
	$args = array(
		'capability_type'    => 'post',
		'supports'           => array( 'title', 'excerpts','comments', 'editor' ),
        'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'rewrite'            => array( 'slug' => 'book' ),
	);
register_post_type( 'book', $args );
}
add_action( 'init', 'wpbook_register_post_type' );