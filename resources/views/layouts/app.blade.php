<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' || app()->getLocale() === 'ku' ? 'rtl' : 'ltr' }}" data-lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>AccoSys - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- RTL/LTR Support -->
    <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">

    <style>
    * {
        box-sizing: border-box;
    }

    html[dir="rtl"] {
        direction: rtl;
    }

    html[dir="ltr"] {
        direction: ltr;
    }

    body {
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .sidebar {
        height: 100vh;
        background-color: #1e3a8a;
        color: white;
        position: fixed;
        width: 250px;
        top: 0;
        border-left: 4px solid transparent;
    }

    html[dir="ltr"] .sidebar {
        left: 0;
    }

    html[dir="rtl"] .sidebar {
        right: 0;
    }

    .sidebar a {
        color: #cfd8dc;
        text-decoration: none;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        border-left: 4px solid transparent;
        border-right: none;
        transition: all 0.3s ease;
    }

    html[dir="rtl"] .sidebar a {
        border-left: none;
        border-right: 4px solid transparent;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: #102a71;
        color: white;
    }

    html[dir="ltr"] .sidebar a:hover,
    html[dir="ltr"] .sidebar a.active {
        border-left-color: #3b82f6;
    }

    html[dir="rtl"] .sidebar a:hover,
    html[dir="rtl"] .sidebar a.active {
        border-right-color: #3b82f6;
    }

    .sidebar a i {
        margin-right: 12px;
        margin-left: 0;
    }

    html[dir="rtl"] .sidebar a i {
        margin-right: 0;
        margin-left: 12px;
    }

    .main-content {
        padding: 20px;
        min-height: 100vh;
    }

    html[dir="ltr"] .main-content {
        margin-left: 250px;
    }

    html[dir="rtl"] .main-content {
        margin-right: 250px;
    }

    .card-metric {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
    }

    .card-metric:hover {
        transform: translateY(-5px);
    }

    .icon-box {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 1.5rem;
    }

    /* METRIC CARD */
    .metric-card {
        border-radius: 14px;
        background: linear-gradient(135deg, #ffffff 0%, #f3f6ff 100%);
        transition: all 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
    }

    /* ICON BOX */
    .metric-icon {
        width: 65px;
        height: 65px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
    }

    /* Gradient */
    .bg-primary-gradient {
        background: linear-gradient(135deg, #3b82f6, #1e3a8a);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
    }

    .bg-income {
        background-color: #d1fae5;
        color: #059669;
    }

    .bg-outcome {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .bg-balance {
        background-color: #dbeafe;
        color: #2563eb;
    }

    .bg-pending {
        background-color: #fef3c7;
        color: #d97706;
    }

    /* Tables RTL/LTR */
    table {
        width: 100%;
    }

    html[dir="rtl"] table th,
    html[dir="rtl"] table td {
        text-align: right;
    }

    html[dir="ltr"] table th,
    html[dir="ltr"] table td {
        text-align: left;
    }

    /* Buttons and Forms */
    button, .btn {
        transition: all 0.2s ease;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"],
    input[type="date"],
    input[type="password"],
    textarea,
    select {
        border-radius: 6px;
        border: 1px solid #d1d5db;
    }

    html[dir="rtl"] input,
    html[dir="rtl"] textarea,
    html[dir="rtl"] select {
        text-align: right;
    }

    html[dir="ltr"] input,
    html[dir="ltr"] textarea,
    html[dir="ltr"] select {
        text-align: left;
    }

    /* Dropdown menus */
    .dropdown-menu {
        text-align: inherit;
    }

    /* Alert boxes */
    .alert {
        border-radius: 8px;
    }

    html[dir="rtl"] .alert {
        text-align: right;
    }

    html[dir="ltr"] .alert {
        text-align: left;
    }

    /* Flex utilities for RTL/LTR */
    .flex-start {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    html[dir="rtl"] .flex-start {
        flex-direction: row-reverse;
    }

    .flex-end {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    html[dir="rtl"] .flex-end {
        flex-direction: row-reverse;
    }

    /* List items */
    .nav-link {
        transition: all 0.2s ease;
    }

    html[dir="rtl"] .nav-link {
        text-align: right;
    }

    html[dir="ltr"] .nav-link {
        text-align: left;
    }

    /* Padding and margin utilities for RTL/LTR */
    html[dir="rtl"] .ps-3 { padding-left: 0; padding-right: 1rem; }
    html[dir="rtl"] .ps-2 { padding-left: 0; padding-right: 0.5rem; }
    html[dir="rtl"] .me-2 { margin-right: 0; margin-left: 0.5rem; }
    html[dir="rtl"] .me-3 { margin-right: 0; margin-left: 0.75rem; }
    html[dir="rtl"] .ms-10 { margin-right: 2.5rem; margin-left: 0; }
    html[dir="rtl"] .ms-6 { margin-right: 1.5rem; margin-left: 0; }
    html[dir="rtl"] .p-0 { padding: 0; }

    /* Icon positioning */
    .icon-start {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    html[dir="rtl"] .icon-start {
        flex-direction: row-reverse;
    }

    /* Badges and chips */
    .badge {
        border-radius: 12px;
    }

    /* Print styles */
    @media print {
        .sidebar,
        .language-switcher-container {
            display: none;
        }
        
        html[dir="ltr"] .main-content {
            margin-left: 0;
        }
        
        html[dir="rtl"] .main-content {
            margin-right: 0;
        }
    }
    </style>
    @yield('styles')
    @stack('styles')
</head>

<body>

    @include('layouts.sidebar')

    <div class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 600;">@yield('page-title', 'Dashboard')</h1>
            <x-language-switcher />
        </div>
        
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/language-switcher.js') }}"></script>
    <script>
    document.addEventListener('submit', function(event) {
        const form = event.target;

        if (!form.classList.contains('js-delete-form')) {
            return;
        }

        if (form.dataset.deleteConfirmed === 'true') {
            delete form.dataset.deleteConfirmed;
            return;
        }

        event.preventDefault();

        Swal.fire({
            title: form.dataset.confirmTitle || 'Are you sure?',
            text: form.dataset.confirmText || 'This record will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: form.dataset.confirmButton || 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.dataset.deleteConfirmed = 'true';
                form.submit();
            }
        });
    });
    </script>
    @stack('scripts')
</body>

</html>