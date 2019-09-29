<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://defthemes.com
 * @since      1.0.0
 *
 * @package    Wc_ss_btns
 * @subpackage Wc_ss_btns/admin/partials
 */


?>

<div class="wrap">

 	<h2><?php echo esc_html( get_admin_page_title() ); ?> Settings</h2>

	<?php if ( isset($update) && $update ): ?>
	<div class="updated notice">
		<p>Settings updated successfully!</p>
	</div>
	<?php elseif ( isset($update) && !$update ): ?>
	<div class="error notice">
		<p>No changes were made!</p>
	</div>
	<?php endif; ?>

	<?php
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general_settings';
	?>

	<h2 class="nav-tab-wrapper">
		<?php do_action( 'ss_btns_before_tabbed_nav_about_link' ); ?>
		<a href="?page=<?php echo $plugin_name; ?>&tab=about"  class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>">About</a>
		<?php do_action( 'ss_btns_after_tabbed_nav_about_link' ); ?>

		<?php do_action( 'ss_btns_before_tabbed_nav_general_settings_link' ); ?>
        <a href="?page=<?php echo $plugin_name; ?>&tab=general_settings"  class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>">General Settings</a>
        <?php do_action( 'ss_btns_after_tabbed_nav_general_settings_link' ); ?>

        <?php do_action( 'ss_btns_before_tabbed_nav_networks_link' ); ?>
        <a href="?page=<?php echo $plugin_name; ?>&tab=networks"  class="nav-tab <?php echo $active_tab == 'networks' ? 'nav-tab-active' : ''; ?>">Networks</a>
        <?php do_action( 'ss_btns_after_tabbed_nav_networks_link' ); ?>

        <?php do_action( 'ss_btns_before_tabbed_nav_display_options_link' ); ?>
        <a href="?page=<?php echo $plugin_name; ?>&tab=display_options"  class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>">Display Options</a>
        <?php do_action( 'ss_btns_after_tabbed_nav_display_options_link' ); ?>

        <?php do_action( 'ss_btns_before_tabbed_nav_extensions_link' ); ?>
        <!-- <a href="?page=<?php echo $plugin_name; ?>&tab=extensions"  class="nav-tab <?php echo $active_tab == 'extensions' ? 'nav-tab-active' : ''; ?>">Extensions</a> -->
        <?php do_action( 'ss_btns_after_tabbed_nav_extensions_link' ); ?>

        <?php do_action( 'ss_btns_after_tabbed_nav' ); ?>
    </h2>

    
 	<?php require plugin_dir_path( __FILE__ ) . 'wc_ss_btns-admin-' . $active_tab . '.php'; ?>


 	<?php do_action( 'ss_btns_after_settings_page' ); ?>
    
 
</div><!-- .wrap -->

