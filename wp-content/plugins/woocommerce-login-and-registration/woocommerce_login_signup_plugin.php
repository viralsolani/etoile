<?php
/*
Plugin Name: Woocommerce Login / Signup Lite
Plugin URI: https://www.phoeniixx.com/product/woocommerce-login-signup/
Description: With this free Sign Up/ Login plugin, you can easily create a sign up and login process for your ecommerce site.
Author: phoeniixx
Author URI: http://phoeniixx.com/
Version: 2.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: phoen_login_signup
WC requires at least: 2.6.0
WC tested up to: 3.7.0
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

ob_start();
/*Check woocommerce plugin is activate or not.*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
define('PLUGINlSPDIRURL',plugin_dir_url( __FILE__ ));
	
/*login shortcode function*/
	function add_login_shortcode() 
	{
		ob_start();
		
		if ( !is_user_logged_in() ) 
		{
			echo'<div class="woocommerce">';
			
			if(isset($_POST['login']) && sanitize_text_field( $_POST['login'] ) ) 
			{
				
				global $wpdb;
				
				$nonce_check = isset($_POST['_wpnonce_phoe_login_form'])?sanitize_text_field( $_POST['_wpnonce_phoe_login_form'] ):"";
	
				if ( ! wp_verify_nonce( $nonce_check, 'phoe_login_form' ) ) 
				{
					
					die(   'Security check failed'  ); 
					
				}
				
				$username = isset($_POST['username'])?sanitize_text_field($_POST['username']):'';
				
				$password = isset($_POST['password'])?$_POST['password']:'';
				
				$remember = isset($_POST['rememberme'])?sanitize_text_field($_POST['rememberme']):'';
				
				$remember = ( $remember ) ? 'true' : 'false';
				
				if($username == '')
				{
					
						echo '<ul class="woocommerce-error">
									
									<li><strong>Error:</strong> Username is required.</li>
								
							</ul>';
							
				}
				else if($password == '')
				{
					
					echo '<ul class="woocommerce-error">
								
								<li><strong>Error:</strong> Password is required.</li>
						
						</ul>';
						
				}
				else
				{
					
					if(is_email($username)) 
					{
						
						$user= get_user_by('email',$username);
						
						if($user)
						{
							
							if(wp_check_password( $password, $user->user_pass))
							{
								
								wp_set_current_user( $user->ID, $user->user_login );
								
								wp_set_auth_cookie( $user->ID );
								
								do_action( 'wp_login', $user->user_login ,$user);
								
								$location = home_url()."/my-account/";
								
								wp_redirect( $location );
							
								exit;
								
							}
							else
							{
								
								echo '<ul class="woocommerce-error">
										
											<li><strong>ERROR</strong>: The password you entered for the username <strong>'.$user->user_login.'</strong> is incorrect. 		
										
											<a href="'.get_site_url().'/my-account/lost-password/">Lost your password?</a></li>
									 
									</ul>';
							
							}
							
						}
						else
						{
							
							echo '<ul class="woocommerce-error">
									
									<li><strong>Error:</strong> A user could not be found with this email address.</li>
								  
								 </ul>';
								 
						}
						
					}
					else
					{
						
						$login_data = array();

						$login_data['user_login'] = $username;

						$login_data['user_password'] = $password;

						$login_data['remember'] = $remember;
		
						$user_verify = wp_signon($login_data,false);  
						
						if(is_wp_error($user_verify))
						{
								
								echo '<ul class="woocommerce-error">
				
											<li>'.$user_verify->get_error_message().'</li>
									  
									  </ul>';       
									  
						}
						else 
						{ 
							wp_set_current_user( $user_verify->ID, $user_verify->user_login );
						
							wp_set_auth_cookie( $user_verify->ID );
							
							do_action( 'wp_login', $user_verify->user_login, $user_verify);
							
							$location = home_url();  
							
							wp_redirect( $location );
							
							exit;
							
						} 
						
					}   
					
				}
				
			}
				?>        
							
			<div class="col-set" id="customer_login">
			
				<div class="col">
				
					<h2>Login</h2>
					
					<form method="post" class="login">
					
					<?php $nonce = wp_create_nonce( 'phoe_login_form' ); ?>
							
						<input type="hidden" value="<?php echo $nonce; ?>" name="_wpnonce_phoe_login_form" id="_wpnonce_phoe_login_form" />

						<p class="form-row form-row-wide">
							<label for="username">Username or email address <span class="required">*</span></label>
							<input type="text" class="input-text" name="username" id="username" value="<?php echo isset( $username ) ? $username: '' ; ?>">
						</p>
						<p class="form-row form-row-wide">
							<label for="password">Password <span class="required">*</span></label>
							<input class="input-text" type="password" name="password" id="password">
						</p>
						<p class="form-row">
							<input type="hidden" id="_wpnonce" name="_wpnonce" value="fd684f83cf">
							<input type="hidden" name="_wp_http_referer" value="<?php echo get_site_url(); ?>/my-account/">				
							<input type="submit" class="button" id="login" name="login" value="Login">
							<label for="rememberme" class="inline">
								<input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember me </label>
						</p>
						<p class="lost_password">
							<a href="<?php echo get_site_url(); ?>/my-account/lost-password/">Lost your password?</a>
						</p>
					</form>
				</div>
			</div>
			</div>        
			<?php  
		}
		
		
		return ob_get_clean();
	
	}
	
	/*Add shignup shortcode function*/
    function add_signup_shortcode()
	{ 
	
		ob_start();
		
		if ( !is_user_logged_in() ) 
		{ 
			
			echo ' <div class="woocommerce">';
			
			if(isset($_POST['register']) && sanitize_text_field ($_POST['register'] ) )
			{
		
				$nonce_check = isset($_POST['_wpnonce_phoe_register_form'])?sanitize_text_field( $_POST['_wpnonce_phoe_register_form'] ):'';

				if ( ! wp_verify_nonce( $nonce_check, 'phoe_register_form' ) ) 
				{
					
					die(   'Security check failed'  ); 
					
				}
				
				$reg_email = isset($_POST['email'])?sanitize_email($_POST['email']):'';
				
				$reg_password = isset($_POST['password'])? sanitize_text_field($_POST['password']):'';
				
				$arr_name = explode("@",$reg_email);  
				
				$temp = $arr_name[0];
				
				$user = get_user_by( 'email',$reg_email );			   
			    
				if($reg_email == '')
				{
					
					echo '<ul class="woocommerce-error">
					
							<li><strong>Error:</strong> Please provide a valid email address.</li>
							
						  </ul>';
			    
				}
				
				else if($reg_password == '')
				{
				
					echo '<ul class="woocommerce-error">
					
							<li><strong>Error:</strong> Please enter an account password.</li>
							
					      </ul>';
			    }
				else
				{
					
					if(is_email($reg_email))
					{ 	
						
						if(is_object($user) && $user->user_email == $reg_email)
						{
						
							echo'<ul class="woocommerce-error">
									
									<li><strong>Error:</strong> An account is already registered with your email address. Please login.</li>
								 
								 </ul>';
						}
					    else
						{             
							
							if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && empty( $reg_password ) ) {
								
									$reg_password = wp_generate_password();
									
									$password_generated = true;

								} elseif ( empty( $reg_password ) ) {
									
									return new WP_Error( 'registration-error-missing-password', __( 'Please enter an account password.', 'woocommerce' ) );

								} else {
									
									$password_generated = false;
									
								}
								
							$userdata=array("role"=>"customer",
							
											"user_email"=>$reg_email,
											
											"user_login"=>$temp,
											
											"user_pass"=>$reg_password);
							
							if($user_id = wp_insert_user( $userdata ))
							{ 
								
								do_action('woocommerce_created_customer', $user_id, $userdata, $password_generated);
								
								$user1 = get_user_by('id',$user_id);
							    
								wp_set_current_user( $user1->ID, $user1->user_login );
											   
							    wp_set_auth_cookie( $user1->ID );
							   
							    do_action( 'wp_login', $user1->user_login,$user1 );
							   
							   $location = home_url()."/my-account/"; 
								wp_redirect($location);

							    exit;												 
							}
							
						}
						
					}
					else
					{
						echo '<ul class="woocommerce-error">
							
									<li><strong>Error:</strong> Please provide a valid email address.</li>
							
							</ul>';
							
					} 
					
				}
				
			}
			
?>        
	
			<div class="col-set" id="customer_login">
				<div class="col">
					<h2>Register</h2>
					<form method="post" class="register">	

						<?php $nonce_register = wp_create_nonce( 'phoe_register_form' ); ?>
							
						<input type="hidden" value="<?php echo $nonce_register; ?>" name="_wpnonce_phoe_register_form" id="_wpnonce_phoe_register_form" />
					
						<p class="form-row form-row-wide">
							<label for="reg_email">Email address <span class="required">*</span></label>
							<input type="email" class="input-text" name="email" id="reg_email" value="<?php echo isset( $reg_email ) ? $reg_email: '' ; ?>" >
						</p>			
							<p class="form-row form-row-wide">
								<label for="reg_password">Password <span class="required">*</span></label>
								<input type="password" class="input-text" name="password" id="reg_password " >
							</p>			
						<div style="left: -999em; position: absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1"></div>						
						<p class="form-row">
							<input type="hidden" id="_wpnonce" name="_wpnonce" value="70c2c9e9dd"><input type="hidden" name="_wp_http_referer" value="<?php echo get_site_url(); ?>/my-account/">				
							
							<input type="submit" class="button" name="register" value="Register">
						</p>
					</form>
				</div>
			</div>
		</div>
		
<?php        

		}
		
		return ob_get_clean();
	} // end of add_signup_shortcode().
	   
     
	// header short code area start(login):
	add_action( 'wp_ajax_val_header', 'header_validate' );
	
	add_action( 'wp_ajax_nopriv_val_header', 'header_validate' );
	
	function header_validate()
	{
		
		$nonce_check = isset($_POST['wpnonce'])?sanitize_text_field( $_POST['wpnonce'] ):'';

		if ( !is_user_logged_in() ) 
		{  
			
			global $wpdb;
									
			$username = isset($_POST['username'])?$wpdb->escape(sanitize_text_field($_POST['username'])):'';
			
			$password = isset($_POST['password'])?$_POST['password']:'';
			
			$remember = isset($_POST['rememberme'])?$wpdb->escape(sanitize_text_field($_POST['rememberme'])):'';
			
			if($remember) $remember = "true";
			
			else $remember = "false";
			
			if($username == '')
			{
				
				echo '<ul class="woocommerce-error">
						
						<li><strong>Error:</strong> Username is required.</li>
					  
					  </ul>';
					  
			}
			else if($password == '')
			{
				
				echo '<ul class="woocommerce-error">
						
						<li><strong>Error:</strong> Password is required.</li>
					  
					  </ul>';
					  
			}
			else
			{				
					
					if(is_email($username))
					{
						
						$user= get_user_by('email',$username);
						
						if($user)
						{
							
							if(wp_check_password( $password, $user->user_pass))
							{
							   
							   echo "1";	
							    
							   wp_set_current_user( $user->ID, $user->user_login );
							   
							   wp_set_auth_cookie( $user->ID );
							   
							   do_action( 'wp_login', $user->user_login,$user );
							   
							   exit;
							   
							}
							else
							{
								
								echo '<ul class="woocommerce-error">
									
										<li><strong>ERROR</strong>: The password you entered for the username <strong>'.$user->user_login.'</strong> is incorrect. 
									  
										 <a href="'.get_site_url().'/my-account/lost-password/">Lost your password?</a></li>
									 
									</ul>';
							
							}	
							
						}
						else
						{
							
							echo '<ul class="woocommerce-error">
							
										<li><strong>Error:</strong> A user could not be found with this email address.</li>
								  
								 </ul>';
								 
						}						
						
						}
						else
						{
						
							$login_data = array();
							
							$login_data['user_login'] = $username;
							
							$login_data['user_password'] = $password;
							
							$login_data['remember'] = $remember;
							
							$user_verify = wp_signon($login_data,false);  
							 
							if (is_wp_error($user_verify))
							{
								
								echo '<ul class="woocommerce-error">
								
											<li>'.$user_verify->get_error_message().'</li>
									 
									</ul>';                        
							
							}
							else
							{ 

								echo "1";
							  
								wp_set_current_user( $user_verify->ID, $user_verify->user_login );
							    
								wp_set_auth_cookie( $user_verify->ID );
							    
								do_action( 'wp_login', $user_verify->user_login ,$user);
							    
							    exit;
							
							} 
						
						}      
			
			}

			exit;
        
		}
		else
		{
			
			echo '<ul class="woocommerce-error">
                     
					 <li><strong>Error:</strong> A user already loged in, Logout First.</li>
                  
				 </ul>';
				 
		}
		
		exit;
    
	}   // end of header_validate	 
	    // header short code area end(login)
		// header short code area start(signup):
	
	//Ajax for register a customer
	add_action( 'wp_ajax_val_header_signup', 'header_validate_signup' );
	
	add_action( 'wp_ajax_nopriv_val_header_signup', 'header_validate_signup' );
    
	function header_validate_signup()
	{
		
		$nonce_check = isset($_POST['wpnonce'])?sanitize_text_field( $_POST['wpnonce'] ):'';

		if (!is_user_logged_in())
		{ 
	
			$reg_email = isset($_POST['email'])?sanitize_text_field( $_POST['email'] ):'';
		    
			$reg_password =  isset($_POST['password'])?sanitize_text_field( $_POST['password'] ):'';
		    
			$arr_name = explode("@",$reg_email);  $temp = $arr_name[0];
		    
			$user = get_user_by( 'email',$reg_email );
		   
		    if($reg_email == '')
			{
				
				echo '<ul class="woocommerce-error">
						
						<li><strong>Error:</strong> Please provide a valid email address.</li>
					  
					</ul>';
					
		    }
			
			else if($reg_password == '')
			{
				
				echo '<ul class="woocommerce-error">
			    
						<li><strong>Error:</strong> Please enter an account password.</li>
				      
					 </ul>';
					 
		    }
			else
			{
			   
				if(is_email($reg_email))
				{ 
					
					if($user->user_email == $reg_email)
					{
						
						echo'<ul class="woocommerce-error">
								
								<li><strong>Error:</strong> An account is already registered with your email address. Please login.</li>
							 
							</ul>';
					
					}
					else
					{             
						
						if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && empty( $reg_password ) ) {
									$reg_password = wp_generate_password();
									$password_generated = true;

								} elseif ( empty( $reg_password ) ) {
									return new WP_Error( 'registration-error-missing-password', __( 'Please enter an account password.', 'woocommerce' ) );

								} else {
								$password_generated = false;
							}
								
						$userdata=array("role"=>"customer",
						
									"user_email"=>$reg_email,
									
									"user_login"=>$temp,
									
									"user_pass"=>$reg_password);
						
						if($user_id = wp_insert_user( $userdata ))
						{
							
							echo "1";
							
							do_action('woocommerce_created_customer', $user_id, $userdata, $password_generated);
							
							$user1 = get_user_by('id',$user_id);
							
							wp_set_current_user( $user1->ID, $user1->user_login );
							
							wp_set_auth_cookie( $user1->ID );
							
							do_action( 'wp_login', $user1->user_login ,$user1);
							
							exit;
											 
						}
						
					}
			    
				}
				else
				{
					
					echo '<ul class="woocommerce-error">
						
							<li><strong>Error:</strong> Please provide a valid email address.</li>
						
						</ul>';
				
				} 
			
			}		
			
			exit;
		}
		else
		{
			
			echo '<ul class="woocommerce-error">
			
						<li><strong>Error:</strong> A user already loged in, Logout First.</li>
				  
				  </ul>';
		
		}			
		
	die();	
	}// header short code area  end(signup)
   
    function add_header_shortcode()
	{
        ob_start();
		
		if (!is_user_logged_in())
		{ 
			
			// ajax call start
			
			wp_enqueue_script("login-signup-js",PLUGINlSPDIRURL."/assets/js/custom.js",array('jquery'),'',true);
			
			wp_localize_script( 'login-signup-js', 'woo_log_ajaxurl', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
			
			//end of ajax call

			wp_enqueue_script("jquery.colorbox-js",PLUGINlSPDIRURL."/assets/js/jquery.colorbox.js",array('jquery'),'',true);
			
			wp_enqueue_style( 'style-colorbox', PLUGINlSPDIRURL.'/assets/css/colorbox.css' );
            
			if(get_option("popup_status") == 'on')
			{
			
				echo '<p><a href="#" class="header_login" >Login</a><a href="#" class="header_signup"> Sign Up</a> ';
				
				?>
				
				<div style="display: none;">
				
					<?php          
				
						echo '<div id="login_data">';          
						
						echo'<div class="woocommerce">';        
						
						?> 
						
						<div class="col-set" id="customer_login" >
						
							<div class="col" >
							
							<div class="result1"></div> 
							
								<h2>Login</h2>

								<form method="post" class="login" id="js_login">
								
								<?php $nonce_login_pop = wp_create_nonce( 'phoe_login_pop_form' ); ?>
									
									<input type="hidden" value="<?php echo $nonce_login_pop; ?>" name="_wpnonce_phoe_login_pop_form" id="wpnonce_phoe_login_pop_form" />
							
									<p class="form-row form-row-wide">
										<label for="username">Username or email address <span class="required">*</span></label>
										<input type="text" class="input-text" name="username" id="username" value="">
									</p>
									<p class="form-row form-row-wide">
										<label for="password">Password <span class="required">*</span></label>
										<input class="input-text" type="password" name="password" id="password">
									</p>
									<p class="form-row">
										<input type="hidden" id="_wpnonce" name="_wpnonce" value="fd684f83cf">
										<input type="hidden" id="wp_http_referer1" name="_wp_http_referer" value="<?php echo get_site_url(); ?>/my-account/"><div class="loader1" style="display:none;" ><img src="<?php echo PLUGINlSPDIRURL."/assets/img/ajax-loader.gif" ?>"/></div>				
										<input type="submit" class="button js_login_log" name="login" value="Login" id="login1">
										<label for="rememberme" class="inline">
										<input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember me </label>
									</p>
								<p class="lost_password">
									<a href="<?php echo get_site_url(); ?>/my-account/lost-password/">Lost your password?</a>
								</p>
							</form>
						</div>
					</div> 
					</div>  
					</div>  <!-- end of login data -->
				   
					<div id="signup_data">
					
					<?php       
			 
					echo ' <div class="woocommerce">';
				 
					?>        
				
		   
						<div class="col-set" id="customer_login">
						<div class="col" >
							<div class="result2"></div>
							<h2>Register</h2>
							<form method="post" class="register" id="js_signup" >			

								<?php $nonce_register_pop = wp_create_nonce( 'phoe_register_pop_form' ); ?>
									
									<input type="hidden" value="<?php echo $nonce_register_pop; ?>" name="_wpnonce_phoe_register_pop_form" id="wpnonce_phoe_register_pop_form" />
												
								<p class="form-row form-row-wide">
									<label for="reg_email">Email address <span class="required">*</span></label>
									<input type="email" class="input-text" name="email" id="reg_email_header" value="" >
								</p>			
									<p class="form-row form-row-wide">
										<label for="reg_password">Password <span class="required">*</span></label>
										<input type="password" class="input-text" name="password" id="reg_password_header" >
									</p>			
								<!-- Spam Trap -->
								<div style="left: -999em; position: absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1"></div>						
								<p class="form-row">
									<input type="hidden" id="_wpnonce" name="_wpnonce" value="70c2c9e9dd"><input id="wp_http_referer" type="hidden" name="_wp_http_referer" value="<?php echo get_site_url(); ?>/my-account/">				
									<div class="loader_reg" style="display:none;" ><img src="<?php echo PLUGINlSPDIRURL."/assets/img/ajax-loader.gif" ?>"/></div>				
									<input type="submit" class="button phoen_reg" name="register_header" value="Register">
								</p>
							</form>
						</div>
					</div>
					</div>
					</div> <!-- end of signup data -->
					<?php 
					}
					else
					{
						
						echo '<p><a href="'.get_option("login_url").'"  >Login </a><a href="'.get_option("signup_url").'">Sign Up</a> ';
						 
					} 
					?> 
				</div>
       
		<?php
         
		}
		else
		{
			
			$user_obj = wp_get_current_user();
			 			 
?>

			<p><span class="phoe-span-1">Hello</span> <strong><?php echo $user_obj->user_login; ?></strong> <span class="phoe-span-2">(not <?php echo $user_obj->user_login; ?> </span> 
			  <a href="<?php echo wp_logout_url( get_permalink() );  ?>">Sign out</a> <span class="phoe-span-3">). </span>
			</p>

<?php	
				
		}
		return ob_get_clean();
	}
	
	/*Add popup html and jquery file in header*/
	function phoen_header_login()
	{
        ob_start();
		
		if (!is_user_logged_in())
		{ 
			 
			// ajax call start
			
			wp_enqueue_script("login-signup-js",PLUGINlSPDIRURL."/assets/js/custom.js",array('jquery'),'',true);
			
			wp_localize_script( 'login-signup-js', 'woo_log_ajaxurl', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
			
			//end of ajax call

			wp_enqueue_script("jquery.colorbox-js",PLUGINlSPDIRURL."/assets/js/jquery.colorbox.js",array('jquery'),'',true);
			
			wp_enqueue_style( 'style-colorbox', PLUGINlSPDIRURL.'/assets/css/colorbox.css' );
            
				?>
				
				
				<div style="display: none;">
				
					<?php          
				
					echo '<div id="phoen_login_data">';          
						
						echo'<div class="woocommerce">';        
						
						?> 
						
					<div class="col-set" id="customer_login">
						
						<div class="col" >
							
							<div class="result1"></div> 
							
								<h2>Login</h2>

								<form method="post" class="login" id="js_login">
								
								<?php $nonce_login_pop = wp_create_nonce( 'phoe_login_pop_form' ); ?>
									
									<input type="hidden" value="<?php echo $nonce_login_pop; ?>" name="_wpnonce_phoe_login_pop_form" id="wpnonce_phoe_login_pop_form" />
							
									<p class="form-row form-row-wide">
										<label for="username">Username or email address <span class="required">*</span></label>
										<input type="text" class="input-text" name="username" id="username" value="">
									</p>
									<p class="form-row form-row-wide">
										<label for="password">Password <span class="required">*</span></label>
										<input class="input-text" type="password" name="password" id="password">
									</p>
									<p class="form-row">
										<input type="hidden" id="_wpnonce" name="_wpnonce" value="fd684f83cf">
										<input type="hidden" id="wp_http_referer1" name="_wp_http_referer" value="<?php echo get_site_url(); ?>/my-account/"><div class="loader1" style="display:none;" ><img src="<?php echo PLUGINlSPDIRURL."/assets/img/ajax-loader.gif" ?>"/></div>				
										<input type="submit" class="button js_login_log" name="login" value="Login" id="login1">
										<label for="rememberme" class="inline">
										<input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember me </label>
									</p>
								<p class="lost_password">
									<a href="<?php echo get_site_url(); ?>/my-account/lost-password/">Lost your password?</a>
								</p>
								<p>
									<a href="#" class="phoen_signup"> Sign Up</a>
								</p>
							</form>
						</div>
						
					</div> 
					</div>  
					</div>  <!-- end of login data -->
					
					<div id="phoen_signup_data">
					
					<?php       
			 
					echo ' <div class="woocommerce">';
				 
					?>        
				
					<div class="col-set" id="customer_login">
						<div class="col" >
							<div class="result2"></div>
							<h2>Register</h2>
							<form method="post" class="register" id="js_signup" >			

								<?php $nonce_register_pop = wp_create_nonce( 'phoe_register_pop_form' ); ?>
									
									<input type="hidden" value="<?php echo $nonce_register_pop; ?>" name="_wpnonce_phoe_register_pop_form" id="wpnonce_phoe_register_pop_form" />
												
								<p class="form-row form-row-wide">
									<label for="reg_email">Email address <span class="required">*</span></label>
									<input type="email" class="input-text" name="email" id="reg_email_header" value="" >
								</p>			
									<p class="form-row form-row-wide">
										<label for="reg_password">Password <span class="required">*</span></label>
										<input type="password" class="input-text" name="password" id="reg_password_header" >
									</p>			
								<!-- Spam Trap -->
								<div style="left: -999em; position: absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1"></div>						
								<p class="form-row">
									<input type="hidden" id="_wpnonce" name="_wpnonce" value="70c2c9e9dd"><input id="wp_http_referer" type="hidden" name="_wp_http_referer" value="<?php echo get_site_url(); ?>/my-account/">				
									<div class="loader_reg" style="display:none;" ><img src="<?php echo PLUGINlSPDIRURL."/assets/img/ajax-loader.gif" ?>"/></div>				
									<input type="submit" class="button phoen_reg" name="register_header" value="Register">
								</p>
								<p><a href="#" class="phoen_login" >Login</a>
							</form>
						</div>
					
					</div>
					</div>
					</div> <!-- end of signup data -->
					
				</div>	
				
				
				<div style="display: none;">
				
					<?php          
				
					echo '<div id="phoen_login_data_val">';          
						
						echo'<div class="woocommerce">';        
						
						?> 
						
					<div class="col-set" id="customer_login" >
						
						<div class="col" >
							
							<div class="result1"></div> 
							
								<h2>Login</h2>

								<form method="post" class="login" id="js_login">
								
								<?php $nonce_login_pop = wp_create_nonce( 'phoe_login_pop_form' ); ?>
									
									<input type="hidden" value="<?php echo $nonce_login_pop; ?>" name="_wpnonce_phoe_login_pop_form" id="wpnonce_phoe_login_pop_form" />
							
									<p class="form-row form-row-wide">
										<label for="username">Username or email address <span class="required">*</span></label>
										<input type="text" class="input-text" name="username" id="username" value="">
									</p>
									<p class="form-row form-row-wide">
										<label for="password">Password <span class="required">*</span></label>
										<input class="input-text" type="password" name="password" id="password">
									</p>
									<p class="form-row">
										<input type="hidden" id="_wpnonce" name="_wpnonce" value="fd684f83cf">
										<input type="hidden" id="wp_http_referer1" name="_wp_http_referer" value="<?php echo get_site_url(); ?>/my-account/"><div class="loader1" style="display:none;" ><img src="<?php echo PLUGINlSPDIRURL."/assets/img/ajax-loader.gif" ?>"/></div>				
										<input type="submit" class="button js_login_log" name="login" value="Login" id="login1">
										<label for="rememberme" class="inline">
										<input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember me </label>
									</p>
								<p class="lost_password">
									<a href="<?php echo get_site_url(); ?>/my-account/lost-password/">Lost your password?</a>
								</p>
							</form>
						</div>
						
					</div> 
					</div>  
					</div>  <!-- end of login data -->
				   
					<div id="phoen_signup_data_val">
					
					<?php       
			 
					echo ' <div class="woocommerce">';
				 
					?>        
				
					<div class="col-set" id="customer_login">
						<div class="col" >
							<div class="result2"></div>
							<h2>Register</h2>
							<form method="post" class="register" id="js_signup" >			

								<?php $nonce_register_pop = wp_create_nonce( 'phoe_register_pop_form' ); ?>
									
									<input type="hidden" value="<?php echo $nonce_register_pop; ?>" name="_wpnonce_phoe_register_pop_form" id="wpnonce_phoe_register_pop_form" />
												
								<p class="form-row form-row-wide">
									<label for="reg_email">Email address <span class="required">*</span></label>
									<input type="email" class="input-text" name="email" id="reg_email_header" value="" >
								</p>			
									<p class="form-row form-row-wide">
										<label for="reg_password">Password <span class="required">*</span></label>
										<input type="password" class="input-text" name="password" id="reg_password_header" >
									</p>			
								<!-- Spam Trap -->
								<div style="left: -999em; position: absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1"></div>						
								<p class="form-row">
									<input type="hidden" id="_wpnonce" name="_wpnonce" value="70c2c9e9dd"><input id="wp_http_referer" type="hidden" name="_wp_http_referer" value="<?php echo get_site_url(); ?>/my-account/">				
									<div class="loader_reg" style="display:none;" ><img src="<?php echo PLUGINlSPDIRURL."/assets/img/ajax-loader.gif" ?>"/></div>				
									<input type="submit" class="button phoen_reg" name="register_header" value="Register">
								</p>
							</form>
						</div>
					
					</div>
					</div>
					</div> <!-- end of signup data -->
				</div>
				
		<?php
		}else{
			
				if (is_user_logged_in())
				{ 
			
				wp_enqueue_script("login-signup-js",PLUGINlSPDIRURL."/assets/js/custom.js",array('jquery'),'',true);
				
				wp_enqueue_script("jquery.colorbox-js",PLUGINlSPDIRURL."/assets/js/jquery.colorbox.js",array('jquery'),'',true);
				
				wp_enqueue_style( 'style-colorbox', PLUGINlSPDIRURL.'/assets/css/colorbox.css' );
			
			?>
			<div style="display: none;">
				<div id="phoen_myaccount_login">
					
					<?php       
			 
					echo ' <div class="woocommerce">';
				 
					?>        
				
					<div class="col-set" id="customer_login">
						<div class="col" >
							<div class="result2"></div>
							<h2>Navigation</h2>
								<nav class="woocommerce-MyAccount-navigation">
								<ul>
									<?php foreach ( wc_get_account_menu_items() as $phoen_menu_myaccount => $phoen_menu_myaccount_data ) : 
									if($phoen_menu_myaccount_data!='')
									{
									?>
										<li class="<?php echo wc_get_account_menu_item_classes( $phoen_menu_myaccount ); ?>">
											<a href="<?php echo esc_url( wc_get_account_endpoint_url( $phoen_menu_myaccount ) ); ?>"><?php echo esc_html( $phoen_menu_myaccount_data ); ?></a>
										</li>
									<?php
									}
									endforeach; ?>
								</ul>
							</nav>
						</div>
					
					</div>
					</div>
				</div> <!-- end of signup data -->
			</div>
	
			<?php
			
				}	
		} 
         
	}
	/*END Add popup html and jquery file in header*/
	/*Add Admin script for media library*/
	function phoen_my_media_lib_uploader_enqueue() {
		wp_enqueue_media();
	 
		wp_enqueue_script( 'media-lib-uploader-js' );
	}
	/*End Add Admin script for media library*/
	add_action('admin_enqueue_scripts', 'phoen_my_media_lib_uploader_enqueue');
	
	
	add_shortcode("lsphe-login-form","add_login_shortcode");
       
	add_shortcode("lsphe-signup-form","add_signup_shortcode");
    
	add_shortcode("lsphe-header","add_header_shortcode");
	
	add_shortcode("wp-login-form","add_login_shortcode");
       
	add_shortcode("wp-signup-form","add_signup_shortcode");
    
	add_shortcode("wp-header","add_header_shortcode");
	
    add_filter( 'widget_text', 'shortcode_unautop');
	
	add_filter('widget_text', 'do_shortcode');
	
	add_action('wp_head','phoen_header_login');
	/*Add admin menu*/
	function ph_login_signup_add_menu()
	{
		
		$page_title='Login/Signup Setting';
		
		$menu_title='Login/Signup';
		
		$capability='manage_options';
		
		$menu_slug='login_signup_settings';
		
		$function='settings_wp_login_signup';
		
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug,$function , $icon_url, $position );
		if ( empty ( $GLOBALS['admin_page_hooks']['phoeniixx'] ) ){
			add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, PLUGINlSPDIRURL.'assets/img/logo-wp.png', 57 );
        }
		add_submenu_page( 'phoeniixx', $page_title, $menu_title, $capability, $menu_slug, $function );
	

	}
	/*End Admin menu*/
	
	
	function ph_login_signup_activate() {

		if(get_option("popup_status") == ""){
			update_option("popup_status","on");
		}
	
	}
	register_activation_hook( __FILE__, 'ph_login_signup_activate' );
	
    add_action("admin_menu","ph_login_signup_add_menu",99);
	
    function settings_wp_login_signup()
	{ 
        
		if( !empty( $_GET['tab'] ) )
		{
			
			$tab = sanitize_text_field( $_GET['tab'] );
			
		}
		else
		{
			$tab = '';
		}
		
		
		echo "<h3>Plugin Settings</h3>"; 
		
		?>
 <h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
				
			<a class="nav-tab <?php if($tab == 'general' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=login_signup_settings&amp;tab=general">General</a>
			
			<a class="nav-tab <?php if($tab == 'allp'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=login_signup_settings&amp;tab=allp">Premium</a>

			<a class="nav-tab <?php if($tab == 'support'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=login_signup_settings&amp;tab=support">Support</a>

			<a class="nav-tab <?php if($tab == 'how-to-install'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=login_signup_settings&amp;tab=how-to-install">How to install</a>

			<a class="nav-tab <?php if($tab == 'woocommece-app'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=login_signup_settings&amp;tab=woocommece-app">Woocommerce App</a>
			
		</h2> 
		
	<?php 
	
	if($tab == 'general' || $tab == '')
	{
		include_once(plugin_dir_path( __FILE__ ).'/includes/admin/general-settings.php');
	}else if($tab == 'allp')
	{
		include_once(plugin_dir_path( __FILE__ ).'/includes/admin/premium-tab.php');
		
	}else if($tab == 'support')
	{
		include_once(plugin_dir_path( __FILE__ ).'/includes/admin/support.php');
	}else if($tab == 'how-to-install')
	{
		include_once(plugin_dir_path( __FILE__ ).'/includes/admin/how-to-install.php');
		
	}else if($tab == 'woocommece-app')
	{
		include_once(plugin_dir_path( __FILE__ ).'/includes/admin/woocommerce-app.php');
		
	}
	
		wp_enqueue_script("conditions-js",PLUGINlSPDIRURL.'/assets/js/admin.js',array('jquery'),'',true);
    
	}
	
}
else
{ 

?>

    <div class="error notice is-dismissible " id="message"><p>Please <strong>Activate</strong> WooCommerce Plugin First, to use woocommerce Social Login.</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
        
<?php 

}
ob_clean();
?>
