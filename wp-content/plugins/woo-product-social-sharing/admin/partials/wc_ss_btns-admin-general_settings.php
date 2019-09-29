<form method="post" action="<?php echo esc_html( admin_url( 'admin.php?page=' . $plugin_name . '&tab=general_settings' ) ); ?>">

	<?php
	wp_nonce_field( 'check', 'nonce' ); ?>

	<table class="wc_ss_table">
		<tbody>
			<?php do_action( 'ss_btns_before_general_settings_positions_section' ); ?>
			<tr valign="top">
				<td>
					<span>Position(s)</span>
					<small><strong>YES!</strong> you can select more then one position to display <strong>Social Sharing</strong></small>
				</td>
				<td>
					<?php if ( !class_exists( 'WooCommerce' ) ): ?>
					<p class="wc_ss_btns-notice wc_ss_btns-notice-warning">
						<strong>NOTE:</strong> <strong>WooCommerce</strong> is deactivated or not installed! These position option will be available when <strong>WooCommerce</strong> is activated!
					</p>
					<?php else: ?>
                    <ul class="wc_ss_btns-settings">
                    	<?php
                    	$i = 0;
                    	foreach ( $options['general_settings']['keys'] as $position ): ?>
                    		<li>
	                    		<label class="wc_ss_btns-img-radio-btn" for="pos_<?php echo $position['action']; ?>">
		                    		<input type="checkbox" id="pos_<?php echo $position['action']; ?>" name="wc_ss_btn[general_settings][<?php echo $position['action']; ?>]" <?php if (isset($options['general_settings']['values'][$position['action']])):?>checked<?php endif;?> />
		                    		On <?php echo ucwords(str_replace(array("_", "woocommerce"),array(" ", ""), $position['label'])); ?> section <?php if ( $i == 0 ) echo '<strong><i>(default)</i></strong>'; ?>
		                    		<img src="<?php echo plugins_url( '', __FILE__ ) . '/../images/placement-' . $position["label"] . '.png'; ?>" alt="">
	                    		</label>
                    				
                    		</li>
                    	<?php
                    		$i++;
                    	endforeach; ?>
                    </ul>
					<?php endif; ?>
				</td>
			</tr>
			<?php do_action( 'ss_btns_after_general_settings_positions_section' ); ?>
			
			<?php do_action( 'ss_btns_before_general_settings_floating_mode_section' ); ?>
			<tr>
				<td>
					<span>Enable Floating Mode</span>
					<p>This enables <strong>ShareIt! Social Buttons</strong> to be displayed on your Website</p>
				</td>
				<td>
					<table width="100%">
						<tr>
							<td width="25%">
			            		<label class="wc_ss_btns-switch" for="enable_floating_mode">
									<input type="checkbox" id="enable_floating_mode" name="wc_ss_btn[floating_mode][enabled]" <?php if ($options['general_settings']['floating_mode']['enabled'] == 'true'):?>checked="checked"<?php endif;?> />
									<span class="wc_ss_btns-slider round"></span>
			            		<!-- Enable Floating Mode -->
			            		</label>
								
							</td>
							<td width="75%">
								<p class="wc_ss_btns-notice wc_ss_btns-notice-info">
									<strong>NOTE:</strong> <strong>Floating Mode</strong> is automatically enabled if <strong>WooCommerce</strong> is not activated! In this way you website will still have <strong>ShareIt! Social Buttons</strong> displayed on your Website on Pages and Posts!
								</p>
								
							</td>
						</tr>
					</table>

				</td>
			</tr>
			<tr class="wc_ss_btns-float-post-types" <?php if ($options['general_settings']['floating_mode']['enabled'] == 'true'):?>style="display:table-row;"<?php endif; ?>>
				<td>
					<span>Post Types</span>
					<p>Check here on which type of posts do you want Social Buttons to be displayed!</p>
				</td>
				<td valign="top">
					<?php
					$post_types = get_post_types(array('public'=>true));
						
					?><ul class="wc_ss_btns-settings"><?php
					foreach ( $post_types as $posttype ) {
						if ( in_array( $posttype, $options['general_settings']['floating_mode']['post_types']['restricted_post_types'] ) )
							continue;
						?>
						<li>
                    		<label class="wc_ss_btns-switch" for="pos_<?php echo $posttype; ?>">
								<input type="checkbox" id="pos_<?php echo $posttype; ?>" name="wc_ss_btn[floating_mode][post_types][enabled_post_types][]" value="<?php echo $posttype; ?>" <?php if (in_array($posttype, $options['general_settings']['floating_mode']['post_types']['enabled_post_types'])):?>checked="checked"<?php endif;?> />
								<span class="wc_ss_btns-slider round"></span>
                    		</label>
	                    	<?php echo ucwords($posttype); ?>
						</li>
						<?php
					}
					?>
					</ul>
				</td>
			</tr>
			<tr class="wc_ss_btns-float-positions" <?php if ($options['general_settings']['floating_mode']['enabled'] == 'true'):?>style="display:table-row;"<?php endif; ?>>
				<td>
					<span>Float positions</span>
					<p>Check on which side of the screen you want the buttons to be displayed! Default: left</p>
				</td>
				<td valign="top">
					<ul class="wc_ss_btns-settings">
					<?php
					foreach ( $options['general_settings']['floating_mode']['positions']['available_positions'] as $fm_position ) {
						?>
						<li>
                    		<label class="wc_ss_btns-img-radio-btn" for="pos_<?php echo $fm_position; ?>">
								<input type="radio" id="pos_<?php echo $fm_position; ?>" name="wc_ss_btn[floating_mode][positions][enabled_positions]" value="<?php echo $fm_position; ?>" <?php if ($fm_position == $options['general_settings']['floating_mode']['positions']['enabled_positions']):?>checked="checked"<?php endif;?> />
	                    		<img src="<?php echo plugins_url( '', __FILE__ ) . '/../images/position-' . $fm_position . '.png'; ?>" alt="">
                    		</label>
						</li>
						<?php
					}
					?>
					</ul>
				</td>
			</tr>
			<?php do_action( 'ss_btns_after_general_settings_floating_mode_section' ); ?>
		</tbody>
		<tfoot>
			<tr>
				<td><?php submit_button(); ?></td>
			</tr>
		</tfoot>
	</table>
</form>