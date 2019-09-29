<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://defthemes.com
 * @since      1.0.0
 *
 * @package    Wc_ss_btns
 * @subpackage Wc_ss_btns/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_ss_btns
 * @subpackage Wc_ss_btns/admin
 * @author     DefThemes <defthemes@gmail.com>
 */
class Wc_ss_btns_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       	The name of this plugin.
	 * @param    string    $version    			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name 	= $plugin_name;
		$this->version 		= $version;
		
		$this->options 		= json_decode( get_option( 'wc_ss_btns_options' ), true);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_ss_btns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_ss_btns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc_ss_btns-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name . '-si', plugin_dir_url( __FILE__ ) . '../public/css/icons/socicon.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_ss_btns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_ss_btns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc_ss_btns-admin.js', array( 'jquery' ), $this->version, false );

		// Register the script
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc_ss_btns-admin.js' );

		wp_localize_script( $this->plugin_name, 'WCsspluginInfo', array(
			'pluginsUrl' 	=> plugins_url( '', __FILE__ )
		));

		// Enqueued script with localized data.
		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Add submenu item to WordPress's admin menu
	 */
	public function add_submenu()
	{
		$adm_page = add_menu_page( 
			__('ShareIt!'), 
			__('ShareIt!'), 
			'manage_options', 
			$this->plugin_name, 
			array( $this, 'wc_ss_btns_settings') , 
			'dashicons-share-alt2', 
			99 );

		add_action( 'admin_print_styles-' . $adm_page, array( $this, 'enqueue_styles' ) );

		add_action( 'admin_print_scripts-' . $adm_page, array( $this, 'enqueue_scripts' ) );
	}

	public function add_thankyou_msg()
	{
		echo '<p class="ss_btns_thankyou_msg footer">
			Thank you for using my plugin! Please spread the word by rating <strong>ShareIt!</strong> <a href="https://wordpress.org/support/view/plugin-reviews/woo-product-social-sharing?filter=5">★★★★★</a> on <a href="https://wordpress.org/support/view/plugin-reviews/woo-product-social-sharing?filter=5">WordPress.org</a>!
		</p>';
	}

	public function add_version_msg()
	{
		echo '<p class="ss_btns_version_msg">ShareIt! v' . $this->version . '<p>';
	}

	public function add_action_links( $links )
	{
		$links[] = '<a href="'. esc_url( admin_url('admin.php?page=' . $this->plugin_name . '&tab=general_settings' ) ) .'">Settings</a>';

		// $links[] = '<a href="'. esc_url( admin_url('admin.php?page=' . $this->plugin_name . '&tab=extensions' ) ) .'">Extensions</a>';
		return $links;
	}

	/**
	 * Render Admin Settings page
	 */
	public function wc_ss_btns_settings()
	{
		$plugin_name = $this->plugin_name;

		$options 	= $this->options;

		$version 	= $this->version;

		/**
		 * Save new settings
		 */
		if ($_POST)
		{
			if ( wp_verify_nonce( $_POST['nonce'], 'check' ) > 0 )
			{
				$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general_settings';

				$array 	= $_POST['wc_ss_btn'];

				if ( $active_tab == 'general_settings' )
				{
					$options['general_settings']['values'] 			= $array['general_settings'];
					
					if (isset($array['floating_mode']['enabled']))
					{
						$array['floating_mode']['enabled'] = true;
						$array['floating_mode']['post_types']['restricted_post_types'] = array('attachment', 'product');
						$array['floating_mode']['positions']['available_positions'] = array(
							'left', 'right'
						);

						$options['general_settings']['floating_mode']	= $array['floating_mode'];
					}
					else
					{
						$options['general_settings']['floating_mode']['enabled'] = false;
					}
				}
				if ( $active_tab == 'networks' )
				{
					$options['networks']['values'] = $array;
				}
				if ( $active_tab == 'display_options' )
				{
					$options['display']['values'] = $array;
				}

				$update = update_option( 'wc_ss_btns_options', json_encode( $options ) );
			}
		}

		require plugin_dir_path( __FILE__ ) . 'partials/wc_ss_btns-admin-display.php';
	}

	// Render "Spread the love!" heading text
	public function ss_btns_filter_heading($message) {
		$options 	= $this->options;

		$options['display']['values']['wc_ss_btns_heading'] = $message;

		$update = update_option( 'wc_ss_btns_options', json_encode( $options ) );
		
		return _e( $message, 'wc_ss_btns' );
	}

	// Render "Share this product!" message
	public function ss_btns_filter_message($message) {
		$options 	= $this->options;

		$options['display']['values']['share_message_text'] = $message;

		$update = update_option( 'wc_ss_btns_options', json_encode( $options ) );
		
		return _e( $message, 'wc_ss_btns' );
	}

	private function debug( $what )
	{
		echo '<pre>';
		var_dump( $what );
		echo '</pre>';
	}
}
