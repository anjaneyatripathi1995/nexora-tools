import 'bootstrap';
import '../css/app.css';

console.log('Vite loaded');

// theme (light/dark) toggle logic used by admin/user panels
function setTheme(theme) {
	document.body.classList.toggle('dark', theme === 'dark');
	// swap icon in toggle button(s)
	document.querySelectorAll('[data-theme-toggle] i').forEach(function(el) {
		el.classList.toggle('fa-moon', theme === 'light');
		el.classList.toggle('fa-sun', theme === 'dark');
	});
	localStorage.setItem('theme', theme);
}

document.addEventListener('DOMContentLoaded', function() {
	var stored = localStorage.getItem('theme');
	if (stored) {
		setTheme(stored);
	} else {
		// respect system preference if available
		var prefers = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
		setTheme(prefers);
	}
	document.querySelectorAll('[data-theme-toggle]').forEach(function(btn) {
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			var isDark = document.body.classList.toggle('dark');
			setTheme(isDark ? 'dark' : 'light');
		});
	});
});