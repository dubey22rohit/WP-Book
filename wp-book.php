<?php

/*
    Plugin Name: WP-Book
    Description: Creates a plugin named WP Book (wp-book),Creates a custom hierarchical taxonomy Book Category,Creates a custom non-hierarchical taxonomy Book Tag,Creates a custom meta box to save book meta information like Author Name, Price, Publisher, Year, Edition, URL, etc.
    Author:Rohit Dubey
    Version : 1.0
*/

$mpb_prefix = 'wpbook_';
$mpb_plugin_name = 'WP-Book';
$wpbook_settings = get_option('wpbook_settings');

load_plugin_textdomain('wp-book', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );

include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_post_type.php');   
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_hierarchical_taxonomy.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_non_hierarchical_taxonomy.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_custom_metabox.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_admin_settings_page.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_shortcode.php');

 
function wpbook_custom_meta_table(){ 
    global $db;
    $table_name = $db->prefix.'bookmeta';

    if( $db->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name){

        $sql = "CREATE TABLE  $table_name (
            meta_id INTEGER (10) UNSIGNED AUTO_INCREMENT,
            book_id bigint(20) NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY  (meta_id),
            KEY book_id (book_id),
            KEY meta_key(meta_key)
        )";

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    }
}
register_activation_hook( __FILE__, 'wpbook_custom_meta_table' );

function wpbook_register_custom_table() {

    global $db;

    $db->bookmeta = $db->prefix . 'bookmeta';
    $db->tables[] = 'bookmeta';
    
    return;
}

add_action( 'init', 'wpbook_register_custom_table' );
add_action( 'switch_blog', 'wpbook_register_custom_table' );