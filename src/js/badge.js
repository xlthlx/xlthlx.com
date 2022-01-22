(function (global, factory) {

    if ( typeof module === "object" && typeof module.exports === "object" ) {

        module.exports = global.document ?
            factory(global, true) :
            function (w) {
                if ( !w.document ) {
                    throw new Error("A window with a document is required");
                }
                return factory(w);
            };
    } else {
        factory(global);
    }


}(typeof window !== "undefined" ? window : this, function (window, noGlobal) {

    function highlightJsBadge(opt) {
        var options = {
            templateSelector: "#CodeBadgeTemplate",
            contentSelector: "body",
            loadDelay: 0,
            copyIconClass: "fa fa-copy",
            copyIconContent: "",
            checkIconClass: "fa fa-check text-success",
            checkIconContent: "",
            onBeforeCodeCopied: null
        };

        function initialize(opt) {
            Object.assign(options, opt);

            if ( document.readyState == 'loading' )
                document.addEventListener("DOMContentLoaded", load);
            else
                load();
        }


        function load() {
            if ( options.loadDelay )
                setTimeout(addCodeBadge, loadDelay);
            else
                addCodeBadge();
        }

        function addCodeBadge() {
            // first make sure the template exists - if not we embed it
            if ( !document.querySelector(options.templateSelector) ) {
                var node = document.createElement("div");
                node.innerHTML = getTemplate();
                var style = node.querySelector("style");
                var template = node.querySelector(options.templateSelector);
                document.body.appendChild(style);
                document.body.appendChild(template);
            }

            var hudText = document.querySelector(options.templateSelector).innerHTML;

            var $codes = document.querySelectorAll("pre>code.hljs");
            for (var index = 0; index < $codes.length; index++) {
                var el = $codes[index];
                if ( el.querySelector(".code-badge") )
                    continue; // already exists

                var lang = "";

                for (var i = 0; i < el.classList.length; i++) {
                    var cl = el.classList[i];
                    // class="hljs language-csharp"
                    if ( cl.substr(0, 9) === 'language-' ) {
                        lang = el.classList[i].replace('language-', '');
                        break;
                    }
                    // class="hljs lang-cs"  // docFx
                    else if ( cl.substr(0, 5) === 'lang-' ) {
                        lang = el.classList[i].replace('lang-', '');
                        break;
                    }
                    // class="kotlin hljs"   (auto detected)
                    if ( !lang ) {
                        for (var j = 0; j < el.classList.length; j++) {
                            if ( el.classList[j] == 'hljs' )
                                continue;
                            lang = el.classList[j];
                            break;
                        }
                    }
                }

                if ( lang )
                    lang = lang.toLowerCase();
                else
                    lang = "text";

                // Language Name overrides so it displays nicer
                if ( lang == "ps" )
                    lang = "powershell";
                else if ( lang == "cs" )
                    lang = "csharp";
                else if ( lang == "js" )
                    lang = "javascript";
                else if ( lang == "ts" )
                    lang = "typescript";
                else if ( lang == "fox" )
                    lang = "foxpro";
                else if ( lang == "txt" )
                    lang = "text";


                var html = hudText.replace("{{language}}", lang)
                    .replace("{{copyIconClass}}", options.copyIconClass)
                    .trim();

                // insert the Hud panel
                var $newHud = document.createElement("div");
                $newHud.innerHTML = html;
                $newHud = $newHud.querySelector(".code-badge");

                // make <pre> tag position:relative so positioning keeps pinned right
                // even with scroll bar scrolled
                var pre = el.parentElement;
                pre.classList.add("code-badge-pre");

                if ( options.copyIconContent )
                    $newHud.querySelector(".code-badge-copy-icon").innerText = options.copyIconContent;

                pre.insertBefore($newHud, el);
            }

            var $content = document.querySelector(options.contentSelector);

            // single copy click handler
            $content.addEventListener("click",
                function (e) {
                    var $clicked = e.srcElement;
                    if ( $clicked.classList.contains("code-badge-copy-icon") ) {
                        e.preventDefault();
                        e.cancelBubble = true;
                        copyCodeToClipboard(e);
                    }
                    return false;
                });
        }


        function copyCodeToClipboard(e) {
            // walk back up to <pre> tag
            var $origCode = e.srcElement.parentElement.parentElement.parentElement;

            // select the <code> tag and grab text
            var $code = $origCode.querySelector("pre>code");
            var text = $code.textContent || $code.innerText;

            if ( options.onBeforeCodeCopied )
                text = options.onBeforeCodeCopied(text, $code);

            // Create a textblock and assign the text and add to document
            var el = document.createElement('textarea');
            el.value = text.trim();
            document.body.appendChild(el);
            el.style.display = "block";

            // select the entire textblock
            if ( window.document.documentMode )
                el.setSelectionRange(0, el.value.length);
            else
                el.select();

            // copy to clipboard
            document.execCommand('copy');

            // clean up element
            document.body.removeChild(el);

            // show the check icon (copied) briefly
            swapIcons($origCode);
        }

        function swapIcons($code) {
            var copyIcons = options.copyIconClass.split(' ');
            var checkIcons = options.checkIconClass.split(' ');

            var $fa = $code.querySelector(".code-badge-copy-icon");
            $fa.innerText = options.checkIconContent;

            for (var i = 0; i < copyIcons.length; i++)
                $fa.classList.remove(copyIcons[i]);

            for (var y = 0; y < checkIcons.length; y++)
                $fa.classList.add(checkIcons[y]);


            setTimeout(function () {
                $fa.innerText = options.copyIconContent;

                for (var i = 0; i < checkIcons.length; i++)
                    $fa.classList.remove(checkIcons[i]);
                for (var y = 0; y < copyIcons.length; y++)
                    $fa.classList.add(copyIcons[y]);
            }, 2000);
        }

        function getTemplate() {
            var stringArray =
                [
                    "<style>",
                    "@media print {",
                    "   .code-badge { display: none; }",
                    "}",
                    "    .code-badge-pre {",
                    "        position: relative;",
                    "    }",
                    "    .code-badge {",
                    "        display: flex;",
                    "        flex-direction: row;",
                    "        white-space: normal;",
                    "        background: transparent;",
                    "        background: #333;",
                    "        color: white;",
                    "        font-size: 0.875em;",
                    "        opacity: 0.5;",
                    "        transition: opacity linear 0.5s;",
                    "        border-radius: 0 0 0 7px;",
                    "        padding: 5px 8px 5px 8px;",
                    "        position: absolute;",
                    "        right: 0;",
                    "        top: 0;",
                    "    }",
                    "    .code-badge.active {",
                    "        opacity: 0.8;",
                    "    }",
                    "",
                    "    .code-badge:hover {",
                    "        opacity: .95;",
                    "    }",
                    "",
                    "    .code-badge a,",
                    "    .code-badge a:hover {",
                    "        text-decoration: none;",
                    "    }",
                    "",
                    "    .code-badge-language {",
                    "        margin-right: 10px;",
                    "        font-weight: 600;",
                    "        color: goldenrod;",
                    "    }",
                    "    .code-badge-copy-icon {",
                    "        font-size: 1.2em;",
                    "        cursor: pointer;",
                    "        padding: 0 7px;",
                    "        margin-top:2;",
                    "    }",
                    "    .fa.text-success:{ color: limegreen !important }",
                    "</style>",
                    "<div id=\"CodeBadgeTemplate\" style=\"display:none\">",
                    "    <div class=\"code-badge\">",
                    "        <div class=\"code-badge-language\" >{{language}}</div>",
                    "        <div  title=\"Copy to clipboard\">",
                    "            <i class=\"{{copyIconClass}} code-badge-copy-icon\"></i></i></a>",
                    "        </div>",
                    "     </div>",
                    "</div>"
                ];

            var t = "";
            for (var i = 0; i < stringArray.length; i++)
                t += stringArray[i] + "\n";

            return t;
        }

        initialize(opt);
    }

	// global reference Window
    window.highlightJsBadge = highlightJsBadge;

	// module export
    if ( window.module && window.module.exports )
        window.module.exports.highlightJsBadge = highlightJsBadge;

}));
