// Social buttons
let socialBtn = document.getElementsByClassName('social-btn');

socialBtn.addEventListener('click', function (e) {
	e.preventDefault();

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

let firstBtn = document.getElementsByClassName('first-button');

if(firstBtn !== null) {
	firstBtn.addEventListener('click', function (e) {

		let animatedIcon = document.getElementsByClassName('animated-icon1');
		animatedIcon.classList.toggle('open');
	})
}
