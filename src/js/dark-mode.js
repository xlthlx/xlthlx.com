// Dark mode
const btn = document.querySelector("#btn-toggle");
const currentTheme = localStorage.getItem("theme");

if (currentTheme === "dark") {
	document.body.classList.add("dark-theme");
	btn.innerHTML = '<span class="mode">&#9788;</span>';
	btn.title = 'Light mode';
}

btn.addEventListener("click", function (e) {
	e.preventDefault();

	document.body.classList.toggle("dark-theme");
	let theme = "light";
	btn.innerHTML = '<span class="mode">&#9790;</span>';
	btn.title = 'Dark mode';

	if (document.body.classList.contains("dark-theme")) {
		theme = "dark";
		btn.innerHTML = '<span class="mode">&#9788;</span>';
		btn.title = 'Light mode';
	}

	localStorage.setItem("theme", theme);
});
