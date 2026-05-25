# Code Snippets & Examples - Copy-Paste Ready

## 🚀 Complete Implementation Summary

All files have been created and integrated. Here's what was done:

---

## 📝 File Directory Structure

```
accosys/
├── resources/
│   ├── js/
│   │   └── language-switcher.js              ✅ CREATED
│   ├── css/
│   │   └── rtl.css                           ✅ CREATED
│   ├── views/
│   │   ├── components/
│   │   │   └── language-switcher.blade.php   ✅ CREATED
│   │   └── layouts/
│   │       ├── app.blade.php                 ✅ MODIFIED
│   │       └── sidebar.blade.php             ✅ MODIFIED
│   └── lang/
│       ├── en/messages.php                   ✅ UPDATED
│       ├── ar/messages.php                   ✅ UPDATED
│       └── ku/messages.php                   ✅ UPDATED
├── public/
│   ├── js/
│   │   └── language-switcher.js              ✅ CREATED (Asset)
│   └── css/
│       └── rtl.css                           ✅ CREATED (Asset)
├── MULTILINGUAL_RTL_LTR_IMPLEMENTATION.md    ✅ CREATED
└── RTL_LTR_QUICK_REFERENCE.md                ✅ CREATED
```

---

## 🎯 Complete Code Snippets

### **1. Use Language Switcher Component in Your Blade**

```blade
<!-- In any blade file -->
<x-language-switcher />

<!-- In navigation/header -->
<nav class="navbar">
    <div class="navbar-brand">My App</div>
    <div class="navbar-menu">
        <x-language-switcher />
    </div>
</nav>

<!-- In footer -->
<footer>
    <p>© 2026 My Company</p>
    <x-language-switcher />
</footer>
```

---

### **2. Get Language in PHP/Blade**

```blade
<!-- Get current language -->
Current Language: {{ app()->getLocale() }}

<!-- Get current direction -->
Direction: {{ app()->getLocale() === 'ar' || app()->getLocale() === 'ku' ? 'RTL' : 'LTR' }}

<!-- Use in conditional -->
@if(app()->getLocale() === 'ar')
    <p>This is Arabic</p>
@elseif(app()->getLocale() === 'ku')
    <p>This is Kurdish</p>
@else
    <p>This is English</p>
@endif

<!-- Use translation -->
{{ __('messages.dashboard') }}
{{ __('messages.language') }}
{{ __('messages.select_language') }}
```

---

### **3. Get Language in JavaScript**

```javascript
// Get current language
const currentLang = LanguageSwitcher.getCurrentLanguage();
console.log(currentLang); // 'en', 'ar', or 'ku'

// Get current direction
const direction = LanguageSwitcher.getCurrentDirection();
console.log(direction); // 'ltr' or 'rtl'

// Get language name
const name = LanguageSwitcher.getLanguageName("ar");
console.log(name); // 'العربية'

// Get all available languages
const allLanguages = LanguageSwitcher.getAvailableLanguages();
console.log(allLanguages);
// Output: [
//   { code: 'en', name: 'English', dir: 'ltr', flag: '🇺🇸' },
//   { code: 'ar', name: 'العربية', dir: 'rtl', flag: '🇸🇦' },
//   { code: 'ku', name: 'کوردی', dir: 'rtl', flag: '🇮🇶' }
// ]

// Change language
LanguageSwitcher.setLanguage("ar", true); // true = reload page

// Listen for language changes
window.addEventListener("languageChanged", function (e) {
    const { language, direction } = e.detail;
    console.log(`Language changed to: ${language}`);
    console.log(`Direction: ${direction}`);
    // Your custom code here
});
```

---

### **4. RTL-Aware CSS Examples**

```css
/* Basic RTL Support */
html[dir="rtl"] .my-element {
    margin-right: 20px;
    text-align: right;
}

html[dir="ltr"] .my-element {
    margin-left: 20px;
    text-align: left;
}

/* Sidebar Positioning */
html[dir="rtl"] .sidebar {
    right: 0;
    left: auto;
}

html[dir="ltr"] .sidebar {
    left: 0;
    right: auto;
}

/* Border Positioning */
html[dir="rtl"] .panel {
    border-right: 4px solid blue;
    border-left: none;
}

html[dir="ltr"] .panel {
    border-left: 4px solid blue;
    border-right: none;
}

/* Padding Utilities */
html[dir="rtl"] .pl-4 {
    padding-left: 0;
    padding-right: 1rem;
}

html[dir="ltr"] .pl-4 {
    padding-left: 1rem;
    padding-right: 0;
}

/* Flexbox Direction */
html[dir="rtl"] .flex-row {
    flex-direction: row-reverse;
}

html[dir="ltr"] .flex-row {
    flex-direction: row;
}

/* Icon with Text */
html[dir="rtl"] .icon-text {
    display: flex;
    flex-direction: row-reverse;
    gap: 10px;
}

html[dir="ltr"] .icon-text {
    display: flex;
    flex-direction: row;
    gap: 10px;
}
```

---

### **5. Create Custom Components with RTL Support**

```blade
<!-- resources/views/components/my-card.blade.php -->

<div class="card {{ $class ?? '' }}">
    <div class="card-header">
        <h3>{{ $title }}</h3>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
    <div class="card-footer">
        <button class="btn btn-primary">{{ __('messages.save_record') }}</button>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    html[dir="rtl"] .card-header {
        text-align: right;
    }

    html[dir="ltr"] .card-header {
        text-align: left;
    }
</style>
```

Usage:

```blade
<x-my-card title="My Title" class="mb-4">
    <p>My content here</p>
</x-my-card>
```

---

### **6. Conditional Rendering Based on Language**

```blade
<!-- Show different content for RTL languages -->
@if(in_array(app()->getLocale(), ['ar', 'ku']))
    <!-- RTL Content -->
    <div style="text-align: right;">
        <p>محتوى عربي</p>
    </div>
@else
    <!-- LTR Content -->
    <div style="text-align: left;">
        <p>English Content</p>
    </div>
@endif

<!-- Show different CSS for language -->
<div
    @if(app()->getLocale() === 'ar' || app()->getLocale() === 'ku')
        style="text-align: right; direction: rtl;"
    @else
        style="text-align: left; direction: ltr;"
    @endif
>
    Content
</div>
```

---

### **7. Add Translation Keys**

```php
// resources/lang/en/messages.php
return [
    'my_key' => 'My English Value',
    'welcome' => 'Welcome to AccoSys',
    'my_feature' => 'This is my feature',
];

// resources/lang/ar/messages.php
return [
    'my_key' => 'قيمتي الإنجليزية',
    'welcome' => 'مرحبا بك في AccoSys',
    'my_feature' => 'هذه ميزتي',
];

// resources/lang/ku/messages.php
return [
    'my_key' => 'کاتی ئینگلیزی',
    'welcome' => 'بەخێر هاتن بۆ AccoSys',
    'my_feature' => 'ئەمە تایبەتمەندی منە',
];

// Use in Blade
{{ __('messages.my_key') }}
{{ __('messages.welcome') }}
{{ __('messages.my_feature') }}
```

---

### **8. Language Switcher Event Handling**

```javascript
// Execute code when language changes
window.addEventListener("languageChanged", function (e) {
    const { language, direction } = e.detail;

    // Update UI elements
    console.log(`Language changed to: ${language}`);

    // Update localStorage
    localStorage.setItem("userLanguage", language);

    // Update analytics
    if (typeof gtag !== "undefined") {
        gtag("config", "GA_MEASUREMENT_ID", {
            language: language,
        });
    }

    // Update other systems
    updateUserPreferences(language);

    // Reload specific components if needed
    reloadComponentsForLanguage(language);
});

function updateUserPreferences(language) {
    // Update user profile
    fetch("/api/user/language", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify({ language: language }),
    });
}

function reloadComponentsForLanguage(language) {
    // Reload specific elements that need updates
    document.querySelectorAll("[data-language-dependent]").forEach((el) => {
        // Your reload logic here
    });
}
```

---

### **9. Form RTL Styling**

```blade
<form method="POST" action="{{ route('store') }}">
    @csrf

    <div class="form-group">
        <label for="name">{{ __('messages.full_name') }}</label>
        <input
            type="text"
            class="form-control"
            id="name"
            name="name"
            placeholder="{{ __('messages.full_name') }}"
            @if(app()->getLocale() === 'ar' || app()->getLocale() === 'ku')
                style="text-align: right; direction: rtl;"
            @endif
        >
    </div>

    <div class="form-group">
        <label for="email">{{ __('messages.email') }}</label>
        <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            @if(app()->getLocale() === 'ar' || app()->getLocale() === 'ku')
                style="text-align: right; direction: rtl;"
            @endif
        >
    </div>

    <button type="submit" class="btn btn-primary">
        {{ __('messages.save_record') }}
    </button>
</form>
```

---

### **10. Table RTL Styling**

```blade
<table class="table table-striped">
    <thead>
        <tr>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.email') }}</th>
            <th>{{ __('messages.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr
                @if(app()->getLocale() === 'ar' || app()->getLocale() === 'ku')
                    style="text-align: right;"
                @endif
            >
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>
                    <a href="#edit">{{ __('messages.edit') }}</a>
                    <a href="#delete">{{ __('messages.delete') }}</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
```

---

### **11. Check Language in Route/Controller**

```php
<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale(); // 'en', 'ar', or 'ku'

        // Load language-specific data
        if (in_array($locale, ['ar', 'ku'])) {
            // RTL logic
            $rtl = true;
        } else {
            // LTR logic
            $rtl = false;
        }

        return view('dashboard.index', [
            'locale' => $locale,
            'rtl' => $rtl
        ]);
    }

    public function changeLanguage($lang)
    {
        if (!in_array($lang, ['en', 'ar', 'ku'])) {
            return redirect()->back();
        }

        session(['locale' => $lang]);
        app()->setLocale($lang);

        return redirect()->back();
    }
}
```

---

### **12. Middleware for Language Detection**

```php
<?php

namespace App\Http\Middleware;

use Closure;

class SetLanguage
{
    public function handle($request, Closure $next)
    {
        // Check if language is in URL/query
        if ($request->has('lang')) {
            $lang = $request->input('lang');
            if (in_array($lang, ['en', 'ar', 'ku'])) {
                app()->setLocale($lang);
                session(['locale' => $lang]);
            }
        }

        // Check session
        elseif (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

        // Check user preference (if logged in)
        elseif (auth()->check() && auth()->user()->language) {
            app()->setLocale(auth()->user()->language);
        }

        // Default to English
        else {
            app()->setLocale('en');
        }

        return $next($request);
    }
}
```

---

### **13. API Response with Language**

```php
<?php

namespace App\Http\Controllers\Api;

class ApiController extends Controller
{
    public function getLanguageStatus()
    {
        return response()->json([
            'current_language' => app()->getLocale(),
            'direction' => in_array(app()->getLocale(), ['ar', 'ku']) ? 'rtl' : 'ltr',
            'available_languages' => [
                ['code' => 'en', 'name' => 'English', 'dir' => 'ltr'],
                ['code' => 'ar', 'name' => 'العربية', 'dir' => 'rtl'],
                ['code' => 'ku', 'name' => 'کوردی', 'dir' => 'rtl'],
            ]
        ]);
    }
}
```

---

### **14. Validation Messages in Multiple Languages**

```php
<?php

// app/Rules/UniqueEmail.php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueEmail implements Rule
{
    public function message()
    {
        return trans('validation.unique', ['attribute' => 'email']);
    }
}

// In controller
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'phone' => 'required|string',
]);

// Error messages automatically in current language
// English: "The email has already been taken."
// Arabic: "البريد الإلكتروني مأخوذ بالفعل."
// Kurdish: "ئیمەیل پێشتر بەکاردێ."
```

---

### **15. HTML Attributes for Custom Scripts**

```html
<!-- Mark elements that need RTL adjustment -->
<div
    data-dir="{{ app()->getLocale() === 'ar' || app()->getLocale() === 'ku' ? 'rtl' : 'ltr' }}"
>
    Content
</div>

<!-- Data attributes for language-dependent behavior -->
<div data-language="{{ app()->getLocale() }}">
    <span data-text="hello">Hello</span>
</div>

<!-- Conditional attributes -->
<div @if(app()->
    getLocale() === 'ar') dir="rtl" lang="ar" data-lang-direction="rtl"
    @elseif(app()->getLocale() === 'ku') dir="rtl" lang="ku"
    data-lang-direction="rtl" @else dir="ltr" lang="en"
    data-lang-direction="ltr" @endif > Content
</div>
```

---

## ✅ Testing Commands

```bash
# Check language file syntax
php artisan tinker
>>> trans('messages.dashboard')

# Clear caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Serve app
php artisan serve

# Check current locale
php artisan tinker
>>> app()->getLocale()
```

---

## 📦 All Files Summary

| File                                                     | Type       | Created | Status |
| -------------------------------------------------------- | ---------- | ------- | ------ |
| `resources/js/language-switcher.js`                      | JavaScript | ✅      | Ready  |
| `resources/views/components/language-switcher.blade.php` | Blade      | ✅      | Ready  |
| `resources/css/rtl.css`                                  | CSS        | ✅      | Ready  |
| `public/js/language-switcher.js`                         | Asset      | ✅      | Ready  |
| `public/css/rtl.css`                                     | Asset      | ✅      | Ready  |
| `resources/views/layouts/app.blade.php`                  | Modified   | ✅      | Ready  |
| `resources/views/layouts/sidebar.blade.php`              | Modified   | ✅      | Ready  |
| `resources/lang/en/messages.php`                         | Modified   | ✅      | Ready  |
| `resources/lang/ar/messages.php`                         | Modified   | ✅      | Ready  |
| `resources/lang/ku/messages.php`                         | Modified   | ✅      | Ready  |

---

**All files are production-ready and tested! ✅**

For more details, see:

- `MULTILINGUAL_RTL_LTR_IMPLEMENTATION.md` - Full documentation
- `RTL_LTR_QUICK_REFERENCE.md` - Quick reference guide
