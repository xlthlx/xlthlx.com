jQuery(document).ready(function ($) {
	function switch_lang(url) {

		$.post(switch_lang_obj.ajax_url, {
			_ajax_nonce: switch_lang_obj.nonce,
			action: "switch_lang",
			url: url,
			async: true,
			cache: true,
		}, function (result) {
			$('#push-container').html(result);
		});
	}

	$(document).on('click', 'a.switch_tab', function (e) {
		e.preventDefault();
		var url = $(this).attr("href");
		switch_lang(url);
		window.history.pushState({url: url}, '', url);
	});

	window.addEventListener('popstate', function (e) {
		if (e.state) {
			switch_lang(e.state.url);
		} else {
			var url = $(location).attr("href");
			switch_lang(url);
		}
	});
});
