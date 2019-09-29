jQuery( document ).ready(function() {
	    
		setTimeout(function(){ jQuery(".services-item2 img").trigger("click"); }, 100);

    	/**************** max length ****************/		
		jQuery('input[type="text"]').attr('maxlength', 50);					
		jQuery("textarea").attr("maxlength",1000);
		jQuery('#message').attr('maxlength', 1000);	
		jQuery('#firstname,#lastname,#newslettername').attr({ maxLength : 50});
		jQuery('#email,#email_address,#confirm_email,#login-email,#newsletter').attr({ maxLength : 75});
		jQuery('#password,#confirmation').attr({ maxLength : 22});
		jQuery('#postcode,#zipcode').attr({ maxLength : 6});
		jQuery('input[type="tel"]').attr({ maxLength : 20 });
		jQuery('input[type="number"]').attr({ max : 999 });		
		jQuery('#fax,#telephone,#telephone').attr('maxlength', 18);		
		/*end max length*/
		/*Active class*/
		jQuery(function() {
        	var url = window.location.href,
            urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
			jQuery('navigation ul li a').each(function() {
				if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
					jQuery(this).parents('li').addClass('active-menu');
				}
			});
			jQuery('footer li a,ul.single-services li a').each(function() {
				if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
					jQuery(this).parent().addClass('active');
				}
			});
		});	
		/*End Active class*/
	
		var isTouchDevice = 'ontouchstart' in document.documentElement;
		if( isTouchDevice ) {
			jQuery('html').addClass('touch').removeClass('no-touch');
		} else {
			jQuery('html').addClass('no-touch').removeClass('touch');
		}
		/*************** Sticky Header *****************/
		if (jQuery(window).width() >= 1025) {
			jQuery(window).scroll(function() {
				if(jQuery(window).scrollTop() > 69)
				{
					jQuery('header').addClass('sticky');
				}
				else
				{
					jQuery('header').removeClass('sticky');
				}
			});
		} else {
			jQuery('header').removeClass("sticky");
		}
		/************* Sticky Sidebar *******************/
	
		
		/************* Back to top *******************/
		jQuery('body').append('<p id="toTop" class="btn top-btn" title="Move to top"><i class="fa fa-angle-up"></i><span clas="top-text">top</span></p>');
		jQuery(window).scroll(function() {
			if (jQuery(this).scrollTop() != 0) {
				jQuery('#toTop').fadeIn();
			} else {
				jQuery('#toTop').fadeOut();
			}
		});
		jQuery('#toTop').click(function() {
			jQuery("html, body").animate({
				scrollTop: 0
			}, 2500);
			return false;
		});
		/*******************Footer ***********************/
		
		if(jQuery(window).width() <= 767){
			jQuery('.f_box h3').click(function(){

				var closest_ele = jQuery(this).closest('.f_box');
				closest_ele.siblings().removeClass('active');
				closest_ele.toggleClass('active');
				closest_ele.siblings().find('.footer-sub').slideUp();
				closest_ele.find('.footer-sub').slideToggle();		
			});
		}
		jQuery(".requestquote a.enquiry-now").click(function() {
		 var destination=jQuery("#get-a-free-form");
			if (destination.length) {
				var contentNav = destination.offset().top-110;
   		 		jQuery('html, body').animate({
        			scrollTop: contentNav
    			}, 2000);
			}
});
	
});


jQuery( document ).ready(function() {
		if (jQuery(window).width() >= 1025) {
	var wow = new WOW(
	  {
		boxClass:     'wow',      // animated element css class (default is wow)
		animateClass: 'animated', // animation css class (default is animated)
		offset:       0,          // distance to the element when triggering the animation (default is 0)
		mobile:       true,       // trigger animations on mobile devices (default is true)
		live:         true,       // act on asynchronously loaded content (default is true)
		callback:     function(box) {
		  // the callback is fired every time an animation is started
		  // the argument that is passed in is the DOM node being animated
		},
		scrollContainer: null // optional scroll container selector, otherwise use window
	  }
	);
	wow.init();
		}
});