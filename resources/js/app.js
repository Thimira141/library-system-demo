import './bootstrap';
// Import Bootstrap as an ES module and expose for debugging/usage
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
// ajax setup
import initAjaxForms from './ajax';
initAjaxForms();

// switch theme
import initThemeToggle from './theme';
document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
});

