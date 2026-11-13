/**
 * Motion layer — IntersectionObserver + CSS keyframes (design.md §6).
 *
 * Deterministic by design: elements are visible in their natural state; when a
 * section scrolls into view its cards get ONE CSS animation class (varied per
 * section type), which plays once and ends at the natural state. No library,
 * no from-state stuck risk, reduced-motion honored in CSS (app.css).
 */

const VARIANTS = {
    services: 'anim-slide-alt',
    fleet: 'anim-rise',
    about: 'anim-pop',
    area: 'anim-wipe',
    'how-to-order': 'anim-step',
    faq: 'anim-fade-up',
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-anim-in');
        observer.unobserve(entry.target); // play once
    });
}, { threshold: 0.15 });

Object.entries(VARIANTS).forEach(([id, variant]) => {
    const root = document.querySelector(`#${id}`);
    if (!root) return;
    const targets = root.querySelectorAll('.fleet-rail > *, .grid > *, li, #faqAccordion');
    targets.forEach((el, i) => {
        el.classList.add(variant);
        // Stagger without JS timing: CSS animation-delay via custom property.
        el.style.setProperty('--anim-i', Math.min(i, 6));
        observer.observe(el);
    });
});

// Final CTA banner: its three parts fade up (heading, sub, button).
const finalCta = document.querySelector('section.bg-gradient-to-r');
if (finalCta) {
    const parts = finalCta.querySelectorAll('h2, p, a[href^="https://wa.me"], button');
    parts.forEach((el) => {
        el.classList.add('anim-fade-up');
        observer.observe(el);
    });
}

// Form feedback: shake once on validation error (class + animationend cleanup
// handled here so repeated errors re-trigger reliably).
const rentalForm = document.getElementById('rentalForm');
if (rentalForm) {
    window.addEventListener('rental:error', () => {
        rentalForm.classList.remove('anim-shake');
        // Force reflow so the animation can restart on consecutive errors.
        void rentalForm.offsetWidth;
        rentalForm.classList.add('anim-shake');
    });
    window.addEventListener('rental:success', () => {
        rentalForm.classList.add('anim-settle');
        rentalForm.addEventListener('animationend', () => rentalForm.classList.remove('anim-settle'), { once: true });
    });
}

// Fleet rail scroll buttons (design.md §5.5): scroll by one card view,
// disable at the ends. Rail remains swipe/drag + keyboard scrollable.
const rail = document.querySelector('#fleet-rail');
const prevBtn = document.querySelector('[data-fleet-prev]');
const nextBtn = document.querySelector('[data-fleet-next]');

if (rail && prevBtn && nextBtn) {
    // Scroll exactly one card per click (card width + rail gap), so the rail
    // advances one vehicle at a time.
    const step = () => {
        const card = rail.children[0];
        if (!card) return 320;
        const styles = getComputedStyle(rail);
        const gap = parseFloat(styles.columnGap || styles.gap || '0') || 0;
        return card.getBoundingClientRect().width + gap;
    };

    // Buttons never dead-end: they wrap at the ends (infinite browsing),
    // so they stay enabled and only show a subtle faded state at the edge.
    const syncButtons = () => {
        const atStart = rail.scrollLeft <= 1;
        const atEnd = rail.scrollLeft >= rail.scrollWidth - rail.clientWidth - 1;
        prevBtn.classList.toggle('is-edge', atStart);
        nextBtn.classList.toggle('is-edge', atEnd);
        prevBtn.setAttribute('aria-disabled', String(atStart));
        nextBtn.setAttribute('aria-disabled', String(atEnd));
    };

    // Infinite wrap: at the ends, wrap to the other side instead of dead-ending.
    const wrap = (direction) => {
        rail.style.scrollSnapType = 'none';
        rail.style.scrollBehavior = 'auto';

        if (direction === 'next') {
            rail.scrollLeft = 0;
            requestAnimationFrame(() => {
                rail.style.scrollBehavior = 'smooth';
                rail.scrollBy({ left: step(), behavior: 'smooth' });
                setTimeout(() => { rail.style.scrollSnapType = ''; rail.style.scrollBehavior = ''; }, 500);
            });
        } else {
            rail.scrollLeft = rail.scrollWidth;
            requestAnimationFrame(() => {
                rail.style.scrollBehavior = 'smooth';
                rail.scrollBy({ left: -step(), behavior: 'smooth' });
                setTimeout(() => { rail.style.scrollSnapType = ''; rail.style.scrollBehavior = ''; }, 500);
            });
        }
    };

    prevBtn.addEventListener('click', () => {
        if (rail.scrollLeft <= 1) wrap('prev');
        else rail.scrollBy({ left: -step(), behavior: 'smooth' });
    });
    nextBtn.addEventListener('click', () => {
        if (rail.scrollLeft >= rail.scrollWidth - rail.clientWidth - 1) wrap('next');
        else rail.scrollBy({ left: step(), behavior: 'smooth' });
    });

    rail.addEventListener('scroll', syncButtons, { passive: true });
    syncButtons();
}
