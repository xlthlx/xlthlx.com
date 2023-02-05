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

// Poe Mate Sheep
const btn_poe = document.querySelector("#btn-poe");
const src = '/wp-content/themes/xlthlx.com/assets/js/js-mate-poe.min.js';
const svg_sheep = '<svg class="sheep" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 40 40"><image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABGdBTUEAALGPC/xhBQAAAAlwSFlzAAAOwQAADsEBuJFr7QAAABh0RVh0U29mdHdhcmUAcGFpbnQubmV0IDQuMC42/Ixj3wAAArlJREFUWEfVlUFu1TAURbPDLoMFVExYBWwACXXCvFNGqBKTvwEk1sEIKc21fePr5+vEEa3URhzyfP3idwj9/cuyrG8cG74lbDiLDQeYaAobnpGL9d/vc8pVH5ZyChseEcT+fhmjfeUKh22YqMGGI0RORELTTidqrtovZYMNHb0cN9dP26TC/XK/1/t+FDWyuXd/RLBhxMs5KVenXkoeiOZh5SazJ8gFBVO9DX5cHrs76/gmG0EyJdksHNvhf34ldAMi+oYilGNfyiYk8/P7MRvNwlEF16dvCWQYysG4U4Q18viPOBQskuhLf2T+Ab2cSgKV0jvAPtZ8m+m8I8ly5bPLrRaONhhJKpRzkqhfULAueKU6SCr6jAri/qqCANftdsu1EYqilwTBULLOCOSCzbii4Pr5bof9gD+HrE//i4lI5rNwq+cKfYirE/z+MaF9lMMda32TD18/eDGlk+zYBMLvPFyQawSNGOX07anslCAoknp+IcvxDaW1kyt7QIUU5pflgBds5aJI2pcMAwFqyqiUrtOzTuSIVtDLOXSYSgIV45sDl94eqYLzciD1h8OiKGEe+2cp52wD8Wk0MhH0/vyx/b4whwEK/a8YaQXPJMunFoLEHfqS9IJOUvZUEAdclXV9o+eRecER5duCB7pDebCrNVOO9qsgvq6cFDFyI9xAl8WcGcly2S/9xe/UKEY5/NDHQ4gO4rC4jox6SRbbBXOxSwrI+anEYVrPwIFnmeZZqHrtxUgwHkRJJ+uyq2Sh6iXkIgo6Gc0isYfrUaZ72aHcxCnQBjx0Bjd0ROzJ85rRG13guCZJzgSVPEhnEhs6xpJHe2fUAVI22HCEDTucCHC9Nmqw4Yj+A8R77QHNoiE+H7YNNhyxDeD386FgpPbF52vPCBuOeIeClbBsqItXF+wx0RAXmmhnXZ4Bcktx2tSRqc4AAAAASUVORK5CYII=" width="40" height="40"/></svg>';
const svg_sheep_gray = '<svg class="sheep" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 40 40"><image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAgZJREFUWEftmF2ShCAMhPGaej69pluwhm1jAh2cnfLBeZiySiQfnV+d0sN/08P50l3APXDAIVtDD6WUCti+83zTVE2FbIYWH2rtETCtMIDKrSZDFNCEM4wW48xBespGAC9wsjmCLMuS1nUtgNZ9L2aPtRceFtCEEzCEsq6z8YCaJyYaEF3GGNRKMoCgeiijqnoYa9mgQFgxqN2+bduQioyCpnvneS7hlA3n6xx3GTj/8rWojIdgVNSx2AN0S4qoJqACiKBaNSY0tJu7gJh1WgHLtQIszyHkpwFrmxCwngEEtkKg93yt3L9d5+/PqU2nPmZB6qRBA3cA0c0tF9d+iyf3VLAyfDQGGcDLFNByc6v8oJJMFqM3876WgiVzW+5DWNkQu4qUH10rPwF4KivandrVGQQVwtNj+WGTw5p8UMHupOIlii4tWAtRzcBwW4cNAaRnPEsNnFp0N2HHLgteYpCGk+zyYkkX7mjMeS6mAUdjKeparKfZxS/gq2AvOUYVaj0ncyFVZr6dHF4vdgv13XIRVRinaqqTPAWwFH1d+b/tXvadxBxWo66KrtdwdawmNqKLObGXucSCiwAenre/Zt0JA+jf5nTfe6vTp6W+t7HDxLH5/33dEuUM97gHQXjPrahKWEFtAF4Pmi9gsu4FNBSo41sjgy8fAbCdNXtysCxYsRUJk/DzP0Upri7dyfyeAAAAAElFTkSuQmCC" width="40" height="40"/></svg>';
const isPoeActive = localStorage.getItem("poe");

async function startPoe() {
	await new Promise((resolve, reject) => {
		let js = document.createElement("script");
		js.src = src;
		js.onload = resolve;
		js.onerror = reject;
		document.body.appendChild(js)
	});

	Promise.resolve().then(function () {
		Poe.start();
		btn_poe.innerHTML = svg_sheep;
		document.body.classList.toggle("sheep");
	})
}

if (isPoeActive === "true") {
	startPoe().then();
}

poe.addEventListener("click", function (e) {
	e.preventDefault();
	let js = document.createElement("script");

	if (document.body.classList.contains("sheep")) {
		Poe.stop();
		btn_poe.innerHTML = svg_sheep_gray;
		js.src = src;
		document.body.removeChild(js)
		localStorage.setItem("poe", "false");
	}
	else {
		startPoe().then();
	}

	document.body.classList.toggle("sheep");
});
