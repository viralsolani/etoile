<?php
/**
 * The template for displaying content pages.
 *
 * Template Name: contentus
 *
 * @package storefront
 */

get_header(); ?>

<div class="cms-area"> 
   		<section>
            <div class="container">
            <div class="row">
                <div class="contact_addres_dtl">
                    <div class="col-sm-5 col-md-4">
                    	<div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="contact_addres_box">
                                    <span class="address-icon"><i class="fa fa-map-marker"></i></span>
                                    <p>Test Address, test 0000,<br> Demo</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12">
                                <div class="contact_addres_box contact_call_box">
                                    <span class="call-icon"><i class="fa fa-phone"></i></span>
                                    <p><a class="click-call" title="123456789" href="tel:123456789">123456789</a></p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12">
                                <div class="contact_addres_box contact_email_box">
                                    <span class="mail-icon"><i class="fa fa-envelope"></i></span>
                                    <p><a title="info@test.com.au" href="mailto:info@test.com.au">info@test.com.au</a></p>
                                </div>
                            </div>
                            
                    	</div>
                    </div>    
                    <div class="col-sm-7 col-md-8">
                        <div class="contact-map">	
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30684908.116073795!2d64.43730239787865!3d20.145879074651162!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff06b92b791%3A0xd78c4fa1854213a6!2sIndia!5e0!3m2!1sen!2sin!4v1455196671985" width="100%" height="230" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        </section>
        
        <section>
            <div class="contact-form-main">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-center white h2">Contact Form</div>
                        </div>
                        <div class="contact-form">
                            <?php echo do_shortcode( '[contact-form-7 id="255" title="Contact form"]'); ?>       
                        </div>
                    </div>
                </div>
            </div>
        </section>
   </div>  

<?php
get_footer();
