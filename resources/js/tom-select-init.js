import TomSelect from "tom-select";

/**
 * Initialize Tom Select on a given selector
 * @param {string} selector - CSS selector for the <select> element
 * @param {object} options - Tom Select options
 */
export function initTomSelect(selector, options = {}) {
    if (!document.querySelector(selector)) {return null};
    const defaultOptions = {
        plugins: ['remove_button', 'dropdown_input'],
        placeholder: "Select options",
        create: false,
    };

    return new TomSelect(selector, { ...defaultOptions, ...options });
}
