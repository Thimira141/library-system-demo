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

// set global access point to message models
import { showModal, showConfirmModal } from './message_models';
window.showModal = showModal;
window.showConfirmModal = showConfirmModal;

// import commonly used functions
import * as utility from './utility-functions'
utility.startDateTimeLiveUpdate('date-time-live-update');
utility.IncludeExcludeIgnoreButton('.iei-btn');
