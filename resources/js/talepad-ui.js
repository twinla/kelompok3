(function () {
    'use strict';

    var root = document.documentElement;
    var storageKey = 'talepad-theme';

    // Membaca tema yang tersimpan.
    function getSavedTheme() {
        try {
            var theme = window.localStorage.getItem(storageKey);

            return theme === 'dark' || theme === 'light'
                ? theme
                : 'light';

        } catch (error) {
            return root.getAttribute('data-theme') === 'dark'
                ? 'dark'
                : 'light';
        }
    }

    // Mengaktifkan tema.
    function applyTheme(theme) {
        var isDark = theme === 'dark';

        root.setAttribute(
            'data-theme',
            isDark ? 'dark' : 'light'
        );

        var toggle = document.getElementById('tp-theme-toggle');

        if (toggle) {
            toggle.setAttribute(
                'aria-pressed',
                isDark ? 'true' : 'false'
            );

            toggle.setAttribute(
                'aria-label',
                isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap'
            );

            toggle.setAttribute(
                'title',
                isDark ? 'Switch to light mode' : 'Switch to dark mode'
            );

            var icon = toggle.querySelector('.tp-theme-icon');
            var label = toggle.querySelector('.tp-theme-label');

            if (icon) {
                icon.textContent = isDark ? '☀' : '☾';
            }

            if (label) {
                label.textContent = isDark ? 'Light mode' : 'Dark mode';
            }
        }
    }

    // Tombol Dark / Light Mode.
    function setupThemeToggle() {
        applyTheme(getSavedTheme());

        var toggle = document.getElementById('tp-theme-toggle');

        if (!toggle) return;

        toggle.addEventListener('click', function () {
            var nextTheme =
                root.getAttribute('data-theme') === 'dark'
                    ? 'light'
                    : 'dark';

            applyTheme(nextTheme);

            try {
                window.localStorage.setItem(storageKey, nextTheme);
            } catch (error) {
                // Tetap dapat digunakan selama halaman terbuka.
            }
        });
    }

    // Animasi ketika elemen masuk ke layar.
    function setupScrollReveal() {
        var reduceMotion =
            window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (reduceMotion || !('IntersectionObserver' in window)) {
            return;
        }

        var selector = [
            '.story-card',
            '.tp-profile-stat',
            '.tp-progress-card',
            '.tp-history-row',
            '.tp-chapter-row',
            '.tp-character-card',
            '.tp-comment-card',
            '.tp-social-bar',
            '.tp-editor-form',
            '.tp-auth-card'
        ].join(',');

        var targets = document.querySelectorAll(selector);

        if (!targets.length) return;

        var observer = new IntersectionObserver(
            function (entries, activeObserver) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;

                    entry.target.classList.add('is-visible');

                    activeObserver.unobserve(entry.target);
                });
            },
            {
                threshold: 0.08,
                rootMargin: '0px 0px -24px 0px'
            }
        );

        targets.forEach(function (element, index) {
            element.classList.add('tp-scroll-reveal');

            element.style.setProperty(
                '--tp-reveal-delay',
                Math.min(index % 6, 5) * 55 + 'ms'
            );

            observer.observe(element);
        });
    }

    // Mempertahankan fokus keyboard pada kartu.
    function setupCardKeyboardFocus() {
        document.querySelectorAll(
            '.story-card a, .tp-chapter-row a, .tp-character-card a'
        ).forEach(function (link) {

            link.addEventListener('focus', function () {
                var card = link.closest(
                    '.story-card, .tp-chapter-row, .tp-character-card'
                );

                if (card) {
                    card.classList.add('has-keyboard-focus');
                }
            });

            link.addEventListener('blur', function () {
                var card = link.closest(
                    '.story-card, .tp-chapter-row, .tp-character-card'
                );

                if (card) {
                    card.classList.remove('has-keyboard-focus');
                }
            });
        });
    }

    // Inisialisasi seluruh UI.
    function init() {
        setupThemeToggle();
        setupScrollReveal();
        setupCardKeyboardFocus();
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            init,
            { once: true }
        );
    } else {
        init();
    }

})();
