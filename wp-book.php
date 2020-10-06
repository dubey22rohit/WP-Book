<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              rohitdubey22.wordpress.com
 * @since             1.0.0
 * @package           Wp_book
 *
 * @wordpress-plugin
 * Plugin Name:       WP-Book
 * Plugin URI:        rohitdubey22.wordpress.com
 * Description:       Creates a plugin named WP Book (wp-book),Creates a custom hierarchical taxonomy Book Category,Creates a custom non-hierarchical taxonomy Book Tag,Creates a custom meta box to save book meta information like Author Name, Price, Publisher, Year, Edition, URL, etc.
 * Version:           1.0.0
 * Author:            Rohit Dubey
 * Author URI:        rohitdubey22.wordpress.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_book
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_BOOK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp_book-activator.php
 */
function activate_wp_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp_book-activator.php';
	Wp_book_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp_book-deactivator.php
 */
function deactivate_wp_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp_book-deactivator.php';
	Wp_book_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_book' );
register_deactivation_hook( __FILE__, 'deactivate_wp_book' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp_book.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_book() {

	$plugin = new Wp_book();
	$plugin->run();

}
run_wp_book();
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
$mpb_prefix = 'wpbook_';
$mpb_plugin_name = 'wp-book';
$wpbook_settings = get_option('wpbook_settings');

load_plugin_textdomain('wp-book', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );

include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_post_type.php');   
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_hierarchical_taxonomy.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_non_hierarchical_taxonomy.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_custom_metabox.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_admin_settings_page.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_shortcode.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_category_widget.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_selected_category_display.php');
include(plugin_dir_path( dirname( __FILE__ ) ).'WP-BOOK/includes/wpbook_dashboard_widget.php');

 
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