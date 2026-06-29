document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    initFlashMessages();
    initPageAnimations();
    initTooltips();
    initFormValidation();
});

function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const openBtn = document.getElementById('sidebar-open');
    const closeBtn = document.getElementById('sidebar-close');

    if (!sidebar || !overlay || !openBtn) return;

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        overlay.classList.remove('opacity-0');
        document.body.style.overflow = 'hidden';
        const md = window.matchMedia('(min-width: 768px)');
        if (md.matches) document.body.style.overflow = '';
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        overlay.classList.add('opacity-0');
        document.body.style.overflow = '';
    }

    openBtn.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            closeSidebar();
        }
    });

    const md = window.matchMedia('(min-width: 768px)');
    md.addEventListener('change', () => {
        if (md.matches) closeSidebar();
    });
}

function initFlashMessages() {
    document.querySelectorAll('.flash-message').forEach((msg) => {
        const dismiss = () => {
            msg.classList.add('hiding');
            setTimeout(() => msg.remove(), 400);
        };

        const timer = setTimeout(dismiss, 5000);
        msg.addEventListener('mouseenter', () => clearTimeout(timer));
        msg.addEventListener('click', dismiss);
    });
}

function initPageAnimations() {
    const mainContent = document.getElementById('main-content');
    if (mainContent) {
        mainContent.classList.add('animate-fade-in');
    }
}

function initTooltips() {
    document.querySelectorAll('[data-tooltip]').forEach((el) => {
        const text = el.getAttribute('data-tooltip');
        const tip = document.createElement('span');
        tip.className = 'tooltip-content';
        tip.textContent = text;
        el.classList.add('tooltip');
        el.appendChild(tip);
    });
}

function initFormValidation() {
    document.querySelectorAll('form[data-validate]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            const required = form.querySelectorAll('[required]');
            let valid = true;
            required.forEach((field) => {
                if (!field.value.trim()) {
                    field.classList.add('error');
                    valid = false;
                } else {
                    field.classList.remove('error');
                }
            });
            if (!valid) e.preventDefault();
        });
    });
}
