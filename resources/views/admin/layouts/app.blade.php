<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - ConnecTIK</title>
    <link rel="icon" href="{{ asset('images/rtik.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background: #f5f5f5;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #1976d2 0%, #2196f3 50%, #42a5f5 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: left 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(0,0,0,0.1);
            text-align: center;
        }

        .sidebar-header h5 {
            font-size: 14px;
            font-weight: 500;
            margin: 0;
            letter-spacing: 1px;
        }

        .profile-section {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .profile-avatar i {
            font-size: 35px;
            color: #1976d2;
        }

        .profile-email {
            font-size: 13px;
            opacity: 0.9;
            margin-top: 5px;
        }

        .sidebar-nav {
            padding: 10px 0;
        }

        .nav-section-title {
            padding: 20px 20px 10px;
            font-size: 11px;
            font-weight: 600;
            opacity: 0.7;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255,255,255,0.15);
            padding-left: 30px;
        }

        .sidebar-nav a i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .sidebar-nav a .badge {
            margin-left: auto;
            background: rgba(255,255,255,0.3);
            font-size: 10px;
        }

        /* Top Header */
        .top-header {
            position: fixed;
            left: 260px;
            top: 0;
            right: 0;
            height: 64px;
            background: linear-gradient(90deg, #1565c0 0%, #1976d2 50%, #2196f3 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: left 0.3s ease;
        }

        .top-header h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .hamburger-menu {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px 10px;
            margin-right: 15px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        .sidebar-overlay.active {
            display: block;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
            color: white;
            font-size: 20px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s;
        }

        .header-icon:hover {
            transform: scale(1.1);
        }

        .header-icon .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff5722;
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 64px;
            padding: 30px;
            min-height: calc(100vh - 64px);
            transition: margin-left 0.3s ease;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border: none;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 20px 25px;
        }

        .card-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 500;
            color: #212121;
        }

        .card-body {
            padding: 25px;
        }

        /* Buttons */
        .btn {
            border-radius: 4px;
            padding: 8px 16px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #1976d2;
            border-color: #1976d2;
        }

        .btn-primary:hover {
            background: #1565c0;
            border-color: #1565c0;
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.4);
        }

        .btn-success {
            background: #4caf50;
            border-color: #4caf50;
        }

        .btn-success:hover {
            background: #388e3c;
            border-color: #388e3c;
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
        }

        .btn-danger {
            background: #f44336;
            border-color: #f44336;
        }

        .btn-danger:hover {
            background: #d32f2f;
            border-color: #d32f2f;
            box-shadow: 0 4px 12px rgba(244, 67, 54, 0.4);
        }

        .btn-warning {
            background: #ff9800;
            border-color: #ff9800;
        }

        .btn-warning:hover {
            background: #f57c00;
            border-color: #f57c00;
            box-shadow: 0 4px 12px rgba(255, 152, 0, 0.4);
        }

        .btn-info {
            background: #00bcd4;
            border-color: #00bcd4;
        }

        .btn-info:hover {
            background: #0097a7;
            border-color: #0097a7;
            box-shadow: 0 4px 12px rgba(0, 188, 212, 0.4);
        }

        /* Table */
        .table {
            margin: 0;
        }

        .table thead th {
            border-bottom: 2px solid #e0e0e0;
            font-weight: 500;
            font-size: 13px;
            color: #757575;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 10px;
            background: #fafafa;
        }

        .table tbody td {
            padding: 15px 10px;
            vertical-align: middle;
            font-size: 14px;
            border-bottom: 1px solid #f5f5f5;
        }

        .table tbody tr:hover {
            background: #fafafa;
        }

        /* Forms */
        .form-label {
            font-weight: 500;
            font-size: 13px;
            color: #424242;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #1976d2;
            box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.15);
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }

        /* Alerts */
        .alert {
            border-radius: 4px;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: #9e9e9e;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                left: -260px;
                z-index: 1001;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .top-header {
                left: 0;
                padding: 0 15px;
            }

            .top-header h4 {
                font-size: 16px;
            }

            .hamburger-menu {
                display: block;
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }

            .card-header {
                padding: 15px;
            }

            .card-header h5 {
                font-size: 14px;
            }

            .card-body {
                padding: 15px;
            }

            .header-actions {
                gap: 10px;
            }

            .header-icon {
                font-size: 18px;
            }

            .table {
                font-size: 13px;
            }

            .table thead th,
            .table tbody td {
                padding: 10px 5px;
            }
        }

        @media (max-width: 576px) {
            .top-header h4 {
                font-size: 14px;
            }

            .header-actions {
                gap: 8px;
            }

            .header-icon {
                font-size: 16px;
            }

            .card-header h5 {
                font-size: 13px;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .table {
                font-size: 12px;
                min-width: 600px;
            }

            .profile-section {
                padding: 20px 15px;
            }

            .profile-avatar {
                width: 60px;
                height: 60px;
            }

            .profile-avatar i {
                font-size: 28px;
            }

            .sidebar-nav a {
                padding: 10px 15px;
                font-size: 13px;
            }

            .sidebar-nav a:hover,
            .sidebar-nav a.active {
                padding-left: 25px;
            }

            .nav-section-title {
                padding: 15px 15px 8px;
                font-size: 10px;
            }
        }

        @yield('styles')
    </style>
</head>
<body>
    @include('admin.layouts.sidebar')
    
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    @hasSection('header')
        @yield('header')
    @else
        @include('admin.layouts.header')
    @endif
    
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Mobile Sidebar Toggle
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const hamburgerMenu = document.getElementById('hamburgerMenu');

        if (hamburgerMenu) {
            hamburgerMenu.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }

        // Close sidebar when clicking a link on mobile
        const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                }
            });
        });

        // Auto dismiss alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
    @yield('scripts')
</body>
</html>
