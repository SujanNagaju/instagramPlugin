<?php
/*
Plugin Name: WEN Instagram Feed
Description: Basic Instagram Boilerplate
Plugin URI: #
Author: WEN
Author URI: #
Version: 1.0.0
License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
Text Domain: wen-instagram
*/

/**
 * Define Plugin FILE PATH
 */
if ( ! defined( 'WEN_INSTAGRAM_FILE_PATH' ) ) {
	define( 'WEN_INSTAGRAM_FILE_PATH', __FILE__ );
}
if ( ! defined( 'WEN_INSTAGRAM_DIR_PATH' ) ) {
	define( 'WEN_INSTAGRAM_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

require_once( WEN_INSTAGRAM_DIR_PATH . '/includes/helper-functions.php' );
require_once( WEN_INSTAGRAM_DIR_PATH . '/class/class-admin.php' );
require_once( WEN_INSTAGRAM_DIR_PATH . '/class/class-wen-instagram.php' );
require_once( WEN_INSTAGRAM_DIR_PATH . '/includes/shortcodes.php' );


function wen_instagram_enqueue_scripts() {
	$ver = '1.0.0';
	wp_register_script( 'wen-insta-masonry', plugins_url( 'assets/js/masonry.min.js', WEN_INSTAGRAM_FILE_PATH ),
		array( 'jquery' ), $ver,
		true );
	wp_register_script( 'wen-insta-main', plugins_url( 'assets/js/wen-instagram.js', WEN_INSTAGRAM_FILE_PATH ),
		array( 'jquery', 'wen-insta-masonry' ), $ver,
		true );
	wp_localize_script( 'wen-insta-main', 'wenInsta', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' )
	) );
	wp_enqueue_script( 'wen-insta-main' );
}

add_action( 'wp_enqueue_scripts', 'wen_instagram_enqueue_scripts' );

if ( ! function_exists( 'print_pre' ) ) {
	function print_pre( $var ) {
		echo '<pre>';
		var_dump( $var );
		echo '</pre>';
	}

}