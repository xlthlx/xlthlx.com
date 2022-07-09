// Dark mode
const btn = document.querySelector("#btn-toggle");
const currentTheme = localStorage.getItem("theme");

if ( currentTheme === "dark" ) {
	document.body.classList.add("dark-theme");
	btn.innerHTML = '☼';
}

btn.addEventListener("click", function (e) {
	e.preventDefault();
	document.body.classList.toggle("dark-theme");
	let theme = "light";
	btn.innerHTML = '☾';

	if ( document.body.classList.contains("dark-theme") ) {
		theme = "dark";
		btn.innerHTML = '☼';
	}

	localStorage.setItem("theme", theme);
});
