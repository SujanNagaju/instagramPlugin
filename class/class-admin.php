<?php

/**
 * Class plugin_admin
 */
class plugin_admin {
	public static $instance;
	public $settings = '';
	public $plugin_url = 'wen-instagram-page';
	private $message = null;

	/**
	 * @return plugin_admin
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * plugin_admin constructor.
	 */
	public function __construct() {
		/*load dependencies if required*/
		$this->load_dependencies();
		add_action( 'admin_menu', array( $this, 'admin_menu_page' ) );
		add_action( 'admin_init', array( $this, 'save_settings' ) );

	}

	public function load_dependencies() {

	}

	public function admin_menu_page() {
		add_menu_page(
			'Plugin Title',
			'Plugin Dashboard Title',
			'manage_options',
			$this->plugin_url,
			array( $this, 'generate_admin_page' )
		);

	}

	public function generate_admin_page() {
		require_once( WEN_INSTAGRAM_DIR_PATH . '/includes/views/admin.php' );
	}

	public function save_settings() {
		if ( ! empty( $_POST['digthis_instagram_settings_nonce'] ) && wp_verify_nonce( $_POST['digthis_instagram_settings_nonce'], 'verify_digthis_instagram_settings_nonce' ) ) {
			/*Bail Early*/
			if ( ! current_user_can( 'manage_options' ) ) {
				return false;
			}
			$config = array();
			if ( ! empty( $_POST['email'] ) && ! empty( $_POST['email'] ) ) {
				$config['email'] = $_POST['email'];
			}
			if ( ! empty( $_POST['api-key'] ) && ! empty( $_POST['api-key'] ) ) {
				$config['api-key'] = $_POST['api-key'];
			}
			update_option( 'my_plugin_settings', $config );
			$this->set_message( 'updated', 'Settings Saved' );
		}

		$this->settings = get_option( 'my_plugin_settings' );
	}

	public function set_message( $class, $message ) {
		$this->message = '<div class=' . $class . '>' . $message . '</div>';
	}

	public function get_message() {
		return $this->message;
	}

}

/* Instantiate new class on plugins_loaded, best place to do this in MHO */
add_action( 'plugins_loaded', array( 'plugin_admin', 'get_instance' ) );