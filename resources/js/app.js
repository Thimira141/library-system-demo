import './bootstrap';
// Import Bootstrap as an ES module and expose for debugging/usage
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import initAjaxForms from './ajax';
// ajax form inti setup
initAjaxForms();

import initThemeToggle from './theme';
// switch theme
initThemeToggle();

// set global access point to message models
import { showModal, showConfirmModal } from './message_models';
window.showModal = showModal;
window.showConfirmModal = showConfirmModal;

// import commonly used functions
import * as utility from './utility-functions'
window.utility = utility; // expose utility function globally

// log out form event
const LogoutForm = document.getElementById('logoutForm')||false;
const LogoutFormClickButton = document.getElementById('log-out-form-button')||false;
if (LogoutFormClickButton && LogoutForm) {
    LogoutFormClickButton.addEventListener('click', () => {
        LogoutForm.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
    });
}
