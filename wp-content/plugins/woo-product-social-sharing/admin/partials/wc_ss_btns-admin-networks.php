<form method="post" action="<?php echo esc_html( admin_url( 'admin.php?page=' . $plugin_name . '&tab=networks' ) ); ?>">

	<?php
	wp_nonce_field( 'check', 'nonce' ); ?>

	<table class="wc_ss_table">
		<tbody>
			<?php do_action( 'ss_btns_before_network_settings' ); ?>
			<tr valign="top">
				<td>
					<span>Social Networks</span>
					<small><strong>YES!</strong> you can NOW check which social network to use and display</small>
				</td>
				<td>
					<table width="200px" class="wc_ss_btns-networks-table">
                    	<?php
                    	$i = 0;
                    	foreach ( $options['networks']['keys'] as $network ): ?>
						<tr>
							<td>
	                    		<label class="wc_ss_btns-switch" for="pos_<?php echo $network; ?>">
		                    		<input type="checkbox" id="pos_<?php echo $network; ?>" name="wc_ss_btn[<?php echo $network; ?>]" <?php if (isset($options['networks']['values'][$network])):?>checked<?php endif;?> />
		                    		<span class="wc_ss_btns-slider round"></span>
	                    		</label>
							</td>
							<td align="right">
	                    		<strong><?php echo ucwords($network); ?></strong>
	                    		<?php
	                    		if ( $network == 'email' )
	                    			$network = 'mail';
	                    		?>
	                    		<i class="socicon-<?php echo $network; ?>"></i>
							</td>
						</tr>
						<?php
                    		$i++;
                    	endforeach; ?>
					</table>
                    
					
				</td>
			</tr>
			<?php do_action( 'ss_btns_after_network_settings' ); ?>
		</tbody>
		<tfoot>
			<tr>
				<td><?php submit_button(); ?></td>
			</tr>
		</tfoot>
	</table>
</form>