(function ($) {
	$(document).ready(function () {

		// If enabled Floating mode display Post Type selection and positioning
		$('#enable_floating_mode').on('change', function () {
			$('.wc_ss_btns-float-post-types, .wc_ss_btns-float-positions').fadeToggle();
		});

		$('#display_share_message').on('change', function () {
			$('.wc_ss_btns-display_message').fadeToggle();
		});



		// Previewing themes
		$('#wc_ss_theme_select').on('change', function () {
			// wc_ss_preview
			var wc_ss_theme = $(this).val();
			$('#wc_ss_preview').html('<img src="'+WCsspluginInfo.pluginsUrl+'/images/'+wc_ss_theme+'.png">');
		});
		
		var pageLoadPreviewImage = $('#wc_ss_theme_select').val();
		$('#wc_ss_preview').html('<img src="'+WCsspluginInfo.pluginsUrl+'/images/'+pageLoadPreviewImage+'.png">');
	});
})(window.jQuery,document)