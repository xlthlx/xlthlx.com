// Social buttons
function openShare(object, e, name) {
	e.preventDefault();

	object.blur();

	let href = object.getAttribute('href');
	let width = window.innerWidth;

	window.open(href, name, "toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=700,height=300,top=200,left=" + (width - 700) / 2);
}

let twitterBtn = document.getElementsByClassName('s-twitter');
twitterBtn[0].addEventListener('click', function (e) {
	openShare(this, e, 'twtWindow');
});

let facebookBtn = document.getElementsByClassName('s-facebook');
facebookBtn[0].addEventListener('click', function (e) {
	openShare(this, e, 'fbWindow');
});

// HighlightJS Badge
let options = {
	copyIconClass: "open",
	copyIconContent: "Copy",
	checkIconClass: "text-success",
	checkIconContent: "Copied!",
};

window.highlightJsBadge(options);

// Responsive Embeds
function xlthlxResponsiveEmbeds() {
	var proportion, parentWidth;

	document.querySelectorAll( 'iframe' ).forEach( function( iframe ) {
		if ( iframe.width && iframe.height ) {
			proportion = parseFloat( iframe.width ) / parseFloat( iframe.height );
			parentWidth = parseFloat( window.getComputedStyle( iframe.parentElement, null ).width.replace( 'px', '' ) );
			iframe.style.maxWidth = '100%';
			iframe.style.maxHeight = Math.round( parentWidth / proportion ).toString() + 'px';
		}
	} );
}

xlthlxResponsiveEmbeds();
window.onresize = xlthlxResponsiveEmbeds;
