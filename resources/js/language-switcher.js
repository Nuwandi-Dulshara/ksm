/**
 * Language Switcher - Handles multilingual support with LTR/RTL
 * Supported Languages: English (LTR), Arabic (RTL), Kurdish (RTL)
 */

const LanguageSwitcher = {
    // Configuration
    config: {
        storageKey: 'appLanguage',
        defaultLanguage: 'en',
        languages: {
            'en': { name: 'English', dir: 'ltr', flag: '🇺🇸' },
            'ar': { name: 'العربية', dir: 'rtl', flag: '🇸🇦' },
            'ku': { name: 'کوردی', dir: 'rtl', flag: '🇮🇶' }
        }
    },

    /**
     * Initialize language switcher
     */
    init() {
        this.loadLanguageFromStorage();
        this.setupEventListeners();
        this.applyLanguageDirection();
    },

    /**
     * Load language from localStorage or use default
     */
    loadLanguageFromStorage() {
        const saved = localStorage.getItem(this.config.storageKey);
        if (saved && this.config.languages[saved]) {
            this.setLanguage(saved, false);
        } else {
            this.setLanguage(this.config.defaultLanguage, false);
        }
    },

    /**
     * Set the current language
     * @param {string} langCode - Language code (en, ar, ku)
     * @param {boolean} reload - Whether to reload the page
     */
    setLanguage(langCode, reload = true) {
        if (!this.config.languages[langCode]) {
            console.warn(`Language ${langCode} not supported`);
            return;
        }

        // Save to localStorage
        localStorage.setItem(this.config.storageKey, langCode);

        // Update HTML lang attribute and dir
        document.documentElement.lang = langCode;
        document.documentElement.dir = this.config.languages[langCode].dir;
        document.documentElement.setAttribute('data-lang', langCode);

        // Update all data-lang attributes
        this.updatePageElements(langCode);

        if (reload) {
            // Reload page to apply server-side translations
            window.location.reload();
        }
    },

    /**
     * Get current language
     */
    getCurrentLanguage() {
        return localStorage.getItem(this.config.storageKey) || this.config.defaultLanguage;
    },

    /**
     * Get current direction (ltr or rtl)
     */
    getCurrentDirection() {
        const lang = this.getCurrentLanguage();
        return this.config.languages[lang].dir;
    },

    /**
     * Update page elements with language attributes
     * @param {string} langCode - Language code
     */
    updatePageElements(langCode) {
        const dir = this.config.languages[langCode].dir;

        // Update sidebar
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.setAttribute('data-dir', dir);
        }

        // Update main content
        const mainContent = document.querySelector('.main-content');
        if (mainContent) {
            mainContent.setAttribute('data-dir', dir);
        }

        // Update all text-align dependent elements
        this.updateTextAlignments(dir);

        // Update margin and padding directions
        this.updateSpacing(dir);

        // Update form elements
        this.updateFormElements(dir);

        // Trigger custom event for other scripts
        window.dispatchEvent(new CustomEvent('languageChanged', {
            detail: { language: langCode, direction: dir }
        }));
    },

    /**
     * Update text alignments based on direction
     * @param {string} dir - Direction (ltr or rtl)
     */
    updateTextAlignments(dir) {
        const elements = document.querySelectorAll('[data-text-align]');
        elements.forEach(el => {
            if (dir === 'rtl') {
                el.style.textAlign = 'right';
            } else {
                el.style.textAlign = 'left';
            }
        });
    },

    /**
     * Update spacing (margins and paddings) based on direction
     * @param {string} dir - Direction (ltr or rtl)
     */
    updateSpacing(dir) {
        const sidebarLinks = document.querySelectorAll('.nav-link, .sidebar a');
        sidebarLinks.forEach(link => {
            if (dir === 'rtl') {
                link.style.borderLeft = 'none';
                link.style.borderRight = '4px solid transparent';
                link.classList.add('text-align-rtl');
            } else {
                link.style.borderLeft = '4px solid transparent';
                link.style.borderRight = 'none';
                link.classList.remove('text-align-rtl');
            }
        });

        // Update active state border
        const activeLinks = document.querySelectorAll('.nav-link.active, .sidebar a.active');
        activeLinks.forEach(link => {
            if (dir === 'rtl') {
                link.style.borderLeftColor = 'transparent';
                link.style.borderRightColor = '#3b82f6';
            } else {
                link.style.borderLeftColor = '#3b82f6';
                link.style.borderRightColor = 'transparent';
            }
        });
    },

    /**
     * Update form elements direction
     * @param {string} dir - Direction (ltr or rtl)
     */
    updateFormElements(dir) {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.setAttribute('data-dir', dir);
            if (dir === 'rtl') {
                form.classList.add('rtl-form');
            } else {
                form.classList.remove('rtl-form');
            }
        });

        // Update input elements
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            if (dir === 'rtl') {
                input.style.textAlign = 'right';
            } else {
                input.style.textAlign = 'left';
            }
        });
    },

    /**
     * Apply language direction to page
     */
    applyLanguageDirection() {
        const dir = this.getCurrentDirection();
        document.documentElement.dir = dir;
        document.documentElement.setAttribute('data-dir', dir);
    },

    /**
     * Setup event listeners for language switcher buttons
     */
    setupEventListeners() {
        const switchers = document.querySelectorAll('[data-language-switch]');
        switchers.forEach(switcher => {
            switcher.addEventListener('click', (e) => {
                e.preventDefault();
                const langCode = switcher.getAttribute('data-language-switch');
                this.setLanguage(langCode, true);
            });
        });

        // Listen for language changes from other tabs
        window.addEventListener('storage', (e) => {
            if (e.key === this.config.storageKey) {
                this.loadLanguageFromStorage();
            }
        });
    },

    /**
     * Get language name
     * @param {string} langCode - Language code
     */
    getLanguageName(langCode) {
        return this.config.languages[langCode]?.name || langCode;
    },

    /**
     * Get all available languages
     */
    getAvailableLanguages() {
        return Object.entries(this.config.languages).map(([code, info]) => ({
            code,
            ...info
        }));
    }
};

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => LanguageSwitcher.init());
} else {
    LanguageSwitcher.init();
}

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LanguageSwitcher;
}
