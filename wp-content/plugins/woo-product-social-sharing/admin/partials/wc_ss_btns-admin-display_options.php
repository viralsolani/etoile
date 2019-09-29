<form method="post" action="<?php echo esc_html( admin_url( 'admin.php?page=' . $plugin_name . '&tab=display_options' ) ); ?>">
	
	<?php
	wp_nonce_field( 'check', 'nonce' ); ?>
	<table class="wc_ss_table">
		<tbody>
			<?php do_action( 'ss_btns_before_display_settings_themes_section' ); ?>

			<tr valign="top">
				<td>
					<span>Theme</span>
					<p>Multiple Themes so the buttons may fit into your theme!</p>
				</td>
				<td>
					<table width="100%">
						<tr>
							<td width="30%" valign="top">
								<select name="wc_ss_btn[theme]" id="wc_ss_theme_select">
									<option value="default-theme" <?php if ($options['display']['values']['theme'] == 'default-theme'):?>selected="selected"<?php endif; ?>>Default Theme</option>
									<option value="modern-theme" <?php if ($options['display']['values']['theme'] == 'modern-theme'):?>selected="selected"<?php endif; ?>>Modern Theme</option>
									<option value="modern-theme-circle" <?php if ($options['display']['values']['theme'] == 'modern-theme-circle'):?>selected="selected"<?php endif; ?>>Modern Theme (Circle)</option>
									<option value="modern-theme-rounded" <?php if ($options['display']['values']['theme'] == 'modern-theme-rounded'):?>selected="selected"<?php endif; ?>>Modern Theme (Rounded)</option>
								</select>
							</td>
							<td width="70%" valign="top">
								<strong>Preview</strong><br/>
								<small>Displaying ONLY the default social networks</small>)

								<div id="wc_ss_preview"></div>
							</td>
						</tr>
					</table>
	                
					
				</td>
			</tr>

			<?php do_action( 'ss_btns_after_display_settings_themes_section' ); ?>
			
			<?php do_action( 'ss_btns_before_display_settings_display_message_section' ); ?>

			<tr>
				<td>
					<span>Display message?</span>
				</td>
				<td>
					<label class="wc_ss_btns-switch" for="display_share_message">
						<input type="checkbox" id="display_share_message" name="wc_ss_btn[display_share_message]" <?php if ( isset($options['display']['values']['display_share_message']) ):?>checked="checked"<?php endif;?> />
						<span class="wc_ss_btns-slider round"></span>
					</label>
						<strong>Display <i>"Share this product!"</i> message?</strong>
				</td>
			</tr>

			<?php do_action( 'ss_btns_after_display_settings_display_message_section' ); ?>

			<?php do_action( 'ss_btns_before_display_settings_message_section' ); ?>
			<tr class="wc_ss_btns-display_message">
				<td>
					<span>Message</span>
					<p>Change text for <i>"<strong>Share this product!</strong>"</i> message?</p>
				</td>
				<td valign="top">
                    <input type="text" name="wc_ss_btn[share_message_text]" value="<?php echo $options['display']['values']['share_message_text']; ?>" />
				</td>
			</tr>
			<?php do_action( 'ss_btns_after_display_settings_message_section' ); ?>

			<tr>
				<td>
					<span>Heading message</span>
				</td>
				<td>
					<input type="text" name="wc_ss_btn[wc_ss_btns_heading]" value="<?php echo $options['display']['values']['wc_ss_btns_heading']; ?>" />
				</td>
			</tr>

		</tbody>
		<tfoot>
			<tr>
				<td><?php submit_button(); ?></td>
			</tr>
		</tfoot>
	</table>
	
</form>