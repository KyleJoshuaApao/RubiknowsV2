import { animate, inView, scroll, stagger } from 'motion';

const ease = [0.22, 1, 0.36, 1];

/**
 * Public-site motion: content eases in as it scrolls into view, the hero photo
 * drifts slightly with the page, and the key figures count up once.
 * Elements stay fully visible if this script never runs.
 */
export function startPublicMotion() {
    const root = document.documentElement;
    if (!root.classList.contains('rk-motion')) return;

    const hero = document.querySelector('.rk-hero');
    if (hero) {
        const lines = hero.querySelectorAll('.rk-hero__copy > *');
        animate(lines, { opacity: [0, 1], y: [24, 0] }, { duration: 0.8, delay: stagger(0.08), ease });

        const image = hero.querySelector('.rk-hero__image');
        if (image) {
            animate(image, { scale: [1.08, 1] }, { duration: 1.6, ease });
            scroll(animate(image, { y: [0, 90] }, { ease: 'linear' }), { target: hero, offset: ['start start', 'end start'] });
        }
    }

    // Single blocks.
    inView('[data-reveal]', (element) => {
        animate(element, { opacity: [0, 1], y: [28, 0] }, { duration: 0.7, ease });
    }, { amount: 0.15 });

    // Grids and lists: children follow one another.
    inView('[data-reveal-stagger]', (group) => {
        // Motion needs a real array; an HTMLCollection is treated as a plain object.
        animate(Array.from(group.children), { opacity: [0, 1], y: [32, 0] }, { duration: 0.6, delay: stagger(0.07), ease });
    }, { amount: 0.1 });

    // Figures such as "100+" count up from zero.
    inView('.rk-facts dd', (element) => {
        const match = element.textContent.trim().match(/^(\d+)(.*)$/);
        if (!match) return;
        const [, number, suffix] = match;
        const target = Number(number);
        const from = target > 1900 ? target - 30 : 0;
        animate(from, target, {
            duration: 1.4,
            ease,
            onUpdate: (value) => { element.textContent = Math.round(value) + suffix; },
        });
    }, { amount: 0.6 });

    // The header gains a shadow once the page scrolls.
    const header = document.querySelector('.rk-header');
    if (header) {
        scroll((progress) => header.classList.toggle('is-scrolled', progress > 0), { offset: ['start start', '120px start'] });
    }
}
