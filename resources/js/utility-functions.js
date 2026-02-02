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


