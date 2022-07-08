// Dark mode
const btn = document.querySelector(".btn-toggle");
const currentTheme = localStorage.getItem("theme");

if ( currentTheme === "dark" ) {
	document.body.classList.add("dark-theme");
	btn.innerHTML = 'Light mode';
}

btn.addEventListener("click", function () {
	document.body.classList.toggle("dark-theme");
	let theme = "light";
	btn.innerHTML = 'Dark mode';

	if ( document.body.classList.contains("dark-theme") ) {
		theme = "dark";
		btn.innerHTML = 'Light mode';
	}

	localStorage.setItem("theme", theme);
});
