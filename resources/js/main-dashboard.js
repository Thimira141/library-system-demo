import { load_data } from "./utility-functions";
import { showModal } from "./message_models";
import { BorrowReturnDashboardInit } from "./borrow-return";

document.addEventListener("DOMContentLoaded", function () {
    startDateTimeLiveUpdate('date-time-live-update');
    setCardData();
    document.querySelector('button#main-dashboard-tab')?.addEventListener('click', setCardData);
    // init borrow return
    BorrowReturnDashboardInit();
});

/**
 * get and set cards data
 */
async function setCardData() {
    // load card data from server
    const response = await load_data(window.routes.infoCardsData, '#dashboard-info-cards-holder [data-dashboard-info-card]');

    if (response.status != 'success') {
        showModal('error', response.message)
        return null;
    }

    const cardHolder = document.querySelector('#dashboard-info-cards-holder')||false;
    if (cardHolder) {
        for(const [key, value] of Object.entries(response.cards)) {
            const cardWriter = cardHolder.querySelector(`[data-info-card-write="${key}"]`)||false;
            if (cardWriter) {
                cardWriter.textContent = value;
            }
        }
    }
}

/**
 * Update the Date and Time
 * @param {string} elementId
 * @returns
 */
function startDateTimeLiveUpdate(elementId) {
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
