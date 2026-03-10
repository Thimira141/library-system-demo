/**
 * Update the Date and Time
 * @param {HTMLElement} elementId
 * @returns
 */
export function startDateTimeLiveUpdate(elementId) {
    const el = document.getElementById(elementId);
    if (!el) return;
    setInterval(() => {
        const dt = new Date();
        el.textContent = dt.toLocaleString('en-US', {
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
/**
 *  Cycle the button’s value and update its background class so it reflects the state
 * @param {string} elementIdentifier string that can locate element(s)
 *
 */
export function IncludeExcludeIgnoreButton(elementIdentifier) {
    document.querySelectorAll(elementIdentifier).forEach(el => {
        el.addEventListener('click', () => {
            const currentValue = Number(el.value);

            // Cycle values 0 → 1 → 2 → 0
            const newValue = (currentValue >= 0 && currentValue < 2) ? currentValue + 1 : 0;
            el.value = newValue;

            // Remove all bg-* classes
            el.classList.forEach(cls => {
                if (cls.startsWith('bg-')) {
                    el.classList.remove(cls);
                }
            });

            // Add new bg class based on state
            switch (newValue) {
                case 0:
                    // el.classList.add('bg-secondary'); // default/ignore
                    break;
                case 1:
                    el.classList.add('bg-success');   // include
                    break;
                case 2:
                    el.classList.add('bg-danger');    // exclude
                    break;
            }
        });
    });
}

/**
 * previewing an selected(uploaded) image
 * @param {HTMLFormElement} element
 */
export function previewSelectedImage(element) {
    if (element.files && element.files[0]) {
        const imgUrl = URL.createObjectURL(element.files[0]);
        const targetImg = document.querySelector(element.dataset.targetImg);
        if (targetImg) {
            targetImg.src = imgUrl;
        }
    }
}

/**
 * Trigger Delete form on Data-table
 * @param {string} form_selector
 * @param {string} dt_selector
 * @param {HTMLElement} element
 */
export function handleDTDeleteRecord(form_selector, dt_selector, element) {
    const form = document.querySelector(form_selector);
    const hiddenInput = form.querySelector('#table-selector');

    // Set the form action to the delete endpoint
    form.setAttribute('action', element.dataset.action);

    // Set the hidden input value to the book ID
    hiddenInput.value = element.dataset.id;

    // Submit via your ajax.js handler
    form.dispatchEvent(new Event('submit', { bubbles: true }));

    // After ajax completes, reload DataTable
    form.addEventListener('ajax:success', () => {
        if ($.fn.DataTable.isDataTable(dt_selector)) {
            $(dt_selector).DataTable().ajax.reload(null, false);
        }
    }, { once: true });
}
/**
 * Show or hide a partial AJAX loader inside a container
 *
 * @param {string} selector - CSS selector for target elements
 * @param {boolean} loaded - true = remove loader, false = add loader
 */
export function partialLoadingAjax(selector, loaded) {
    const loaderHTML = `
        <div class="position-absolute top-0 end-0 w-100 h-100 z-3 d-flex justify-content-center align-items-center ajax-loader-spinner" style="backdrop-filter: blur(1px)">
            <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
        </div>
    `;

    document.querySelectorAll(selector).forEach(e => {
        if (loaded) {
            const existing = e.querySelector('.ajax-loader-spinner');
            if (existing) existing.remove();
        } else {
            // Only add if not already present
            if (!e.querySelector('.ajax-loader-spinner')) {
                e.insertAdjacentHTML('beforeend', loaderHTML);
            }
        }
    });
}

