<?php

class WENInstagramAPI {
	public static $instance;
	private $access_token = '1221685340.3a81a9f.51faf13950df4cef984a146d3f3fd267';

	/**
	 * @return WENInstagramAPI
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * @param $url
	 *
	 * @return array|string|WP_Error
	 */
	public function get_request( $url ) {
		try {
			$response = wp_remote_get( $url );
		} catch ( Exception $e ) {
			$response = 'Caught exception: ' . $e->getMessage();
		}

		return $response;
	}


	/**
	 * @return array|string|WP_Error
	 */
	public function get_user_own_media( $max_id = '' ) {
		$url         = 'https://api.instagram.com/v1/users/self/media/recent/';


		if ( $max_id != '' ) {
			$max_id = '&max_id' . $max_id;
		}

		$args        = array(
			'access_token' => $this->access_token,
			'max_id'       => $max_id
		);
		$request_url = add_query_arg( $args, $url );
		//$url    = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $this->access_token;
		$result = $this->get_request( $request_url );

		if ( $result['response']['code'] == '200' ) {
			$response = json_decode( $result['body'], true );
		} else {
			$error    = json_decode( $result['body'], true );
			$response = new WP_Error( $error['meta']['code'],
				$error['meta']['error_type'] . ' : ' . $error['meta']['error_message'],
				$error );
		}


		return $response;
	}
}