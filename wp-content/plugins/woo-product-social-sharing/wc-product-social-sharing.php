<?php
/**
 * @link              https://defthemes.com
 * @since             1.0.0
 * @package           Wc_ss_btns
 *
 * Plugin Name:       ShareIt! Social Buttons
 * Plugin URI:        https://defthemes.com/woocommerce-product-social-sharing-plugin/?utm_source=Plugin
 * Description:       ShareIt! Social Buttons is a powerful, extandable social sharing plugin that helps you integrate all the top social networks. Beautifully.
 * Version:           1.8.4
 * Author:            DefThemes
 * Author URI:        https://defthemes.com/woocommerce-product-social-sharing-plugin/?utm_source=Plugin
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc_ss_btns
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc_ss_btns-activator.php
 */
function activate_wc_ss_btns() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc_ss_btns-activator.php';
	Wc_ss_btns_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc_ss_btns-deactivator.php
 */
function deactivate_wc_ss_btns() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc_ss_btns-deactivator.php';
	Wc_ss_btns_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_ss_btns' );
register_deactivation_hook( __FILE__, 'deactivate_wc_ss_btns' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc_ss_btns.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_ss_btns() {

	$plugin = new Wc_ss_btns( plugin_basename(__FILE__) );
	$plugin->run( );

}
run_wc_ss_btns();
