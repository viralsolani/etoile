jQuery(document).ready(function(){ 
  
   jQuery(".header_login").colorbox({className: 'plrp_logreg', width:"50%", height:"525px", inline:true, href:"#login_data", opacity:0.5, closeButton:true});
   jQuery(".header_signup").colorbox({className: 'plrp_logreg',width:"50%", height:"460px", inline:true, href:"#signup_data", opacity:0.5, closeButton:true});
   
	
	jQuery(".phoen-login-popup-open").colorbox({className: 'plrp_logreg', width:"50%", height:"525px", inline:true, href:"#phoen_login_data_val", opacity:0.5, closeButton:true});
	jQuery(".phoen-signup-popup-open").colorbox({className: 'plrp_logreg',width:"50%", height:"460px", inline:true, href:"#phoen_signup_data_val", opacity:0.5, closeButton:true});
	
	
	jQuery(".phoen-login-signup-popup-open").colorbox({className: 'plrp_logreg', width:"50%", height:"525px", inline:true, href:"#phoen_login_data", opacity:0.5, closeButton:true});
    jQuery(".phoen_login").colorbox({className: 'plrp_logreg', width:"50%", height:"525px", inline:true, href:"#phoen_login_data", opacity:0.5, closeButton:true});
    jQuery(".phoen_signup").colorbox({className: 'plrp_logreg',width:"50%", height:"460px", inline:true, href:"#phoen_signup_data", opacity:0.5, closeButton:true});
	
	
  //jQuery('#js_login').submit(function(event) {
	  jQuery('.js_login_log').click(function(event) {  
	  
		event.preventDefault();
	/* 	var u_name = jQuery(this).find('#username').val();//jQuery('#usernamee').val();
		var u_pass = jQuery(this).find('#password').val();//jQuery('#passwordd').val();
		var u_remember = jQuery(this).find('#rememberme').val();//jQuery('#rememberme').val();
		var wpnonce = jQuery(this).find('#wpnonce_phoe_login_pop_form').val();
		var wp_http_referer = jQuery(this).find('#wp_http_referer1').val(); */
		
			var u_name = jQuery(this).closest('#js_login').find('input[name="username"]').val();
			var u_pass = jQuery(this).closest('#js_login').find('input[name="password"]').val();
			var u_remember = jQuery(this).closest('#js_login').find('input[name="rememberme"]').val();
			var wpnonce = jQuery(this).closest('#js_login').find('input[name="_wpnonce_phoe_login_pop_form"]').val();
			var wp_http_referer = jQuery(this).closest('#js_login').find('input[name="_wp_http_referer"]').val();
		
		
		
		
		jQuery(".loader1").show();
		jQuery.ajax({
			type: 'POST',
			url : woo_log_ajaxurl.ajaxurl,
			data : {      			
					action : 'val_header',
					username : u_name,
					password : u_pass,
					rememberme : u_remember,
					wpnonce : wpnonce
					}, 
			success: function(data,status) 
			{
				if(data == '1') {
					
					jQuery(".loader1").hide();
					window.location.href = wp_http_referer;
					
				}else { 
				
				   jQuery(".loader1").hide();
				   jQuery(".result1").html(data);
				   
				}
		   }
		});

   });

  // jQuery('#js_signup').submit(function(event) { 
   
    jQuery('.phoen_reg').click(function(event) { 
   
				event.preventDefault(); 
				/* var u_email = jQuery(this).find('#reg_email_header').val();//jQuery('#reg_email_header').val();
				var u_passd = jQuery(this).find('#reg_password_header').val();//jQuery('#reg_password_header').val();
				var wp_http_referer = jQuery(this).find('#wp_http_referer').val();
				var wpnonce = jQuery(this).find('#wpnonce_phoe_register_pop_form').val(); */
				
				
				var u_email = jQuery(this).closest('#js_signup').find('input[name="email"]').val();
				var u_passd = jQuery(this).closest('#js_signup').find('input[name="password"]').val();
				var wp_http_referer = jQuery(this).closest('#js_signup').find('input[name="_wp_http_referer"]').val();
				var wpnonce = jQuery(this).closest('#js_signup').find('input[name="_wpnonce_phoe_register_pop_form"]').val();
				
				
				jQuery(".loader_reg").show();
				
			    jQuery.ajax({
					type: 'POST',
					url : woo_log_ajaxurl.ajaxurl,
					data : {      			
							action : 'val_header_signup',
							email : u_email,
							password : u_passd,
							wpnonce : wpnonce
							}, 
					success: function(data,status) {
					
						if(data == '1'){
							
							jQuery(".loader_reg").hide();
							window.location.href = wp_http_referer;
							//window.location.href = 'http://sushil.codiixx.com/my-account/';

						}else{ 
						   jQuery(".loader_reg").hide();
						   jQuery(".result2").html(data);
						   
						} 
						
				   }
				}); 
           });  
		   
   });