<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
		<div class="top-header">
			<div class="col-full">
				<div class="pull-left top-contact">
					<span>Free shipping on all orders within India*</span>
				</div>
				<div class="top-socialicon pull-right">
					<ul>
					  <li><span><?php echo the_field( 'phone', 'option' )?></span><a href="<?php echo the_field( 'contact_phone_number', 'option' )?>" title="<?php echo the_field( 'contact_phone_number', 'option' )?>"><?php echo the_field( 'contact_phone_number', 'option' )?></a></li>
					  <li><a href="my-account" title="My Account">My Account</a></li>
					  
					  <?php if(is_user_logged_in()) { ?>
							<li><a href="<?php echo get_site_url().'/logout'; ?>" title="Logout" class="phoen-login-signup-popup-open">Logout</a></li>
					  <?php }else{ ?>
							<li><a href="<?php echo get_site_url().'/login'; ?>" title="Login" class="phoen-login-signup-popup-open">Login</a></li>
					 <?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<?php
		/**
		 * Functions hooked into storefront_header action
		 *
		 * @hooked storefront_header_container                 - 0
		 * @hooked storefront_skip_links                       - 5
		 * @hooked storefront_social_icons                     - 10
		 * @hooked storefront_site_branding                    - 20
		 * @hooked storefront_secondary_navigation             - 30
		 * @hooked storefront_product_search                   - 40
		 * @hooked storefront_header_container_close           - 41
		 * @hooked storefront_primary_navigation_wrapper       - 42
		 * @hooked storefront_primary_navigation               - 50
		 * @hooked storefront_header_cart                      - 60
		 * @hooked storefront_primary_navigation_wrapper_close - 68
		 */
		do_action( 'storefront_header' );
		?>

	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action( 'storefront_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">
	   <div id="slider-div"> <?php if(is_front_page()){ echo do_shortcode('[metaslider id="102"]'); }   ?>  </div>
		<div class="col-full">

		<?php
		do_action( 'storefront_content_top' );
