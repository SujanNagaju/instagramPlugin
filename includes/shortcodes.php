<?php
add_shortcode( 'wen_insta_feed_list', 'wen_insta_feed_list' );
function wen_insta_feed_list() {
	ob_start();
	$wen_instagram = WENInstagramAPI::get_instance();
	$response      = $wen_instagram->get_user_own_media();

	$images = $response['data'];

    //print_pre($response);
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
    <div>
        <button class="load-more-photos" data-next="<?php echo $response->next_max_id; ?>">Load More...</button>
    </div>
	<?php
	$content = ob_get_clean();

	return $content;
}