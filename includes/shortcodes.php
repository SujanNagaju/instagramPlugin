<?php
add_shortcode( 'wen_insta_feed_list', 'wen_insta_feed_list' );
function wen_insta_feed_list() {
	ob_start();
	$wen_instagram = WENInstagramAPI::get_instance();
	$response      = $wen_instagram->get_user_own_media();

	$images = $response['data'];


	?>
    <div  class="wen-instagram-grid">
		<?php
		foreach ( $images as $image ) {
			$image_url = $image['images']['thumbnail']['url'];
			wen_get_template_part( 'template-parts/insta-items.php',
				array( 'image_url' => $image_url ) );
		}
		?>
    </div>
	<?php
	$content = ob_get_clean();

	return $content;
}