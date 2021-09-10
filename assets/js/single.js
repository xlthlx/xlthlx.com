// Social buttons
let socialBtn = document.querySelector('.social-btn');

socialBtn.addEventListener('click', function (e) {
	e.preventDefault();

	if (socialBtn.classList.contains('s-twitter') && typeof window.targetWindow != 'undefined') {
		return;
	}

	if (socialBtn.classList.contains('s-facebook') && typeof window.targetWindow != 'undefined') {
		return;
	}

	socialBtn.blur();

	let href = socialBtn.getAttribute('href');
	let width = window.innerWidth;

	window.open(href, 'targetWindow', "toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=700,height=300,top=200,left=" + (width - 700) / 2);
});


// HighlightJS Badge
let options = {
	copyIconClass: "open",
	copyIconContent: "Copy",
	checkIconClass: "text-success",
	checkIconContent: "Copied!",
}
window.highlightJsBadge(options);

$('.first-button').on('click', function () {
	$('.animated-icon1').toggleClass('open');
});

