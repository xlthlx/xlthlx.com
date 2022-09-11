// Dark mode
const btn = document.querySelector("#btn-toggle");
const currentTheme = localStorage.getItem("theme");
const sun = '<svg class="dark-mode" aria-label="Light mode" role="img" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';

if (currentTheme === "dark") {
	document.body.classList.add("dark-theme");
	btn.innerHTML = sun;
	btn.title = 'Light mode';
}

btn.addEventListener("click", function (e) {
	e.preventDefault();

	document.body.classList.toggle("dark-theme");
	let theme = "light";
	btn.innerHTML = '<svg class="dark-mode" aria-label="Dark mode" role="img" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>';
	btn.title = 'Dark mode';

	if (document.body.classList.contains("dark-theme")) {
		theme = "dark";
		btn.innerHTML = sun;
		btn.title = 'Light mode';
	}

	localStorage.setItem("theme", theme);
});

window.addEventListener('DOMContentLoaded', (e) => {
	if (currentTheme === '') {
		localStorage.setItem("theme", "dark");
	}
});
