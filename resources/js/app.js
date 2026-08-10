const themes = ['system', 'light', 'dark'];
function getStoredTheme() {
    return localStorage.getItem('theme') || 'system';
}
function applyTheme(theme) {
    const html = document.documentElement;
    const buttons = document.querySelectorAll('.themeToggleBtn');
    localStorage.setItem('theme', theme);
    if (theme === 'dark') {
        html.classList.add('dark');
        buttons.forEach(btn => {
            btn.innerHTML = '<i class="fas fa-moon"></i>';
            btn.title = 'Dark Mode';
        });
    } else if (theme === 'light') {
        html.classList.remove('dark');
        buttons.forEach(btn => {
            btn.innerHTML = '<i class="fas fa-sun"></i>';
            btn.title = 'Light Mode';
        });
    } else {
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }
        buttons.forEach(btn => {
            btn.innerHTML = '<i class="fas fa-desktop"></i>';
            btn.title = 'System Theme';
        });
    }
}
window.cycleTheme = function () {
    const currentTheme = getStoredTheme();
    const currentIndex = themes.indexOf(currentTheme);
    const nextTheme = themes[(currentIndex + 1) % themes.length];
    applyTheme(nextTheme);
};
(function () {
    const savedTheme = getStoredTheme();
    applyTheme(savedTheme);
})();
document.addEventListener('DOMContentLoaded', () => {
    applyTheme(getStoredTheme());
    document.querySelectorAll('form[action*="logout"]').forEach(form => {
        form.addEventListener('submit', () => {
            localStorage.removeItem('theme');
            localStorage.removeItem('cookies_accepted');
        });
    });
});
window.matchMedia('(prefers-color-scheme: dark)')
    .addEventListener('change', () => {
        if (getStoredTheme() === 'system') {
            applyTheme('system');
        }
    });