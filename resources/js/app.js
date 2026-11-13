import './bootstrap';
import './motion';

// Mobile drawer (design.md §5.1). Reflects state on the button, locks body
// scroll while open, closes on link click, backdrop, close button and Escape.
const menuButton = document.querySelector('[data-menu-button]');
const mobileMenu = document.getElementById('mobile-menu');

if (menuButton && mobileMenu) {
    const closeButton = mobileMenu.querySelector('[data-menu-close]');
    const backdrop = mobileMenu.querySelector('[data-menu-backdrop]');
    const icon = menuButton.querySelector('.material-symbols-outlined');

    menuButton.dataset.labelOpen = menuButton.getAttribute('aria-label');
    menuButton.dataset.labelClose = closeButton.getAttribute('aria-label');

    const setOpen = (open, restoreFocus = false) => {
        mobileMenu.classList.toggle('is-open', open);
        mobileMenu.setAttribute('aria-hidden', String(!open));
        document.body.classList.toggle('menu-open', open);
        menuButton.setAttribute('aria-expanded', String(open));
        menuButton.setAttribute('aria-label', open
            ? menuButton.dataset.labelClose ?? 'Close menu'
            : menuButton.dataset.labelOpen ?? 'Open menu');
        icon.textContent = open ? 'close' : 'menu';

        if (open) {
            closeButton.focus();
        } else if (restoreFocus) {
            menuButton.focus();
        }
    };

    menuButton.addEventListener('click', () => {
        setOpen(!mobileMenu.classList.contains('is-open'));
    });

    closeButton.addEventListener('click', () => setOpen(false, true));
    backdrop.addEventListener('click', () => setOpen(false, true));

    mobileMenu.querySelectorAll('[data-menu-link]').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && mobileMenu.classList.contains('is-open')) {
            setOpen(false, true);
        }
    });
}

// FAQ accordion (design.md §5.9): one item open at a time, chevron rotates.
const faqButtons = document.querySelectorAll('[data-faq-button]');

faqButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const panel = button.parentElement.nextElementSibling;
        const icon = button.querySelector('.material-symbols-outlined');
        const isOpen = panel.classList.contains('is-open');

        faqButtons.forEach((other) => {
            if (other !== button) {
                other.setAttribute('aria-expanded', 'false');
                // The panel is the sibling of the button's <h3> parent.
                other.parentElement.nextElementSibling.classList.remove('is-open');
                other.querySelector('.material-symbols-outlined').classList.remove('rotate-180');
            }
        });

        button.setAttribute('aria-expanded', String(!isOpen));
        panel.classList.toggle('is-open', !isOpen);
        icon.classList.toggle('rotate-180', !isOpen);
    });
});

// Fleet card CTA pre-fills the booking form's vehicle choice (design.md §5.3).
document.querySelectorAll('[data-vehicle]').forEach((link) => {
    link.addEventListener('click', () => {
        const select = document.getElementById('vehicleChoice');
        if (select) {
            select.value = link.dataset.vehicle;
        }
    });
});

// Booking form → WhatsApp handoff (design.md §5.3, PRD §10).
const rentalForm = document.getElementById('rentalForm');

if (rentalForm) {
    const serviceSelect = rentalForm.querySelector('#serviceType');
    const routeField = rentalForm.querySelector('#routeField');
    const routeInput = rentalForm.querySelector('#travelRoute');
    const flightFields = rentalForm.querySelector('#flightFields');
    const flightNumber = rentalForm.querySelector('#flightNumber');
    const flightTime = rentalForm.querySelector('#flightTime');
    const selfDriveNotice = rentalForm.querySelector('#lepasKunciNotice');
    const dateInput = rentalForm.querySelector('#startDate');
    const submitButton = rentalForm.querySelector('button[type="submit"]');

    // Nothing in the past (PRD §10.4).
    dateInput.min = new Date().toISOString().slice(0, 10);

    const setError = (field, message) => {
        const slot = rentalForm.querySelector(`[data-error-for="${field}"]`);
        if (!slot) return;
        slot.textContent = message ?? '';
        slot.classList.toggle('hidden', !message);
    };

    // Conditional fields per service type (PRD §10.3).
    const syncConditionalFields = () => {
        const service = serviceSelect.value;
        const isDriver = service === 'driver';
        const isTransfer = service === 'transfer';

        routeField.classList.toggle('hidden', !isDriver);
        routeInput.required = isDriver;
        flightFields.classList.toggle('hidden', !isTransfer);
        flightNumber.required = isTransfer;
        flightTime.required = isTransfer;
        selfDriveNotice.classList.toggle('hidden', service !== 'selfdrive');
    };

    serviceSelect.addEventListener('change', syncConditionalFields);
    syncConditionalFields();

    const clearErrors = () => {
        rentalForm.querySelectorAll('[data-error-for]').forEach((slot) => {
            slot.textContent = '';
            slot.classList.add('hidden');
        });
    };

    rentalForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (dateInput.value && dateInput.value < dateInput.min) {
            setError('date', dateInput.dataset.pastError ?? '');
            return;
        }

        clearErrors();
        submitButton.disabled = true;

        try {
            const response = await fetch(rentalForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': rentalForm.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(Object.fromEntries(new FormData(rentalForm))),
            });

            if (response.status === 422) {
                const payload = await response.json();
                Object.entries(payload.errors ?? {}).forEach(([field, messages]) => {
                    setError(field, messages[0]);
                });
                rentalForm.classList.add('anim-shake');
                rentalForm.addEventListener('animationend', () => rentalForm.classList.remove('anim-shake'), { once: true });
                return;
            }

            if (!response.ok) {
                setError('notes', rentalForm.dataset.serviceError ?? '');
                return;
            }

            const payload = await response.json();
            const target = String(payload.whatsapp_url ?? '');
            // Defense in depth: open only URLs our own builder produces.
            if (!/^https:\/\/wa\.me\/\d+\?text=/.test(target)) {
                setError('notes', rentalForm.dataset.invalidUrlError ?? '');
                return;
            }
            window.dataLayer?.push({ event: 'rental_form_complete' });
            // Opens WhatsApp with the composed message via a programmatic
            // anchor (noopener). The visitor still has to press Send — the
            // notice below says so (PRD §10.6).
            const anchor = document.createElement('a');
            anchor.href = target;
            anchor.target = '_blank';
            anchor.rel = 'noopener noreferrer';
            document.body.appendChild(anchor);
            anchor.click();
            anchor.remove();
        } catch {
            setError('notes', 'Network error');
        } finally {
            submitButton.disabled = false;
        }
    });

    rentalForm.addEventListener('input', () => {
        window.dataLayer?.push({ event: 'rental_form_start' });
    }, { once: true });
}
