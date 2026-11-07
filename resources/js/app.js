import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.directive('reveal', (el, {}, { cleanup }) => {
    el.classList.add('reveal');

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    el.classList.add('is-visible');
                    observer.unobserve(el);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -5% 0px' }
    );

    observer.observe(el);

    cleanup(() => observer.disconnect());
});

window.publicSite = () => ({
    dark: false,
    init() {
        const stored = localStorage.getItem('pm-theme');
        if (stored === 'dark' || stored === 'light') {
            this.dark = stored === 'dark';
        } else {
            this.dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        document.documentElement.classList.toggle('dark', this.dark);
    },
    toggleTheme() {
        this.dark = !this.dark;
        localStorage.setItem('pm-theme', this.dark ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', this.dark);
    },
});

Alpine.start();
