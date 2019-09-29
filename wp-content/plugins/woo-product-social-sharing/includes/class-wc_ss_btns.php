<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://defthemes.com
 * @since      1.0.0
 *
 * @package    Wc_ss_btns
 * @subpackage Wc_ss_btns/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wc_ss_btns
 * @subpackage Wc_ss_btns/includes
 * @author     DefThemes <defthemes@gmail.com>
 */
class Wc_ss_btns {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wc_ss_btns_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	public $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	public $version;

	public $options;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_basename ) {
		$this->plugin_name 		= 'wc_ss_btns';
		$this->plugin_basename 	= $plugin_basename;
		$this->version 			= '1.8.4';

		$this->options 		= ( get_option( 'wc_ss_btns_options' ) ) ? json_decode( get_option( 'wc_ss_btns_options' ), true) : null;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wc_ss_btns_Loader. Orchestrates the hooks of the plugin.
	 * - Wc_ss_btns_i18n. Defines internationalization functionality.
	 * - Wc_ss_btns_Admin. Defines all hooks for the admin area.
	 * - Wc_ss_btns_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc_ss_btns-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc_ss_btns-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wc_ss_btns-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wc_ss_btns-public.php';

		$this->loader = new Wc_ss_btns_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wc_ss_btns_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wc_ss_btns_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wc_ss_btns_Admin( $this->get_plugin_name(), $this->get_version() );

		// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_submenu', 80 );

		$this->loader->add_filter( 'plugin_action_links_' . $this->plugin_basename, $plugin_admin, 'add_action_links' );

		// Adding filter for "Spread the love!" text && "Share this product!" message in Display Settings
		$this->loader->add_filter( 'ss_btns_heading', $plugin_admin, 'ss_btns_filter_heading'  );
		$this->loader->add_filter( 'ss_btns_message', $plugin_admin, 'ss_btns_filter_message'  );


		$this->loader->add_action( 'ss_btns_after_settings_page', $plugin_admin, 'add_thankyou_msg' );
		$this->loader->add_action( 'ss_btns_after_tabbed_nav', $plugin_admin, 'add_version_msg' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public 	= new Wc_ss_btns_Public( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		// Check if we have WooCommerce activated or floating mode enabled
		if ( !$this->check_wc() )
		{
			// WooCommerce is deactivated or not installed
			// Setting the plugin to run independently in Float mode
			$this->options['general_settings']['floating_mode']['enabled'] = true;
			update_site_option( 'wc_ss_btns_options', json_encode( $this->options ) );

			$this->loader->add_action( 'wp_footer', $plugin_public, 'display_ss_btns' );
		}
		// even if floating mode is enabled 
		else
		{
			if ( !is_null( $this->options ) )
			{
				if ( $this->options['general_settings']['floating_mode']['enabled'] == true )
					$this->loader->add_action( 'wp_footer', $plugin_public, 'display_ss_btns' );
				
				foreach ( $this->options['general_settings']['keys'] as $position )
				{
					$action = $position['action'];
					if ( isset($this->options['general_settings']['values'][$action]) )
					{
						$this->loader->add_action( $action, $plugin_public, 'display_ss_btns' );
					}
				}
			}
		}
	}

	/**
	 * Check if WooCommerce is activated or not
	 * 
	 * @return boolean 
	 * @since  1.7
	 */
	public function check_wc()
	{
		return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wc_ss_btns_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Debug
	 * 
	 * @param  array $what 
	 * @return preformatted
	 */
	public function debug($what) {
		echo'<pre>';var_dump($what);echo'</pre>';
	}

}
