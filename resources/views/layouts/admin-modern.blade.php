<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - Mizkev Garage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e3c72;
            --secondary-color: #2a5298;
            --accent-color: #3b82f6;
            --accent-secondary: #2563eb;
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --text-dark: #2c3e50;
            --text-light: #ecf0f1;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-collapsed);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 20px 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar:hover {
            width: var(--sidebar-width);
        }

        .sidebar .sidebar-title {
            opacity: 0;
            transition: opacity 0.3s ease;
            white-space: nowrap;
        }

        .sidebar:hover .sidebar-title {
            opacity: 1;
        }

        .sidebar .sidebar-link span {
            opacity: 0;
            transition: opacity 0.3s ease;
            white-space: nowrap;
        }

        .sidebar:hover .sidebar-link span {
            opacity: 1;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .sidebar-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--accent-color), var(--accent-secondary));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            animation: float-logo 3s ease-in-out infinite;
        }

        .sidebar-logo-img {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: float-logo 3s ease-in-out infinite;
            transition: all 0.3s ease;
        }

        .sidebar:hover .sidebar-logo-img {
            width: 60px;
            height: 60px;
            border-radius: 15px;
        }

        @keyframes float-logo {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .sidebar-logo:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .sidebar-title {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-title {
            opacity: 0;
            display: none;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 15px;
        }

        .sidebar-item {
            margin-bottom: 8px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.1), transparent);
            transition: width 0.3s ease;
        }

        .sidebar-link:hover::before {
            width: 100%;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .sidebar-link i {
            font-size: 1.3rem;
            margin-right: 15px;
            min-width: 25px;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover i {
            transform: scale(1.2);
        }

        .sidebar-link span {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-link span {
            opacity: 0;
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-collapsed);
            padding: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            width: calc(100% - var(--sidebar-collapsed));
        }

        .main-content.expanded {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
        }

        /* Top Bar */
        .top-bar {
            background: #1a2332;
            border-radius: 0;
            padding: 15px 30px;
            margin-bottom: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: relative;
            overflow: visible;
            z-index: 100;
        }

        .toggle-sidebar-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            width: 45px;
            height: 45px;
            border-radius: 12px;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .toggle-sidebar-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #fbbf24;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a2332;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: none;
            transition: all 0.3s ease;
            border: none;
        }

        .user-avatar:hover {
            transform: scale(1.05);
        }

        .user-avatar-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .user-avatar-img:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .user-dropdown-menu {
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            padding: 8px;
            min-width: 200px;
            margin-top: 8px;
            z-index: 1050;
            position: absolute;
        }

        .user-dropdown-menu .dropdown-item {
            border-radius: 8px;
            padding: 8px 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .user-dropdown-menu .dropdown-item:hover {
            background: #f3f4f6;
            transform: translateX(3px);
        }

        .user-dropdown-menu .dropdown-divider {
            margin: 6px 0;
            opacity: 0.1;
        }

        .user-details h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .user-details p {
            margin: 0;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Modal Fix - Ensure modals appear above everything */
        .modal {
            z-index: 9999 !important;
        }
        
        .modal-backdrop {
            z-index: 9998 !important;
        }
        
        .modal-backdrop.show {
            opacity: 0.5 !important;
            z-index: 9998 !important;
        }
        
        .modal-open {
            overflow: hidden !important;
        }
        
        .modal-dialog {
            z-index: 10000 !important;
            position: relative;
        }
        
        .modal-content {
            z-index: 10001 !important;
            position: relative;
        }

        .logout-btn {
            background: #dc2626;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background: #b91c1c;
        }

        /* Content Card */
        .content-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-color), var(--accent-secondary));
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: var(--accent-color);
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .btn-success-custom {
            background: linear-gradient(135deg, var(--success), #059669);
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, var(--warning), #d97706);
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-warning-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
        }

        .btn-danger-custom {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
        }

        /* Table Styles */
        .table-modern {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table-modern thead th {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-secondary));
            color: white;
            font-weight: 600;
            padding: 15px;
            border: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table-modern thead th:first-child {
            border-radius: 10px 0 0 10px;
        }

        .table-modern thead th:last-child {
            border-radius: 0 10px 10px 0;
        }

        .table-modern tbody tr {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .table-modern tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .table-modern tbody td {
            padding: 15px;
            border: none;
            vertical-align: middle;
        }

        .table-modern tbody td:first-child {
            border-radius: 10px 0 0 10px;
        }

        .table-modern tbody td:last-child {
            border-radius: 0 10px 10px 0;
        }

        /* Form Styles */
        .form-control-modern {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control-modern:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .form-label-modern {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-bar {
                flex-direction: column;
                gap: 15px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo Mizkev Garage" class="sidebar-logo-img">
            <h4 class="sidebar-title">Mizkev Garage</h4>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="{{ route('create-order') }}" class="sidebar-link {{ request()->is('create-order') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard Admin</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('management-layanan') }}" class="sidebar-link {{ request()->is('management-layanan*') || request()->is('*layanan*') ? 'active' : '' }}">
                    <i class="fas fa-cogs"></i>
                    <span>Kelola Layanan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('management-mechanic') }}" class="sidebar-link {{ request()->is('management-mechanic*') || request()->is('*mechanic*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Kelola Mekanik</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('motor.index') }}" class="sidebar-link {{ request()->is('management-motors*') || request()->is('*motors*') ? 'active' : '' }}">
                    <i class="fas fa-motorcycle"></i>
                    <span>Kelola Motor</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('management-customer') }}" class="sidebar-link {{ request()->is('management-customer*') || request()->is('*customer*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Kelola Customer</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('management-servis') }}" class="sidebar-link {{ request()->is('management-servis*') || request()->is('*servis*') ? 'active' : '' }}">
                    <i class="fas fa-wrench"></i>
                    <span>Kelola Servis</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('spareparts.index') }}" class="sidebar-link {{ request()->is('management-sparepart*') || request()->is('*sparepart*') ? 'active' : '' }}">
                    <i class="fas fa-tools"></i>
                    <span>Kelola Sparepart</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('transaksi.index') }}" class="sidebar-link {{ request()->is('management-transaction') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="user-info">
                <div class="dropdown">
                    <button class="btn d-flex align-items-center gap-3" id="userDropdown" style="background: transparent; border: none; padding: 0;" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        <img src="https://img.freepik.com/vektor-gratis/ilustrasi-pria-muda-tersenyum_1308-174669.jpg?semt=ais_hybrid&w=740&q=80" alt="Avatar" class="user-avatar-img">
                        <div class="user-details" style="text-align: left;">
                            <h5>{{ auth()->user()->username }}</h5>
                            <p>Administrator</p>
                        </div>
                        <i class="fas fa-chevron-down" style="color: white; font-size: 0.8rem; transition: transform 0.3s;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="userDropdown">
                        <li>
                            <div class="dropdown-item-text" style="padding: 8px 10px; background: #f8f9fa; border-radius: 8px; margin-bottom: 4px;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-user-circle" style="font-size: 1.5rem; color: #3b82f6;"></i>
                                    <div>
                                        <strong style="display: block; color: #1a2332; font-size: 0.85rem;">{{ auth()->user()->username }}</strong>
                                        <small class="text-muted" style="font-size: 0.7rem;">Administrator</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider" style="margin: 6px 0;"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" style="padding: 8px 10px;">
                                <i class="fas fa-sign-out-alt text-danger" style="font-size: 0.95rem;"></i>
                                <span style="font-weight: 500; font-size: 0.85rem;">Keluar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="fade-in-up">
            @yield('content')
        </div>
    </main>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header" style="border: none; padding: 30px 30px 0;">
                    <h5 class="modal-title" style="color: var(--text-dark); font-weight: 700;">
                        <i class="fas fa-exclamation-circle text-warning me-2"></i>Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 20px 30px;">
                    <p style="color: #6c757d; margin: 0;">Apakah Anda yakin ingin keluar dari sistem?</p>
                </div>
                <div class="modal-footer" style="border: none; padding: 0 30px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-danger-custom">
                            <i class="fas fa-sign-out-alt me-2"></i>Ya, Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 600,
            once: true
        });

        // Initialize Bootstrap Components
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });

            // Initialize all modals
            var modalElementList = [].slice.call(document.querySelectorAll('.modal'));
            var modalList = modalElementList.map(function (modalEl) {
                return new bootstrap.Modal(modalEl, {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });
            });

            // Fix modal backdrop issue
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var targetModal = document.querySelector(button.getAttribute('data-bs-target'));
                    if (targetModal) {
                        var modal = bootstrap.Modal.getInstance(targetModal) || new bootstrap.Modal(targetModal);
                        modal.show();
                    }
                });
            });

            // Handle modal events
            document.querySelectorAll('.modal').forEach(function(modalEl) {
                modalEl.addEventListener('shown.bs.modal', function () {
                    // Ensure backdrop is clickable and has correct z-index
                    var backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.style.zIndex = '9998';
                        backdrop.addEventListener('click', function() {
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                        });
                    }
                    // Ensure modal dialog is above backdrop
                    modalEl.style.zIndex = '9999';
                    var modalDialog = modalEl.querySelector('.modal-dialog');
                    if (modalDialog) {
                        modalDialog.style.zIndex = '10000';
                    }
                });

                modalEl.addEventListener('hidden.bs.modal', function () {
                    // Clean up any remaining backdrops
                    document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                        backdrop.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                });
            });

            // Rotate chevron on dropdown show/hide
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) {
                const chevron = userDropdown.querySelector('.fa-chevron-down');
                userDropdown.addEventListener('show.bs.dropdown', function () {
                    if (chevron) chevron.style.transform = 'rotate(180deg)';
                });
                userDropdown.addEventListener('hide.bs.dropdown', function () {
                    if (chevron) chevron.style.transform = 'rotate(0deg)';
                });
            }

            // Sidebar hover effect on main content
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (sidebar && mainContent) {
                sidebar.addEventListener('mouseenter', function() {
                    mainContent.classList.add('expanded');
                });
                
                sidebar.addEventListener('mouseleave', function() {
                    mainContent.classList.remove('expanded');
                });
            }
        });

        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        // Mobile Sidebar
        if (window.innerWidth <= 768) {
            const toggleBtn = document.querySelector('.toggle-sidebar-btn');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    document.getElementById('sidebar').classList.toggle('show');
                });
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
