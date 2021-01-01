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

	// HighlightJS
	var pres = document.querySelectorAll("pre>code");
	for (var i = 0; i < pres.length; i++) {
		hljs.highlightBlock(pres[i]);
	}
	var options = {
		copyIconClass: "icon-copy",
		checkIconClass: "icon-check text-success"
	};
	window.highlightJsBadge(options);

	$('.first-button').on('click', function () {
		$('.animated-icon1').toggleClass('open');
	});
});
