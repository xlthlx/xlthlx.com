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
	let proportion, parentWidth;

	document.querySelectorAll('iframe').forEach(function (iframe) {
		if (iframe.width && iframe.height) {
			proportion = parseFloat(iframe.width) / parseFloat(iframe.height);
			parentWidth = parseFloat(window.getComputedStyle(iframe.parentElement, null).width.replace('px', ''));
			iframe.style.maxWidth = '100%';
			iframe.style.maxHeight = Math.round(parentWidth / proportion).toString() + 'px';
		}
	});
}

xlthlxResponsiveEmbeds();
window.onresize = xlthlxResponsiveEmbeds;
