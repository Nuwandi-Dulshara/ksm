<!-- Language Switcher Component -->
<div class="language-switcher-container">
    <div class="language-switcher-dropdown">
        <button class="language-switcher-toggle" type="button" id="languageSwitcherBtn">
            <span class="language-flag">
                @php
                $currentLang = app()->getLocale();
                $flags = ['en' => '🇺🇸', 'ar' => '🇸🇦', 'ku' => '🇮🇶'];
                $names = ['en' => 'English', 'ar' => 'العربية', 'ku' => 'کوردی'];
                @endphp
                {{ $flags[$currentLang] ?? '🌐' }}
            </span>
            <span class="language-name">{{ $names[$currentLang] ?? 'Language' }}</span>
            <i class="fas fa-chevron-down"></i>
        </button>

        <div class="language-switcher-menu" id="languageSwitcherMenu">
            <a href="#" data-language-switch="en"
                class="language-option {{ app()->getLocale() === 'en' ? 'active' : '' }}">
                <span class="flag">🇺🇸</span>
                <span class="name">English</span>
                @if(app()->getLocale() === 'en')
                <i class="fas fa-check"></i>
                @endif
            </a>
            <a href="#" data-language-switch="ar"
                class="language-option {{ app()->getLocale() === 'ar' ? 'active' : '' }}">
                <span class="flag">🇸🇦</span>
                <span class="name">العربية</span>
                @if(app()->getLocale() === 'ar')
                <i class="fas fa-check"></i>
                @endif
            </a>
            <a href="#" data-language-switch="ku"
                class="language-option {{ app()->getLocale() === 'ku' ? 'active' : '' }}">
                <span class="flag">🇮🇶</span>
                <span class="name">کوردی</span>
                @if(app()->getLocale() === 'ku')
                <i class="fas fa-check"></i>
                @endif
            </a>
        </div>
    </div>
</div>

<style>
.language-switcher-container {
    position: relative;
    display: inline-block;
}

.language-switcher-dropdown {
    position: relative;
}

.language-switcher-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background-color: #f3f4f6;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #374151;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.language-switcher-toggle:hover {
    background-color: #e5e7eb;
    border-color: #9ca3af;
}

.language-switcher-toggle:active {
    background-color: #d1d5db;
}

.language-flag {
    font-size: 18px;
    display: inline-block;
}

.language-name {
    font-size: 13px;
    font-weight: 500;
}

.language-switcher-toggle i {
    font-size: 12px;
    transition: transform 0.2s ease;
}

.language-switcher-toggle.open i {
    transform: rotate(180deg);
}

.language-switcher-menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
    z-index: 1000;
}

.language-switcher-menu.open {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.language-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    color: #374151;
    text-decoration: none;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f3f4f6;
}

.language-option:last-child {
    border-bottom: none;
}

.language-option:hover {
    background-color: #f9fafb;
    color: #1f2937;
}

.language-option.active {
    background-color: #eff6ff;
    color: #1e40af;
    font-weight: 600;
}

.language-option .flag {
    font-size: 20px;
    min-width: 24px;
    text-align: center;
}

.language-option .name {
    flex: 1;
    font-size: 14px;
}

.language-option i {
    font-size: 14px;
    color: #3b82f6;
}

/* RTL Specific */
html[dir="rtl"] .language-switcher-menu {
    right: auto;
    left: 0;
}

html[dir="rtl"] .language-switcher-toggle i {
    transform-origin: center;
}

html[dir="rtl"] .language-switcher-toggle.open i {
    transform: rotate(-180deg);
}
</style>

<script>
// Toggle language switcher menu
document.getElementById('languageSwitcherBtn')?.addEventListener('click', function(e) {
    e.preventDefault();
    const menu = document.getElementById('languageSwitcherMenu');
    const btn = this;

    menu.classList.toggle('open');
    btn.classList.toggle('open');
});

// Close menu when clicking outside
document.addEventListener('click', function(e) {
    const container = document.querySelector('.language-switcher-container');
    if (!container?.contains(e.target)) {
        const menu = document.getElementById('languageSwitcherMenu');
        const btn = document.getElementById('languageSwitcherBtn');
        menu?.classList.remove('open');
        btn?.classList.remove('open');
    }
});

// Handle language selection
document.querySelectorAll('[data-language-switch]').forEach(option => {
    option.addEventListener('click', function(e) {
        e.preventDefault();
        const lang = this.getAttribute('data-language-switch');

        // Update active state
        document.querySelectorAll('.language-option').forEach(opt => {
            opt.classList.remove('active');
            const checkmark = opt.querySelector('i');
            if (checkmark) checkmark.remove();
        });

        this.classList.add('active');
        const checkmark = document.createElement('i');
        checkmark.className = 'fas fa-check';
        this.appendChild(checkmark);

        // Set language using LanguageSwitcher
        if (typeof LanguageSwitcher !== 'undefined') {
            LanguageSwitcher.setLanguage(lang, true);
        }
    });
});

// Update flag and name when language changes
window.addEventListener('languageChanged', function(e) {
    const {
        language,
        direction
    } = e.detail;
    const flags = {
        'en': '🇺🇸',
        'ar': '🇸🇦',
        'ku': '🇮🇶'
    };
    const names = {
        'en': 'English',
        'ar': 'العربية',
        'ku': 'کوردی'
    };

    const flagSpan = document.querySelector('.language-flag');
    const nameSpan = document.querySelector('.language-name');

    if (flagSpan) flagSpan.textContent = flags[language];
    if (nameSpan) nameSpan.textContent = names[language];
});
</script>