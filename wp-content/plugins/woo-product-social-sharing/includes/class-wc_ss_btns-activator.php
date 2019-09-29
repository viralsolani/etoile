<?php

/**
 * Fired during plugin activation
 *
 * @link       http://defthemes.com
 * @since      1.0.0
 *
 * @package    Wc_ss_btns
 * @subpackage Wc_ss_btns/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wc_ss_btns
 * @subpackage Wc_ss_btns/includes
 * @author     DefThemes <defthemes@gmail.com>
 */
class Wc_ss_btns_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.1
	 */
	public static function activate()
	{

		$wc_ss_btns_option = array(
			'general_settings' => array(
				'keys' => array(
					array(
						'label' => 'woocommerce_share',
						'action' => 'woocommerce_share'
					),
					array(
						'label' => 'woocommerce_after_single_product_summary',
						'action' => 'woocommerce_after_single_product_summary'
					),
					array(
						'label' => 'woocommerce_before_single_product',
						'action' => 'woocommerce_before_single_product'
					),
					array(
						'label' => 'woocommerce_after_single_product',
						'action' => 'woocommerce_after_single_product'
					),
					array(
						'label' => 'woocommerce_after_add_to_cart_form',
						'action' => 'woocommerce_after_add_to_cart_form'
					)
				),
				'values' => array(
					'woocommerce_share' 	=> true
				),
				'floating_mode' => array(
					'enabled' => true,
					'post_types' => array(
						'restricted_post_types' => array('attachment', 'product'),
						'enabled_post_types' => array('post', 'page')
					),
					'positions' => array(
						'available_positions' => array(
							'left','right'
						),
						'enabled_positions' => 'left'
					)
				)
			),
			'networks' => array(
				'keys' => array(
					'facebook', 'twitter', 'google', 'linkedin',
					'pinterest', 'reddit', 'delicious', 'buffer',
					'digg', 'tumblr', 'stumbleupon', 'blogger',
					'yahoo', 'skype', 'viber', 'whatsapp',
					'email'
				),
				'values' => array(
					'facebook' 				=> true,
					'twitter' 				=> true,
					'email' 				=> true
				)
			),
			'display' => array(
				'values' => array(
					'theme' 				=> 'default-theme',
					'display_share_message' => true,
					'share_message_text' 	=> 'Share this product!',
					'wc_ss_btns_heading'	=> 'Spread the love!'
				)
			)
		);

		update_site_option( 'wc_ss_btns_options', json_encode( $wc_ss_btns_option ) );
	}

}
