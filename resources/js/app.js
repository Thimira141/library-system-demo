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

// date time live update
const dtReceiveElement = document.getElementById('date-time-live-update');
if (dtReceiveElement) {
    setInterval(() => {
        const dt = new Date();
        dtReceiveElement.innerText = dt.toLocaleString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
    }, 1000);
}
