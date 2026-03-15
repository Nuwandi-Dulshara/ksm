<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AccoSys - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    body {
        background-color: #f8f9fa;
    }

    .sidebar {
        height: 100vh;
        background-color: #1e3a8a;
        color: white;
        position: fixed;
        width: 250px;
    }

    .sidebar a {
        color: #cfd8dc;
        text-decoration: none;
        padding: 15px 20px;
        display: block;
        border-left: 4px solid transparent;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: #102a71;
        border-left-color: #3b82f6;
        color: white;
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
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
    </style>
    @yield('styles')
    @stack('styles')
</head>

<body>

    @include('layouts.sidebar')

    <div class="main-content">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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