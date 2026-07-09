/* ========================================
   PREMIUM BLOG - MAIN JAVASCRIPT
   ======================================== */

document.addEventListener('DOMContentLoaded', () => {

    // ── LOADER ──
    const loader = document.querySelector('.loader');
    if (loader) {
        setTimeout(() => loader.classList.add('hidden'), 1800);
    }

    // ── NAVBAR SCROLL ──
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });
    }

    // ── HAMBURGER MENU ──
    const hamburger = document.querySelector('.hamburger');
    const navLinks  = document.querySelector('.nav-links');
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('open');
            const spans = hamburger.querySelectorAll('span');
            spans[0].style.transform = navLinks.classList.contains('open')
                ? 'rotate(45deg) translate(5px, 5px)' : '';
            spans[1].style.opacity  = navLinks.classList.contains('open') ? '0' : '1';
            spans[2].style.transform = navLinks.classList.contains('open')
                ? 'rotate(-45deg) translate(5px, -5px)' : '';
        });

        // Close on link click
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('open');
            });
        });
    }

    // ── BACK TO TOP ──
    const backBtn = document.querySelector('.back-to-top');
    if (backBtn) {
        window.addEventListener('scroll', () => {
            backBtn.classList.toggle('visible', window.scrollY > 400);
        });
        backBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ── SCROLL REVEAL ANIMATION ──
    const revealElements = document.querySelectorAll(
        '.post-card, .stat-item, .section-header, .featured-card, .contact-item, .stat-card'
    );

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    // Add CSS for animation
    const style = document.createElement('style');
    style.textContent = `
        .post-card, .stat-item, .section-header,
        .featured-card, .contact-item, .stat-card {
            opacity: 0;
            transform: translateY(30px);
        }
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);

    revealElements.forEach((el, i) => {
        el.style.animationDelay = `${i * 0.1}s`;
        revealObserver.observe(el);
    });

    // ── COUNTER ANIMATION ──
    const counters = document.querySelectorAll('.counter');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(c => counterObserver.observe(c));

    function animateCounter(el) {
        const target   = parseInt(el.dataset.target);
        const duration = 2000;
        const step     = target / (duration / 16);
        let current    = 0;
        const timer    = setInterval(() => {
            current += step;
            if (current >= target) {
                el.textContent = target;
                clearInterval(timer);
            } else {
                el.textContent = Math.floor(current);
            }
        }, 16);
    }

    // ── ACTIVE NAV LINK ──
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('.nav-links a').forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'index.php')) {
            link.classList.add('active');
        }
    });

    // ── NEWSLETTER FORM ──
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn   = newsletterForm.querySelector('button');
            const input = newsletterForm.querySelector('input');
            if (!input.value) return;
            btn.textContent = '✓ Subscribed!';
            btn.style.background = '#10b981';
            input.value = '';
            setTimeout(() => {
                btn.textContent = 'Subscribe';
                btn.style.background = '';
            }, 3000);
        });
    }

    // ── CONTACT FORM ──
    const contactForm = document.querySelector('#contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = contactForm.querySelector('button[type="submit"]');
            btn.innerHTML = '✓ Message Sent!';
            btn.style.background = '#10b981';
            contactForm.reset();
            setTimeout(() => {
                btn.innerHTML = 'Send Message →';
                btn.style.background = '';
            }, 3000);
        });
    }

    // ── READING PROGRESS BAR ──
    const progressBar = document.querySelector('.reading-progress');
    if (progressBar) {
        window.addEventListener('scroll', () => {
            const scrollTop    = window.scrollY;
            const docHeight    = document.body.scrollHeight - window.innerHeight;
            const progress     = (scrollTop / docHeight) * 100;
            progressBar.style.width = `${progress}%`;
        });
    }

    // ── TOOLTIP ──
    document.querySelectorAll('[data-tooltip]').forEach(el => {
        el.addEventListener('mouseenter', (e) => {
            const tip = document.createElement('div');
            tip.className = 'tooltip';
            tip.textContent = el.dataset.tooltip;
            tip.style.cssText = `
                position: fixed;
                background: var(--primary);
                color: white;
                padding: 6px 12px;
                border-radius: 8px;
                font-size: 0.8rem;
                z-index: 9999;
                pointer-events: none;
                left: ${e.clientX}px;
                top: ${e.clientY - 40}px;
            `;
            document.body.appendChild(tip);
            el._tooltip = tip;
        });
        el.addEventListener('mouseleave', () => {
            if (el._tooltip) {
                el._tooltip.remove();
                el._tooltip = null;
            }
        });
    });

    console.log('%c✦ Premium Blog Loaded', 'color: #e94560; font-size: 16px; font-weight: bold;');
});
