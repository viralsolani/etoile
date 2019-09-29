(function ($) {
	$(document).ready(function () {
		$('.wc_ss_btns .wc_ss_btns-open').on('click', function () {
			$(this).parent().find('.wc_ss_btns_more_buttons').addClass('open');
		});

		// Close more share modal
		$('.wc_ss_btns-close').on('click', function () {
			var parent = $(this).parent().parent().parent();
			$(parent).find('.wc_ss_btns_more_buttons').removeClass('open');
		});

		$('.wc_ss_btns > ul > li > a, .wc_ss_btns_more_buttons ul > li > a').on('click', function (e) {
			e.preventDefault();

			var href = $(this).data('href');

			if ( typeof href != 'undefined' && href.length > 0 )
				window.open(href, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=400,height=400");
		});

		$('.wc_ss_btns_float_hide').on('click', function (e) {
			e.preventDefault();

			$(this).parent().parent().parent().addClass('hide');
		});
		$('.wc_ss_btns_float_show').on('click', function (e) {
			e.preventDefault();

			$(this).parent().parent().parent().removeClass('hide');
		});
	});
})(window.jQuery, document);