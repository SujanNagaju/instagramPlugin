<?php


function test_insta_functions() {
	$instagram_instance = WENInstagramAPI::get_instance();
	$response           = $instagram_instance->get_user_own_media();
	print_pre( $response );
}

//add_action( 'wp_footer','test_insta_functions'  );

function digthis_enqueue_scripts() {
	$ver          = wp_get_theme()->get( 'Version' );
	$parent_style = 'parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style ),
		$ver
	);

	wp_register_script( 'digthis-masonry', get_theme_file_uri( 'assets/js/masonry.min.js' ), array( 'jquery' ), $ver,
		true );
	wp_register_script( 'digthis-main', get_theme_file_uri( 'assets/js/custom.js' ),
		array( 'jquery', 'digthis-masonry' ), $ver,
		true );
	wp_localize_script( 'digthis-main', 'wenInsta', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' )
	) );
	wp_enqueue_script( 'digthis-main' );

}

add_action( 'wp_enqueue_scripts', 'digthis_enqueue_scripts' );


function wen_get_more_photos() {
	$max_id = filter_input( INPUT_POST, 'next_max_id' );

	$instagram_instance = WENInstagramAPI::get_instance();
	$response           = $instagram_instance->get_user_own_media( $max_id );

	ob_start();
	// returns data & pagination info
	if ( ! is_wp_error( $response ) ) {
		foreach ( $response['data'] as $data ) {
			$image_url = $data['images']['low_resolution']['url'];
			wen_get_template_part( 'template-parts/insta-items.php',
				array( 'image_url' => $image_url ) );
		}
	}
	$content = ob_get_clean();
	wp_send_json( array(
		'items'       => $content,
		'next_max_id' => $response['pagination']['next_max_id']
	) );
}

function wen_get_template_part( $template_name, $args = false ) {
	extract( $args );
	$located = locate_template( array( $template_name ) );

	if ( $located ) {
		include $located;
	}
}

add_action( 'wp_ajax_nopriv_wen_get_more_photos', 'wen_get_more_photos' );
add_action( 'wp_ajax_wen_get_more_photos', 'wen_get_more_photos' );