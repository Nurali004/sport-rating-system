/* ============================================
   SPORTS RATING - app.js
   ============================================ */

// ======================== THEME TOGGLE ========================
(function () {
    const btn = document.getElementById('themeToggle');
    if (!btn) return;
    const apply = (theme) => {
        if (theme === 'light') {
            document.body.classList.add('light-theme');
            btn.textContent = '☀️';
        } else {
            document.body.classList.remove('light-theme');
            btn.textContent = '🌙';
        }
    };
    // Load saved
    apply(localStorage.getItem('theme') || 'dark');
    btn.addEventListener('click', () => {
        const isLight = document.body.classList.contains('light-theme');
        const next = isLight ? 'dark' : 'light';
        localStorage.setItem('theme', next);
        apply(next);
    });
})();

// ======================== LANGUAGE ========================
(function () {
    const saved = localStorage.getItem('lang') || 'uz';
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.lang === saved);
        btn.addEventListener('click', () => {
            localStorage.setItem('lang', btn.dataset.lang);
            document.querySelectorAll('.lang-btn').forEach(b => b.classList.toggle('active', b === btn));
            // Sizning tarjima logikangiz shu yerga kiradi
        });
    });
})();

// ======================== MOBILE NAV ========================
(function () {
    const toggler = document.querySelector('.navbar-toggler');
    const navLinks = document.querySelector('.nav-links');
    const navActions = document.querySelector('.nav-actions');
    if (!toggler) return;
    toggler.addEventListener('click', () => {
        navLinks  && navLinks.classList.toggle('open');
        navActions && navActions.classList.toggle('open');
    });
})();

// ======================== ACTIVE NAV LINK ========================
(function () {
    const page = location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav-links a').forEach(a => {
        if (a.getAttribute('href') === page) a.classList.add('active');
    });
})();

// ======================== FILTER PILLS ========================
function initFilterPills(pillSelector, itemSelector, dataAttr) {
    const pills = document.querySelectorAll(pillSelector);
    const items = document.querySelectorAll(itemSelector);
    if (!pills.length || !items.length) return;

    pills.forEach(pill => {
        pill.addEventListener('click', () => {
            pills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            const val = pill.dataset.filter;
            items.forEach(item => {
                item.style.display = (val === 'all' || item.dataset[dataAttr] === val) ? '' : 'none';
            });
        });
    });
}

// ======================== SEARCH ========================
function initSearch(inputId, itemSelector, searchKey) {
    const input = document.getElementById(inputId);
    const items = document.querySelectorAll(itemSelector);
    if (!input || !items.length) return;
    input.addEventListener('input', () => {
        const val = input.value.toLowerCase();
        items.forEach(item => {
            const text = (item.dataset[searchKey] || item.textContent).toLowerCase();
            item.style.display = text.includes(val) ? '' : 'none';
        });
    });
}

// ======================== PROFILE TABS ========================
function initProfileTabs() {
    const tabs    = document.querySelectorAll('.profile-tabs [data-tab]');
    const panels  = document.querySelectorAll('[data-panel]');
    if (!tabs.length) return;

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const target = tab.dataset.tab;
            panels.forEach(p => {
                p.style.display = p.dataset.panel === target ? '' : 'none';
            });
        });
    });
    // Show first tab by default
    if (tabs[0]) tabs[0].click();
}

// ======================== SCORE BAR ANIMATE ========================
function animateScoreBars() {
    document.querySelectorAll('.score-bar-fill[data-width]').forEach(bar => {
        setTimeout(() => { bar.style.width = bar.dataset.width + '%'; }, 100);
    });
}

// ======================== FADE-UP ANIMATION ========================
function initFadeUp() {
    const els = document.querySelectorAll('.fade-up');
    if (!('IntersectionObserver' in window)) {
        els.forEach(el => el.style.opacity = '1');
        return;
    }
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.style.animationPlayState = 'running'; } });
    }, { threshold: 0.1 });
    els.forEach(el => obs.observe(el));
}

// ======================== INIT ========================
document.addEventListener('DOMContentLoaded', () => {
    initProfileTabs();
    animateScoreBars();
    initFadeUp();

    // Rating page
    initFilterPills('[data-filter-pill]', '[data-sport]', 'sport');
    initSearch('athleteSearch', '[data-athlete]', 'athlete');

    // Competitions page
    initFilterPills('[data-comp-filter]', '[data-level]', 'level');

    // News page
    initFilterPills('[data-news-filter]', '[data-cat]', 'cat');
});
