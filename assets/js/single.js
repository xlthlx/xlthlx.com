var $ = jQuery.noConflict();

$(document).ready(function () {
	var url = location.href;

	if (location.hash) {
		var hash = url.split("#");
		if ((hash[1] === 'it') || (hash[1] === 'en')) {
			window.location.href = hash[0] + '/' + hash[1] + '/';
		}
	}

	// Social buttons
	$(document).on('click', '.social-btn', function (e) {

		e.preventDefault();

		if ($(this).hasClass('s-twitter') && typeof window.twttr != 'undefined') {
			return;
		}

		if ($(this).attr('href') === '#') {
			return false;
		}

		$(this).blur();

		window.open($(this).attr('href'), 'targetWindow', "toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=700,height=300,top=200,left=" + ($(window).innerWidth() - 700) / 2);

	});

	// HighlightJS Badge
	var options = {
		copyIconClass: "open",
		copyIconContent: "Copy",
		checkIconClass: "text-success",
		checkIconContent: "Copied!",
	};
	window.highlightJsBadge(options);

	$('.first-button').on('click', function () {
		$('.animated-icon1').toggleClass('open');
	});

	// Use history.pushState to switch lang
	function switch_lang(url) {

		$.ajax({
			url: url,
			type: 'GET',
			async: true,
			cache: true,
			success: function (result) {
				var cont = $(result).find('#push-container');
				var data = cont[0].innerHTML;
				$('#push-container').html(data);
			}
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


/*jQuery(document).ready(function ($) {

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

});*/
