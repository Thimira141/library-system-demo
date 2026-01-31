import { Modal } from 'bootstrap';

export function showModal(type, message) {
    const modalBody = document.getElementById('feedbackModalBody');
    const modalTitle = document.getElementById('feedbackModalLabel');

    modalTitle.textContent = type === 'success' ? 'Success' : 'Error';
    modalTitle.className = 'modal-title text-' + type;

    modalBody.textContent = message;
    modalBody.className = 'modal-body text-' + type;

    const feedbackModal = new Modal(document.getElementById('feedbackModal'));
    feedbackModal.show();
}

export function showConfirmModal(message, onConfirm) {
    const modalBody = document.getElementById('confirmModalBody');
    modalBody.textContent = message;

    const modalElement = document.getElementById('confirmModal');
    const confirmModal = new Modal(modalElement);

    const proceedBtn = document.getElementById('confirmModalProceed');
    const handler = () => {
        onConfirm();
        confirmModal.hide();
        proceedBtn.removeEventListener('click', handler);
    };
    proceedBtn.addEventListener('click', handler);

    confirmModal.show();
}
