import { showModal, showConfirmModal } from "./message_models";

export default function initAjaxForms() {
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form.ajax-form').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                clearFormErrors(form);

                // If confirmation is required
                if (form.dataset.confirm === "true") {
                    const message = form.dataset.confirmMessage || "Are you sure?";
                    showConfirmModal(message, () => {
                        submitAjaxForm(form);
                    });
                } else {
                    submitAjaxForm(form);
                }
            });
        });
    });
}

async function submitAjaxForm(form) {
    const loader = document.getElementById('page-loader');
    if (loader) loader.classList.remove('d-none');

    const formData = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: form.method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok) {
            showModal('success', data.message || 'Action completed successfully!');
            if (data.redirect) {
                setTimeout(() => window.location.href = data.redirect, 1500);
            }
        } else {
            showModal('danger', data.message || 'Something went wrong.');
            if (data.status === 'validateFail') showInvalidateData(form, data.errorBag);
        }
    } catch (error) {
        showModal('danger', 'Network error: ' + error.message);
    } finally {
        if (loader) loader.classList.add('d-none');
    }
}

function clearFormErrors(form) {
    form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
}

function showInvalidateData(form, errorBag) {
    Object.keys(errorBag).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = errorBag[field][0];
            input.insertAdjacentElement('afterend', errorDiv);
        }
    });
}
