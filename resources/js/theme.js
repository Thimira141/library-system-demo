export default function initThemeToggle() {
    const toggleBtn = document.getElementById('themeToggle');
    const icon = document.getElementById('themeToggleIcon');

    // Load saved theme or default to light
    let theme = localStorage.getItem('theme') || 'light';
    applyTheme(theme);

    toggleBtn.addEventListener('click', () => {
        theme = theme === 'light' ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
        applyTheme(theme);
    });

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        icon.className = theme === 'dark' ? 'bi bi-sun' : 'bi bi-moon';
        toggleBtn.title = `Switch to ${theme === 'dark' ? 'Light Mode' : 'Dark Mode'}`;
    }
}
