<?php


function wen_get_more_photos() {
	$max_id = filter_input( INPUT_POST, 'next_max_id' );

	$instagram_instance = WENInstagramAPI::get_instance();
	$response           = $instagram_instance->get_user_own_media( $max_id );

	ob_start();
	// returns data & pagination info
	if ( ! is_wp_error( $response ) ) {
		foreach ( $response['data'] as $data ) {
			$image_url = $data['images']['thumbnail']['url'];
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
	} else {
		include WEN_INSTAGRAM_DIR_PATH . '/frontend/insta-items.php';
	}
}

add_action( 'wp_ajax_nopriv_wen_get_more_photos', 'wen_get_more_photos' );
add_action( 'wp_ajax_wen_get_more_photos', 'wen_get_more_photos' );