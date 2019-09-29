<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="social_newslatter">
    	<div class="container">
        	<div class="row">
            	<div class="main_social_icon col-xs-12 col-sm-6 col-md-6 col-lg-5">
                	<h2>Social</h2>
					<ul>
                        <li><a href="" ><?php echo get_field( 'facebook', 'option' )?></a></li>
                        <li><a href="" ><?php echo get_field( 'twitter', 'option' )?></a></li>
                        <li><a href="" ><?php echo get_field( 'instagram', 'option' )?></a></li>
                        <li><a href="" ><?php echo get_field( 'linkedin', 'option' )?></a></li>
                        <li><a href="" ><?php echo get_field( 'pinterest', 'option' )?></a></li>
                        <li><a href="" ><?php echo get_field( 'youtube', 'option' )?></a></li>
                    </ul>
                 </div>
            	<div class="newslatter_section col-xs-12 col-sm-6 col-md-6 col-lg-7">
                	<h2>Newslatter</h2>
					<p>Subscribe to receive Etoile Fashion’s latest offers & updates</p>
					<?php echo do_shortcode( '[contact-form-7 id="256" title="newslatter"]'); ?>
                </div>
            </div>
        </div>
	</div>
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to storefront_footer action
			 *
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit         - 20
			 */
			//do_action( 'storefront_footer' );
			?>
			<div class="container">
        	<div class="row">
            	<div class="col-lg-4 col-sm-4 col-xs-12 f_box wow fadeInUp" data-wow-delay="0.3s">
                    	<h3>Our Policies</h3>
						<div class="footer-sub">
                    	 	<?php wp_nav_menu(array('menu' => 'footer_policies', 'menu_class' => '', 'container' => '', 'link_before' => '', 'link_after'=>'', 'before' => '', 'after' => '' ));  ?>                     	
							</div>	
            		</div>
            		<div class="col-lg-4 col-sm-4 col-xs-12 f_box wow fadeInUp" data-wow-delay="0.6s">
            			<h3>Explore</h3>
						<div class="footer-sub">
                    	 	<?php wp_nav_menu(array('menu' => 'footer_explore', 'menu_class' => '', 'container' => '', 'link_before' => '', 'link_after'=>'', 'before' => '', 'after' => '' ));  ?> 
                    	</div>
            		</div>
            		<div class="col-lg-4 col-sm-4 col-xs-12 f_box wow fadeInUp" data-wow-delay="1.2s">
	            			<h3>Get In Touch</h3>
						<div class="footer-sub">
	            			<ul class="contact_info_footer">
								  <li><span><?php echo the_field( 'email','option')?> </span><a href="mailto:<?php echo str_replace(array(' ','+'), array('',''),the_field( 'contact_email_address', 'option' ) )?>" title="<?php echo get_field( 'contact_email_address', 'option' )?>"><span><?php echo get_field( 'contact_email_address', 'option' )?></span></a></li>
								  <li><span><?php echo the_field( 'phone','option')?> </span><a href="tel:<?php echo the_field( 'contact_phone_number','option')?>" title="Email"><span><?php echo the_field( 'contact_phone_number', 'option' )?></span></a></li>
                                  <li><span><?php echo the_field( 'clock','option')?> </span><span><?php echo the_field( 'contact_hours', 'option' )?></span></li>
							</ul>
							</div>
	            		</div>
					<div class="copyright col-lg-12 text-center">
						<?php echo html_entity_decode(the_field( 'copyright_text', 'option' ))?>
					</div>
            </div>
     </div>
		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
