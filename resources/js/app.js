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
window.utility = utility; // expose utility function globally
utility.startDateTimeLiveUpdate('date-time-live-update');
utility.IncludeExcludeIgnoreButton('.iei-btn');

// import tom-select and setup init-s
import { initTomSelect } from "./tom-select-init";
document.addEventListener("DOMContentLoaded", function () {
    // categories multi-select
    initTomSelect("#book_categories", {
        placeholder: "Select categories",
        valueField: "id", labelField: "category_name", searchField: "category_name",
        preload: true,
        load: (query, callback) => {
            fetch(`/ajax/category?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(json => { callback(json); })
                .catch(() => { callback(); });
        }
    });

    // Example: authors multi-select
    // initTomSelect("#authors", {
    //     placeholder: "Select authors",
    //     maxItems: 1, // single select
    // });
});

// import DataTable and its inits
import $ from 'jquery';
import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

// expose globally if needed
window.$ = $;
window.jQuery = $;

import './books-datatable';
