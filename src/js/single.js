// Social buttons
function openShare(object, e, name) {
    e.preventDefault();
    object.blur();

    let href = object.getAttribute('href');
    let width = window.innerWidth;

    window.open(href, name, "toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=700,height=300,top=200,left=" + (width - 700) / 2);
}

function setPrint() {
    const pfHeaderImgUrl = '';
    const pfHeaderTagline = '';
    const pfdisableClickToDel = 0;
    const pfHideImages = 0;
    const pfImageDisplayStyle = 'block';
    const pfDisablePDF = 0;
    const pfDisableEmail = 1;
    const pfDisablePrint = 1;
    const pfCustomCSS = '';
    const pfEncodeImages = 0;
    const pfShowHiddenContent = 0;
    const pfBtVersion = '2';
    (function () {
        let pf;
        pf = document.createElement('script');
        pf.src = '//cdn.printfriendly.com/printfriendly.js';
        document.getElementsByTagName('head')[0].appendChild(pf);
    })();
}

let twitterBtn = document.getElementsByClassName('s-twitter');
if ( typeof twitterBtn !== 'undefined' && twitterBtn.length > 0 ) {
    twitterBtn[0].addEventListener('click', function (e) {
        openShare(this, e, 'twtWindow');
    });
}

let facebookBtn = document.getElementsByClassName('s-facebook');
if ( typeof facebookBtn !== 'undefined' && twitterBtn.length > 0 ) {
    facebookBtn[0].addEventListener('click', function (e) {
        openShare(this, e, 'fbWindow');
    });
}

let printBtn = document.getElementsByClassName('s-print');
if ( typeof printBtn !== 'undefined' && printBtn.length > 0 ) {
    setPrint();
    printBtn[0].addEventListener('click', function (e) {
        e.preventDefault();
        window.print();
    });
}

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
        if ( iframe.width && iframe.height ) {
            proportion = parseFloat(iframe.width) / parseFloat(iframe.height);
            parentWidth = parseFloat(window.getComputedStyle(iframe.parentElement, null).width.replace('px', ''));
            iframe.style.maxWidth = '100%';
            iframe.style.maxHeight = Math.round(parentWidth / proportion).toString() + 'px';
        }
    });
}

xlthlxResponsiveEmbeds();
window.onresize = xlthlxResponsiveEmbeds;
