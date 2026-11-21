/** TalePad shared interactions: navigation, filters, forms and safe image fallbacks. */
document.addEventListener('DOMContentLoaded', () => {
    // Accessible navigation dropdowns.
    const dropdowns = [...document.querySelectorAll('.tp-dropdown')];
    const closeDropdowns = (except = null) => {
        dropdowns.forEach((dropdown) => {
            if (dropdown === except) return;
            dropdown.classList.remove('is-open');
            dropdown.querySelector('.tp-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        });
    };

    dropdowns.forEach((dropdown) => {
        const toggle = dropdown.querySelector('.tp-dropdown-toggle');
        toggle?.addEventListener('click', (event) => {
            event.stopPropagation();
            const willOpen = !dropdown.classList.contains('is-open');
            closeDropdowns(dropdown);
            dropdown.classList.toggle('is-open', willOpen);
            toggle.setAttribute('aria-expanded', String(willOpen));
        });
    });
    document.addEventListener('click', () => closeDropdowns());

    // Mobile navigation.
    const mobileToggle = document.querySelector('[data-mobile-toggle]');
    const mobilePanel = document.querySelector('[data-mobile-panel]');
    mobileToggle?.addEventListener('click', () => {
        const willOpen = !mobilePanel?.classList.contains('is-open');
        mobilePanel?.classList.toggle('is-open', willOpen);
        mobileToggle.setAttribute('aria-expanded', String(willOpen));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        closeDropdowns();
        mobilePanel?.classList.remove('is-open');
        mobileToggle?.setAttribute('aria-expanded', 'false');
    });

    // Chapter list search and jump selector.
    const chapterSearch = document.getElementById('chapter-search');
    const chapterRows = [...document.querySelectorAll('.tp-chapter-row')];
    chapterSearch?.addEventListener('input', () => {
        const term = chapterSearch.value.toLocaleLowerCase('id').trim();
        chapterRows.forEach((row) => {
            row.hidden = !String(row.dataset.chapterSearch || row.textContent).toLocaleLowerCase('id').includes(term);
        });
    });
    document.getElementById('chapter-jump')?.addEventListener('change', (event) => {
        if (event.target.value) window.location.assign(event.target.value);
    });

    // Show/hide password controls used on registration.
    document.querySelectorAll('.tp-password-toggle[data-target]').forEach((button) => {
        button.addEventListener('click', () => {
            const field = document.getElementById(button.dataset.target);
            if (!field) return;
            const reveal = field.type === 'password';
            field.type = reveal ? 'text' : 'password';
            button.textContent = reveal ? 'Hide' : 'Show';
            button.setAttribute('aria-pressed', String(reveal));
        });
    });

    // Reveal-on-scroll is optional and always has a visible fallback.
    const revealItems = document.querySelectorAll('.tp-reveal');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, currentObserver) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                currentObserver.unobserve(entry.target);
            });
        }, { threshold: 0.12 });
        revealItems.forEach((item) => observer.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    }

    // If a stored cover file is missing, show a designed fallback instead of a broken image icon.
    document.querySelectorAll('.story-cover, .reader-cover img, .tp-progress-cover img').forEach((image) => {
        image.addEventListener('error', () => {
            if (image.dataset.fallbackShown === 'true') return;
            image.dataset.fallbackShown = 'true';
            const card = image.closest('.story-card, .reader-header, .tp-progress-card');
            const genre = card?.querySelector('.genre')?.textContent?.trim() || 'TALEPAD EDITION';
            const title = card?.querySelector('h1, h3')?.textContent?.trim() || image.alt || 'A TalePad Story';
            const fallback = document.createElement('div');
            fallback.className = 'cover-placeholder tp-cover-fallback';
            fallback.innerHTML = '<span></span><strong></strong><small>TALEPAD EDITION</small>';
            fallback.querySelector('span').textContent = genre;
            fallback.querySelector('strong').textContent = title;
            image.replaceWith(fallback);
        }, { once: true });
    });

    // Respect a previously selected appearance if the user set one elsewhere.
    try {
        const savedTheme = localStorage.getItem('talepad-theme');
        if (savedTheme === 'dark' || savedTheme === 'light') {
            document.documentElement.dataset.theme = savedTheme;
        }
    } catch (_) {
        // Storage can be unavailable in strict browser privacy modes; the page remains usable.
    }
});
