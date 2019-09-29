<?php 
	
if( !empty( $_POST['submit_1'] ) && sanitize_text_field( $_POST['submit_1'] ) && current_user_can( 'manage_options' )  )
{
	
	$nonce_check = sanitize_text_field( $_POST['_wpnonce_login_signup_setting'] );

	if ( ! wp_verify_nonce( $nonce_check, 'login_signup_setting' ) ) 
	{
		
		die(  'Security check failed'  ); 
		
	}
	else 
	{
		
		if( !empty( $_POST['popup'] ) )
		{
			
			$popup = sanitize_text_field($_POST['popup']);
		
		}
		else
		{
			
			$popup = '';
			
		}
		
		if( !empty( $_POST['login_page'] ) )
		{
			
			$login_url = sanitize_text_field($_POST['login_page']);
		
		}
		else
		{
			
			$login_url = '';
			
		}
	
		if( !empty( $_POST['signup_page'] ) )
		{
			
			$signup_url = sanitize_text_field($_POST['signup_page']);
		
		}
		else
		{
			
			$signup_url = '';
			
		}

		if($popup=='on')
		{
			
			$option="popup_status";
		
			$value="on";
			
			$autoload="yes";
			
			update_option($option, $value, $autoload );
			
			?>

				<div class="updated notice is-dismissible below-h2" id="message"><p>Successfully saved. </p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>

			<?php
											
		}
		else if($popup!='on' && $login_url!='' && $signup_url !='' )
		{
			
			$option="popup_status";
			
			$value="off";
			
			$autoload="yes";
			
			update_option($option, $value, $autoload ); 
			
			$option="login_url";
			
			$value= $login_url;
			
			$autoload="yes";
			
			update_option($option, $value, $autoload ); 
			
			$option="signup_url";
			
			$value=$signup_url;
			
			$autoload="yes";
			
			update_option($option, $value, $autoload );              
			
			?> 

		   <div class="updated notice is-dismissible below-h2" id="message"><p>Successfully saved. </p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>

			<?php
					
		}
		else
		{
		   
			?>

				<div class="error notice is-dismissible below-h2" id="message"><p>Fields with * are mandatory, try again. </p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>

			<?php                

		}
		

	}

}
?>
	
<style>
	.form-table, .form-table td, .form-table td p, .form-table th {
		font-size: 14px;
		background: white;
	}
	
</style>
<?php if(get_option("popup_status")!= 'on')
{  

	?>

	<div class="wrap" id="profile-page">
	
	<form action="" id="form7" method="post">
	
	<?php $nonce = wp_create_nonce( 'login_signup_setting' ); ?>
					
		<input type="hidden" value="<?php echo $nonce; ?>" name="_wpnonce_login_signup_setting" id="_wpnonce_login_signup_setting" />

		<table class="form-table">
		<tbody>		
		<tr class="user-nickname-wrap">
			<th>Popup Enable :</th><td class="pho_enable"><input type="checkbox" id="popup1" name="popup"    /></td>
		</tr>
		
		<tr class="user-nickname-wrap">
		
			<th>Popup Login Class:</th> <td><code>phoen-login-popup-open</code></td>
		</tr>	
	<tr class="user-nickname-wrap">
		<th>Popup Signup Class:</th>		
		<td>
		  <code>phoen-signup-popup-open</code>
			
		</td>	
	</tr>	
	<tr class="user-nickname-wrap">			
		<th>Popup For Both  Login & Signup Class:</th>		
		<td>
		 <code>phoen-login-signup-popup-open</code>
		</td>	
	</tr>	
	
	<tr class="user-nickname-wrap">			
<th>Short Code For Login Form:</th>		
<td>
		<code>[lsphe-login-form]</code>
		</td>	
	</tr>	
	
	<tr class="user-nickname-wrap">			
<th>Short Code For Signup Form</th>		
<td>
		<code>[lsphe-signup-form]</code>
		</td>	
	</tr>	
	
	<tr class="user-nickname-wrap">			
		<th>Shortcode For Both Login And Register Form:</th>		
		<td>
		<code>[lsphe-header]</code>
		</td>	
	</tr>	
		
		
		<tr class="login user-nickname-wrap">
		<th><label>Login Page Slug :</label></th><td><?php //echo get_site_url()."/ "; ?><input id="log_url" type="text"  name="login_page" value="<?php echo get_option("login_url"); ?>"   />*</td>
		
		</tr>
		
		<tr class="signup user-nickname-wrap">
			<th><label>Signup Page Slug :</label></th><td><?php //echo get_site_url()."/ "; ?><input id="sign_url" type="text"  name="signup_page" value="<?php echo get_option("signup_url"); ?>"    />*</td>
		   
		</tr>
		
	   </tbody>	
		</table>
		<br />
		<input type="submit" class="button button-primary" id="submit1" name="submit_1" value="Save" />
	
	</form>
	</div>
   
	<?php

}
else
{    
	?>  

	<style>
	.login{display: none;}
	.signup{display:none;}

	</style>


	<div class="wrap" id="profile-page">
	
	<form action="" id="form7" method="post">
	
	<?php $nonce = wp_create_nonce( 'login_signup_setting' ); ?>
					
		<input type="hidden" value="<?php echo $nonce; ?>" name="_wpnonce_login_signup_setting" id="_wpnonce_login_signup_setting" />

	<table class="form-table">
	<tbody>		
	<tr class="user-nickname-wrap">
		<th>Popup Enable :</th>		
		<td class="pho_enable"><input type="checkbox" id="popup1" name="popup"  checked  /></td>
	</tr>
	
	
	<tr class="user-nickname-wrap">
		<th>Popup Login Class:</th>
		<td>
			 <code>phoen-login-popup-open</code>
		</td>
	</tr>	
	<tr class="user-nickname-wrap">
		<th>Popup Signup Class:</th>		
		<td>
		<code>phoen-signup-popup-open</code>
			
		</td>	
	</tr>	
	<tr class="user-nickname-wrap">			
		<th>Popup For Both  Login & Signup Class:</th>			
		<td>
			<code>phoen-login-signup-popup-open</code>
		</td>	
	</tr>	
	
	<tr class="user-nickname-wrap">			
		<th>Short Code For Login Form:</th>
		<td>
		<code>[lsphe-login-form]</code>
		</td>	
	</tr>	
	
	<tr class="user-nickname-wrap">			
		<th>Short Code For Signup Form:</th>	
		<td>
			<code>[lsphe-signup-form]</code>
		</td>	
	</tr>	
	
	<tr class="user-nickname-wrap">			
		<th>Shortcode For Both Login And Register Form:</th>			
		<td>
		<code>[lsphe-header]</code>
		</td>	
	</tr>	
	
	
	<tr class="login user-nickname-wrap">
	<th><label>Login Page Slug :</label></th><td><?php echo get_site_url()."/ "; ?><input id="log_url" type="text"  name="login_page"  value="<?php echo get_option("login_url"); ?>" />*</td>
		
	</tr>
		
	<tr class="signup user-nickname-wrap">
		<th><label>Signup Page Slug :</label></th><td><?php echo get_site_url()."/ "; ?><input id="sign_url" type="text"  name="signup_page" value="<?php echo get_option("signup_url"); ?>"   />*</td>
		
	</tr>
	
   </tbody>	
	</table>
	<br />
	<input type="submit" class="button button-primary" id="submit1" name="submit_1" value="Save" /> 
	
	</form>
	</div>    
	
	<?php      

}
?>
<style>
#profile-page .form-table th{
	padding-left:20px;
}


</style>
	