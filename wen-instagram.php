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

require_once( WEN_INSTAGRAM_DIR_PATH . '/class/class-admin.php' );
require_once( WEN_INSTAGRAM_DIR_PATH . '/class/class-wen-instagram.php' );

if ( ! function_exists( 'print_pre' ) ) {
	function print_pre( $var ) {
		echo '<pre>';
		var_dump( $var );
		echo '</pre>';
	}

}