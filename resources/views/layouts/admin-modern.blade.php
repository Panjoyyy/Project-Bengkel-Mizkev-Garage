<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - Mizkev Garage</title>

    {{-- ═══════════════════════════════════════════════════════════════
         EXTERNAL LIBRARIES
    ═══════════════════════════════════════════════════════════════ --}}
    {{-- Google Fonts: Inter (400, 500, 600, 700) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5.3.6 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome 6.4.0 (icon library utama) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- AOS — Animate On Scroll (hanya fade-up/fade-down, once: true) --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ════════════════════════════════════════════════════════════
           DESIGN TOKENS — Single source of truth
           Setiap nilai visual direferensikan dari sini.
           Jangan tambahkan warna hardcoded di luar blok ini.
        ════════════════════════════════════════════════════════════ */
        :root {
            /* ── Brand Colors ── */
            --color-primary:        #16a34a;
            --color-primary-hover:  #15803d;
            --color-primary-light:  #dcfce7;
            --color-primary-dark:   #166534;

            /* ── Background ── */
            --color-body-bg:        #f1f5f9;
            --color-surface:        #ffffff;
            --color-surface-hover:  #f8fafc;

            /* ── Sidebar & Topbar ── */
            --color-sidebar-bg:             #0f172a;
            --color-topbar-bg:              #1e293b;
            --color-sidebar-hover:          rgba(255, 255, 255, 0.07);
            --color-sidebar-active:         #16a34a;
            --color-sidebar-text:           rgba(255, 255, 255, 0.72);
            --color-sidebar-text-active:    #ffffff;
            --color-sidebar-group-label:    rgba(255, 255, 255, 0.35);
            --color-sidebar-divider:        rgba(255, 255, 255, 0.10);

            /* ── Text ── */
            --color-text-primary:   #0f172a;
            --color-text-secondary: #475569;
            --color-text-muted:     #94a3b8;
            --color-text-on-dark:   #f8fafc;

            /* ── Border ── */
            --color-border:         #e2e8f0;
            --color-border-strong:  #cbd5e1;

            /* ── Semantic — Status ── */
            --color-success:        #16a34a;
            --color-success-bg:     #dcfce7;
            --color-success-text:   #166534;
            --color-warning:        #d97706;
            --color-warning-bg:     #fef3c7;
            --color-warning-text:   #92400e;
            --color-danger:         #dc2626;
            --color-danger-bg:      #fee2e2;
            --color-danger-text:    #991b1b;
            --color-info:           #2563eb;
            --color-info-bg:        #dbeafe;
            --color-info-text:      #1e40af;
            --color-neutral-bg:     #f1f5f9;
            --color-neutral-text:   #475569;

            /* ── Typography ── */
            --font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            --font-mono:   'Courier New', 'Courier', monospace;

            /* ── Spacing ── */
            --space-1:   4px;
            --space-2:   8px;
            --space-3:   12px;
            --space-4:   16px;
            --space-5:   20px;
            --space-6:   24px;
            --space-8:   32px;
            --space-10:  40px;
            --space-12:  48px;

            /* ── Border Radius ── */
            --radius-xs:   4px;
            --radius-sm:   6px;
            --radius-md:   8px;
            --radius-lg:   12px;
            --radius-xl:   16px;
            --radius-full: 9999px;

            /* ── Shadow ── */
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.07), 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 24px rgba(0, 0, 0, 0.10);

            /* ── Layout Dimensions ── */
            --sidebar-width:     240px;
            --sidebar-collapsed: 60px;
            --topbar-height:     56px;

            /* ── Transitions (hanya state change, bukan dekorasi) ── */
            --transition-base:    background-color 0.15s ease-in-out;
            --transition-border:  border-color 0.15s ease-in-out;
            --transition-opacity: opacity 0.15s ease-in-out;
            --transition-width:   width 0.25s ease-in-out;
        }

        /* ════════════════════════════════════════════════════════════
           RESET & BASE
        ════════════════════════════════════════════════════════════ */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            font-size: 0.875rem;
            line-height: 1.6;
            color: var(--color-text-primary);
            background-color: var(--color-body-bg);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ════════════════════════════════════════════════════════════
           SIDEBAR
           Behavior: toggle-based (bukan hover-expand).
           State default: EXPANDED (sidebar-collapsed class = collapsed).
        ════════════════════════════════════════════════════════════ */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--color-sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: var(--transition-width);
        }

        /* State collapsed — hanya ikon yang terlihat */
        .sidebar.is-collapsed {
            width: var(--sidebar-collapsed);
        }

        /* ── Scrollable area dalam sidebar ── */
        .sidebar__inner {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: var(--space-3) 0;
        }

        .sidebar__inner::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar__inner::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar__inner::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-full);
        }

        /* ── Logo / Header Area ── */
        .sidebar__header {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-4) var(--space-4);
            min-height: var(--topbar-height);
            border-bottom: 1px solid var(--color-sidebar-divider);
            flex-shrink: 0;
            overflow: hidden;
        }

        .sidebar__logo {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            flex-shrink: 0;
        }

        .sidebar__brand {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--color-text-on-dark);
            white-space: nowrap;
            opacity: 1;
            transition: var(--transition-opacity);
        }

        .sidebar.is-collapsed .sidebar__brand {
            opacity: 0;
            pointer-events: none;
        }

        /* ── Group Label ── */
        .sidebar__group-label {
            font-size: 0.625rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--color-sidebar-group-label);
            padding: var(--space-4) var(--space-4) var(--space-1);
            white-space: nowrap;
            opacity: 1;
            transition: var(--transition-opacity);
        }

        .sidebar.is-collapsed .sidebar__group-label {
            opacity: 0;
            pointer-events: none;
        }

        /* ── Nav List ── */
        .sidebar__nav {
            list-style: none;
            padding: 0 var(--space-2);
            margin: 0;
        }

        .sidebar__item {
            margin-bottom: 2px;
        }

        /* ── Nav Link ── */
        .sidebar__link {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: 9px var(--space-3);
            border-radius: var(--radius-md);
            color: var(--color-sidebar-text);
            text-decoration: none;
            white-space: nowrap;
            transition: var(--transition-base), color 0.15s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        .sidebar__link:hover {
            background-color: var(--color-sidebar-hover);
            color: var(--color-sidebar-text-active);
        }

        .sidebar__link.active {
            background-color: var(--color-sidebar-active);
            color: var(--color-sidebar-text-active);
        }

        .sidebar__link-icon {
            font-size: 1.0rem;          /* 16px — spec: 18px di sidebar, 1rem mendekati */
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            line-height: 1;
        }

        .sidebar__link-label {
            font-size: 0.8125rem;
            font-weight: 500;
            opacity: 1;
            transition: var(--transition-opacity);
        }

        .sidebar.is-collapsed .sidebar__link-label {
            opacity: 0;
            pointer-events: none;
        }

        /* ── Sidebar Divider ── */
        .sidebar__divider {
            height: 1px;
            background-color: var(--color-sidebar-divider);
            margin: var(--space-2) var(--space-3);
        }

        /* ── Bottom Area (User + Logout) ── */
        .sidebar__footer {
            flex-shrink: 0;
            border-top: 1px solid var(--color-sidebar-divider);
            padding: var(--space-3) var(--space-2);
        }

        /* ════════════════════════════════════════════════════════════
           MAIN CONTENT
        ════════════════════════════════════════════════════════════ */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left var(--transition-width);
        }

        .main-content.is-sidebar-collapsed {
            margin-left: var(--sidebar-collapsed);
        }

        /* ════════════════════════════════════════════════════════════
           TOPBAR
        ════════════════════════════════════════════════════════════ */
        .topbar {
            height: var(--topbar-height);
            background-color: var(--color-topbar-bg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 var(--space-6);
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
        }

        /* ── Toggle button di topbar ── */
        .topbar__toggle {
            background: transparent;
            border: none;
            color: var(--color-text-on-dark);
            cursor: pointer;
            padding: var(--space-2);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            transition: var(--transition-base);
            font-size: 1rem;
        }

        .topbar__toggle:hover {
            background-color: rgba(255, 255, 255, 0.10);
        }

        /* ── User area di kanan ── */
        .topbar__user {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .topbar__avatar {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background-color: #334155;
            flex-shrink: 0;
        }

        .topbar__user-name {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--color-text-on-dark);
        }

        .topbar__user-role {
            font-size: 0.6875rem;
            color: var(--color-text-muted);
            line-height: 1;
        }

        .topbar__dropdown-btn {
            background: transparent;
            border: none;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius-md);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            transition: var(--transition-base);
        }

        .topbar__dropdown-btn:hover {
            background-color: rgba(255, 255, 255, 0.08);
        }

        .topbar__chevron {
            color: var(--color-text-muted);
            font-size: 0.7rem;
            transition: transform 0.2s ease-in-out;
        }

        .topbar__chevron.is-open {
            transform: rotate(180deg);
        }

        /* ── User Dropdown Menu ── */
        .user-dropdown-menu {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            padding: var(--space-2);
            min-width: 200px;
            margin-top: var(--space-2);
        }

        .user-dropdown-menu .dropdown-item {
            border-radius: var(--radius-sm);
            padding: var(--space-2) var(--space-3);
            font-size: 0.8125rem;
            color: var(--color-text-primary);
            display: flex;
            align-items: center;
            gap: var(--space-2);
            transition: var(--transition-base);
        }

        .user-dropdown-menu .dropdown-item:hover {
            background-color: var(--color-surface-hover);
        }

        .user-dropdown-menu .dropdown-divider {
            margin: var(--space-1) 0;
            border-color: var(--color-border);
        }

        /* ════════════════════════════════════════════════════════════
           PAGE CONTENT
           Padding di-set 0 karena seluruh child view sudah mengatur
           padding internalnya sendiri (style="padding: 30px").
           Ini menjaga backward compatibility dengan 13 child view.
        ════════════════════════════════════════════════════════════ */
        .page-content {
            flex: 1;
            padding: 0;
        }

        /* ════════════════════════════════════════════════════════════
           CARD — Default
        ════════════════════════════════════════════════════════════ */
        .card-default {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: var(--space-6);
            box-shadow: var(--shadow-sm);
        }

        /* Alias untuk kompatibilitas child view yang menggunakan .content-card */
        .content-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: var(--space-6);
            box-shadow: var(--shadow-sm);
            margin-bottom: var(--space-6);
        }

        /* ════════════════════════════════════════════════════════════
           BUTTONS
           Semua hover hanya mengubah background-color, tidak translateY.
           Tidak ada colored box-shadow.
        ════════════════════════════════════════════════════════════ */
        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background-color: var(--color-primary);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-md);
            padding: 8px var(--space-5);
            font-family: var(--font-family);
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-base);
        }

        .btn-primary-custom:hover {
            background-color: var(--color-primary-hover);
            color: #ffffff;
        }

        .btn-primary-custom:disabled,
        .btn-primary-custom.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Success — konfirmasi simpan data */
        .btn-success-custom {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background-color: var(--color-success);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-md);
            padding: 8px var(--space-5);
            font-family: var(--font-family);
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-base);
        }

        .btn-success-custom:hover {
            background-color: var(--color-primary-hover);
            color: #ffffff;
        }

        .btn-success-custom:disabled,
        .btn-success-custom.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Warning — aksi seperti "Tandai Selesai", "Bayar" */
        .btn-warning-custom {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background-color: var(--color-warning);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-md);
            padding: 8px var(--space-5);
            font-family: var(--font-family);
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-base);
        }

        .btn-warning-custom:hover {
            background-color: #b45309;
            color: #ffffff;
        }

        .btn-warning-custom:disabled,
        .btn-warning-custom.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Danger — hapus, logout */
        .btn-danger-custom {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background-color: var(--color-danger);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-md);
            padding: 8px var(--space-5);
            font-family: var(--font-family);
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-base);
        }

        .btn-danger-custom:hover {
            background-color: #b91c1c;
            color: #ffffff;
        }

        .btn-danger-custom:disabled,
        .btn-danger-custom.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Secondary — kembali, batal. Sebelumnya TIDAK TERDEFINISI (bug fix). */
        .btn-secondary-custom {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background-color: transparent;
            color: var(--color-text-primary);
            border: 1px solid var(--color-border-strong);
            border-radius: var(--radius-md);
            padding: 8px var(--space-5);
            font-family: var(--font-family);
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-base), var(--transition-border);
        }

        .btn-secondary-custom:hover {
            background-color: var(--color-surface-hover);
            color: var(--color-text-primary);
            border-color: var(--color-border-strong);
        }

        .btn-secondary-custom:disabled,
        .btn-secondary-custom.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Ghost — cetak, export */
        .btn-ghost-custom {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background-color: transparent;
            color: var(--color-primary);
            border: 1px solid var(--color-primary);
            border-radius: var(--radius-md);
            padding: 8px var(--space-5);
            font-family: var(--font-family);
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-base), var(--transition-border);
        }

        .btn-ghost-custom:hover {
            background-color: var(--color-primary-light);
            color: var(--color-primary-dark);
        }

        /* ════════════════════════════════════════════════════════════
           TABLE — .table-modern
           Ganti dari border-spacing (floating row) ke border-collapse.
           Header gelap, hover hanya background-color.
        ════════════════════════════════════════════════════════════ */
        .table-modern {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
        }

        .table-modern thead th {
            background-color: var(--color-sidebar-bg);
            color: var(--color-text-on-dark);
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            padding: 10px 16px;
            border: none;
            white-space: nowrap;
        }

        .table-modern thead th:first-child {
            border-radius: var(--radius-md) 0 0 0;
        }

        .table-modern thead th:last-child {
            border-radius: 0 var(--radius-md) 0 0;
        }

        .table-modern tbody tr {
            background-color: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            transition: var(--transition-base);
        }

        .table-modern tbody tr:last-child {
            border-bottom: none;
        }

        .table-modern tbody tr:hover {
            background-color: var(--color-surface-hover);
        }

        .table-modern tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            color: var(--color-text-primary);
        }

        .table-modern tfoot tr {
            background-color: #f8fafc;
            border-top: 2px solid var(--color-border);
        }

        .table-modern tfoot td {
            padding: 12px 16px;
            font-weight: 600;
            font-size: 0.8125rem;
        }

        /* Table wrapper — menambah border dan radius pada kontainer */
        .table-wrapper {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        /* ════════════════════════════════════════════════════════════
           FORM
        ════════════════════════════════════════════════════════════ */
        .form-control-modern {
            display: block;
            width: 100%;
            height: 36px;
            padding: 7px 12px;
            font-family: var(--font-family);
            font-size: 0.875rem;
            color: var(--color-text-primary);
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            transition: var(--transition-border), box-shadow 0.15s ease-in-out;
            appearance: none;
        }

        .form-control-modern:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12);
            outline: none;
            background-color: var(--color-surface);
        }

        .form-control-modern:disabled {
            background-color: #f8fafc;
            color: var(--color-text-muted);
            cursor: not-allowed;
        }

        .form-control-modern.is-invalid {
            border-color: var(--color-danger);
        }

        .form-control-modern.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.10);
        }

        .form-label-modern {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--color-text-secondary);
            margin-bottom: var(--space-1);
        }

        /* ════════════════════════════════════════════════════════════
           MODAL
        ════════════════════════════════════════════════════════════ */
        .modal {
            z-index: 9999 !important;
        }

        .modal-backdrop {
            z-index: 9998 !important;
        }

        .modal-backdrop.show {
            opacity: 0.5 !important;
        }

        .modal-open {
            overflow: hidden !important;
        }

        .modal-dialog {
            z-index: 10000 !important;
        }

        .modal-content {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
        }

        /* ════════════════════════════════════════════════════════════
           BADGE / STATUS
           border-radius: var(--radius-xs) = 4px — profesional, bukan pill
        ════════════════════════════════════════════════════════════ */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 3px 8px;
            border-radius: var(--radius-xs);
            font-size: 0.6875rem;
            font-weight: 600;
            white-space: nowrap;
            line-height: 1.4;
        }

        .badge-success {
            background-color: var(--color-success-bg);
            color: var(--color-success-text);
        }

        .badge-warning {
            background-color: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .badge-danger {
            background-color: var(--color-danger-bg);
            color: var(--color-danger-text);
        }

        .badge-info {
            background-color: var(--color-info-bg);
            color: var(--color-info-text);
        }

        .badge-neutral {
            background-color: var(--color-neutral-bg);
            color: var(--color-neutral-text);
        }

        /* ════════════════════════════════════════════════════════════
           ALERT (in-page flash message)
        ════════════════════════════════════════════════════════════ */
        .alert-custom {
            display: flex;
            align-items: flex-start;
            gap: var(--space-3);
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            margin-bottom: var(--space-5);
            border-left: 3px solid transparent;
        }

        .alert-custom-success {
            background-color: var(--color-success-bg);
            border-left-color: var(--color-success);
            color: var(--color-success-text);
        }

        .alert-custom-warning {
            background-color: var(--color-warning-bg);
            border-left-color: var(--color-warning);
            color: var(--color-warning-text);
        }

        .alert-custom-danger {
            background-color: var(--color-danger-bg);
            border-left-color: var(--color-danger);
            color: var(--color-danger-text);
        }

        .alert-custom-info {
            background-color: var(--color-info-bg);
            border-left-color: var(--color-info);
            color: var(--color-info-text);
        }

        /* ════════════════════════════════════════════════════════════
           PAGE HEADER (komponen untuk page header di child view)
        ════════════════════════════════════════════════════════════ */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: var(--space-4);
            margin-bottom: var(--space-6);
            flex-wrap: wrap;
        }

        .page-header__info {
            flex: 1;
            min-width: 0;
        }

        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            color: var(--color-text-muted);
            margin-bottom: var(--space-1);
            flex-wrap: wrap;
        }

        .breadcrumb-nav a {
            color: var(--color-text-muted);
            text-decoration: none;
            transition: color 0.15s ease-in-out;
        }

        .breadcrumb-nav a:hover {
            color: var(--color-primary);
        }

        .breadcrumb-nav .separator {
            opacity: 0.5;
        }

        .page-header__title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-text-primary);
            display: flex;
            align-items: center;
            gap: var(--space-2);
            margin: 0;
        }

        .page-header__title i {
            color: var(--color-primary);
            font-size: 1.1rem;
        }

        .page-header__desc {
            font-size: 0.8125rem;
            color: var(--color-text-secondary);
            margin: var(--space-1) 0 0 0;
        }

        .page-header__actions {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            flex-shrink: 0;
        }

        /* ════════════════════════════════════════════════════════════
           OVERLAY BACKDROP (Mobile sidebar)
        ════════════════════════════════════════════════════════════ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.is-visible {
            display: block;
        }

        /* ════════════════════════════════════════════════════════════
           PAGE TRANSITION — 1x saat load (dipertahankan)
        ════════════════════════════════════════════════════════════ */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.35s ease-out both;
        }

        /* ════════════════════════════════════════════════════════════
           FOCUS VISIBLE — Accessibility
        ════════════════════════════════════════════════════════════ */
        :focus-visible {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }

        /* ════════════════════════════════════════════════════════════
           RESPONSIVE
        ════════════════════════════════════════════════════════════ */

        /* Tablet: 768px – 1199px */
        @media (max-width: 1199px) {
            .sidebar {
                width: var(--sidebar-collapsed);
            }

            .sidebar.is-expanded {
                width: var(--sidebar-width);
            }

            .main-content {
                margin-left: var(--sidebar-collapsed);
            }

            .main-content.is-sidebar-expanded {
                margin-left: var(--sidebar-width);
            }
        }

        /* Mobile: < 768px */
        @media (max-width: 767px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
                transition: transform 0.25s ease-in-out;
                box-shadow: none;
            }

            .sidebar.is-open {
                transform: translateX(0);
                box-shadow: var(--shadow-lg);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .page-content {
                padding: var(--space-5);
            }

            .topbar {
                padding: 0 var(--space-4);
            }

            .page-header {
                flex-direction: column;
                gap: var(--space-3);
            }

            .page-header__actions {
                width: 100%;
            }

            .page-header__actions .btn-primary-custom,
            .page-header__actions .btn-success-custom {
                width: 100%;
                justify-content: center;
            }
        }

        /* ════════════════════════════════════════════════════════════
           PRINT STYLES — Disembunyikan saat cetak
        ════════════════════════════════════════════════════════════ */
        @media print {
            .sidebar,
            .topbar,
            .sidebar-overlay {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .page-content {
                padding: 0 !important;
            }

            body {
                background: white !important;
            }

            .card-default,
            .content-card {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- ═══════════════════════════════════════════════════════════════
         OVERLAY — Menutup sidebar saat mobile
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- ═══════════════════════════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════════════════════════ --}}
    <aside class="sidebar" id="sidebar">

        {{-- Logo + Brand --}}
        <div class="sidebar__header">
            <img src="{{ asset('img/logo.jpg') }}"
                 alt="Logo Mizkev Garage"
                 class="sidebar__logo">
            <span class="sidebar__brand">Mizkev Garage</span>
        </div>

        <div class="sidebar__inner">

            {{-- ── Group: UTAMA ── --}}
            <p class="sidebar__group-label">Utama</p>
            <ul class="sidebar__nav">
                <li class="sidebar__item">
                    <a href="{{ route('create-order') }}"
                       class="sidebar__link {{ request()->is('create-order') ? 'active' : '' }}"
                       title="Dashboard">
                        <i class="fas fa-gauge-high sidebar__link-icon"></i>
                        <span class="sidebar__link-label">Dashboard</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar__divider"></div>

            {{-- ── Group: SERVIS & TRANSAKSI ── --}}
            <p class="sidebar__group-label">Servis &amp; Transaksi</p>
            <ul class="sidebar__nav">
                <li class="sidebar__item">
                    <a href="{{ route('management-servis') }}"
                       class="sidebar__link {{ request()->is('management-servis*') || request()->is('servis*') ? 'active' : '' }}"
                       title="Kelola Servis">
                        <i class="fas fa-wrench sidebar__link-icon"></i>
                        <span class="sidebar__link-label">Kelola Servis</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="{{ route('transaksi.index') }}"
                       class="sidebar__link {{ request()->is('transaksi*') ? 'active' : '' }}"
                       title="Transaksi">
                        <i class="fas fa-receipt sidebar__link-icon"></i>
                        <span class="sidebar__link-label">Transaksi</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="{{ route('laporan-keuangan') }}"
                       class="sidebar__link {{ request()->is('laporan-keuangan*') ? 'active' : '' }}"
                       title="Laporan Keuangan">
                        <i class="fas fa-chart-line sidebar__link-icon"></i>
                        <span class="sidebar__link-label">Laporan Keuangan</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar__divider"></div>

            {{-- ── Group: DATA MASTER ── --}}
            <p class="sidebar__group-label">Data Master</p>
            <ul class="sidebar__nav">
                <li class="sidebar__item">
                    <a href="{{ route('management-customer') }}"
                       class="sidebar__link {{ request()->is('management-customer*') || request()->is('*customer*') ? 'active' : '' }}"
                       title="Kelola Customer">
                        <i class="fas fa-users sidebar__link-icon"></i>
                        <span class="sidebar__link-label">Customer</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="{{ route('motor.index') }}"
                       class="sidebar__link {{ request()->is('management-motors*') || request()->is('*motors*') ? 'active' : '' }}"
                       title="Kelola Motor">
                        <i class="fas fa-motorcycle sidebar__link-icon"></i>
                        <span class="sidebar__link-label">Motor</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="{{ route('spareparts.index') }}"
                       class="sidebar__link {{ request()->is('management-sparepart*') || request()->is('*sparepart*') ? 'active' : '' }}"
                       title="Kelola Sparepart">
                        <i class="fas fa-screwdriver-wrench sidebar__link-icon"></i>
                        <span class="sidebar__link-label">Sparepart</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="{{ route('management-layanan') }}"
                       class="sidebar__link {{ request()->is('management-layanan*') || request()->is('*layanan*') ? 'active' : '' }}"
                       title="Kelola Layanan">
                        <i class="fas fa-list-check sidebar__link-icon"></i>
                        <span class="sidebar__link-label">Layanan</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="{{ route('management-mechanic') }}"
                       class="sidebar__link {{ request()->is('management-mechanic*') || request()->is('*mechanic*') ? 'active' : '' }}"
                       title="Kelola Mekanik">
                        <i class="fas fa-user-cog sidebar__link-icon"></i>
                        <span class="sidebar__link-label">Mekanik</span>
                    </a>
                </li>
            </ul>

        </div>{{-- /.sidebar__inner --}}

        {{-- ── Footer: user + logout ── --}}
        <div class="sidebar__footer">
            <button type="button"
                    class="sidebar__link w-100 border-0"
                    data-bs-toggle="modal"
                    data-bs-target="#logoutModal"
                    title="Keluar"
                    style="text-align:left; background:transparent; cursor:pointer;">
                <i class="fas fa-sign-out-alt sidebar__link-icon" style="color: var(--color-danger-text);"></i>
                <span class="sidebar__link-label" style="color: var(--color-sidebar-text);">Keluar</span>
            </button>
        </div>

    </aside>{{-- /.sidebar --}}

    {{-- ═══════════════════════════════════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════════════════════════════════ --}}
    <main class="main-content" id="mainContent">

        {{-- TOPBAR --}}
        <header class="topbar" id="topbar">

            {{-- Toggle button — selalu terlihat --}}
            <button class="topbar__toggle" id="sidebarToggle" aria-label="Toggle sidebar" title="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>

            {{-- User area di kanan --}}
            <div class="topbar__user">
                <div class="dropdown">
                    <button class="topbar__dropdown-btn"
                            id="userDropdown"
                            type="button"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="true"
                            aria-expanded="false">
                        {{-- Avatar: initials fallback (tidak pakai URL eksternal) --}}
                        <div class="topbar__avatar d-flex align-items-center justify-content-center"
                             style="font-size: 0.75rem; font-weight: 700; color: var(--color-text-on-dark);">
                            {{ strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <div class="topbar__user-name">{{ auth()->user()->username ?? 'Admin' }}</div>
                            <div class="topbar__user-role">Administrator</div>
                        </div>
                        <i class="fas fa-chevron-down topbar__chevron" id="topbarChevron"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu"
                        aria-labelledby="userDropdown">
                        <li>
                            <div class="dropdown-item-text px-3 py-2"
                                 style="background: var(--color-neutral-bg); border-radius: var(--radius-sm); margin-bottom: var(--space-1);">
                                <div style="font-size: 0.8125rem; font-weight: 600; color: var(--color-text-primary);">
                                    {{ auth()->user()->username ?? 'Admin' }}
                                </div>
                                <div style="font-size: 0.6875rem; color: var(--color-text-muted);">Administrator</div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item"
                               href="#"
                               data-bs-toggle="modal"
                               data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt" style="color: var(--color-danger); width: 16px;"></i>
                                Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </header>{{-- /.topbar --}}

        {{-- PAGE CONTENT --}}
        <div class="page-content fade-in-up">
            @yield('content')
        </div>

    </main>{{-- /.main-content --}}

    {{-- ═══════════════════════════════════════════════════════════════
         LOGOUT MODAL
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content">
                <div class="modal-header border-0" style="padding: var(--space-6) var(--space-6) 0;">
                    <h5 class="modal-title" id="logoutModalLabel"
                        style="font-size: 1rem; font-weight: 700; color: var(--color-text-primary);">
                        <i class="fas fa-triangle-exclamation me-2" style="color: var(--color-warning);"></i>
                        Konfirmasi Keluar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="padding: var(--space-4) var(--space-6);">
                    <p style="color: var(--color-text-secondary); margin: 0; font-size: 0.875rem;">
                        Apakah Anda yakin ingin keluar dari sistem?
                    </p>
                </div>
                <div class="modal-footer border-0"
                     style="padding: 0 var(--space-6) var(--space-6); gap: var(--space-2);">
                    <button type="button"
                            class="btn-secondary-custom"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-danger-custom">
                            <i class="fas fa-sign-out-alt"></i>
                            Ya, Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         SCRIPTS
    ═══════════════════════════════════════════════════════════════ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // ── AOS: hanya fade-up/fade-down, satu kali saat load ──
        AOS.init({
            duration:  400,
            once:      true,
            easing:    'ease-out',
            offset:    40,
        });

        // ════════════════════════════════════════════════════════════
        // SIDEBAR TOGGLE — toggle-based, bukan hover-expand
        // ════════════════════════════════════════════════════════════
        (function () {
            const sidebar        = document.getElementById('sidebar');
            const mainContent    = document.getElementById('mainContent');
            const overlay        = document.getElementById('sidebarOverlay');
            const toggleBtn      = document.getElementById('sidebarToggle');
            const STORAGE_KEY    = 'mg_sidebar_collapsed';
            const MQ_MOBILE      = window.matchMedia('(max-width: 767px)');
            const MQ_TABLET      = window.matchMedia('(max-width: 1199px)');

            if (!sidebar || !mainContent || !toggleBtn) return;

            // ── Restore state dari localStorage (desktop/tablet) ──
            function restoreState() {
                if (MQ_MOBILE.matches) {
                    // Mobile: sidebar selalu tersembunyi saat load
                    sidebar.classList.remove('is-open', 'is-collapsed', 'is-expanded');
                    mainContent.classList.remove('is-sidebar-collapsed', 'is-sidebar-expanded');
                    overlay.classList.remove('is-visible');
                } else if (MQ_TABLET.matches) {
                    // Tablet: collapsed by default
                    sidebar.classList.remove('is-open', 'is-expanded');
                    sidebar.classList.add('is-collapsed');
                    mainContent.classList.remove('is-sidebar-expanded');
                    mainContent.classList.add('is-sidebar-collapsed');
                } else {
                    // Desktop: baca localStorage
                    const stored = localStorage.getItem(STORAGE_KEY);
                    if (stored === 'true') {
                        sidebar.classList.add('is-collapsed');
                        mainContent.classList.add('is-sidebar-collapsed');
                    } else {
                        sidebar.classList.remove('is-collapsed');
                        mainContent.classList.remove('is-sidebar-collapsed');
                    }
                }
            }

            restoreState();

            // ── Toggle handler ──
            toggleBtn.addEventListener('click', function () {
                if (MQ_MOBILE.matches) {
                    // Mobile: slide in/out dengan overlay
                    const isOpen = sidebar.classList.toggle('is-open');
                    overlay.classList.toggle('is-visible', isOpen);
                } else {
                    // Desktop / Tablet: toggle collapsed
                    const isCollapsed = sidebar.classList.toggle('is-collapsed');
                    mainContent.classList.toggle('is-sidebar-collapsed', isCollapsed);
                    // Simpan state ke localStorage (hanya desktop)
                    if (!MQ_TABLET.matches) {
                        localStorage.setItem(STORAGE_KEY, isCollapsed ? 'true' : 'false');
                    }
                }
            });

            // ── Tutup sidebar saat overlay diklik (mobile) ──
            overlay.addEventListener('click', function () {
                sidebar.classList.remove('is-open');
                overlay.classList.remove('is-visible');
            });

            // ── Reapply saat viewport resize ──
            window.addEventListener('resize', function () {
                restoreState();
            });
        }());

        // ════════════════════════════════════════════════════════════
        // BOOTSTRAP COMPONENTS INITIALIZATION
        // ════════════════════════════════════════════════════════════
        document.addEventListener('DOMContentLoaded', function () {

            // Dropdowns
            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function (el) {
                new bootstrap.Dropdown(el);
            });

            // Modals — inisialisasi semua modal dengan opsi standar
            document.querySelectorAll('.modal').forEach(function (modalEl) {
                // Keep modals outside animated/stacking-context wrappers so the backdrop cannot cover them.
                document.body.appendChild(modalEl);
                new bootstrap.Modal(modalEl, {
                    backdrop: true,
                    keyboard: true,
                    focus:    true,
                });
            });

            // Modal: trigger via data-bs-toggle tetap pakai Bootstrap native
            // Tambahan: pastikan backdrop dibersihkan setelah modal ditutup
            document.querySelectorAll('.modal').forEach(function (modalEl) {
                modalEl.addEventListener('hidden.bs.modal', function () {
                    document.querySelectorAll('.modal-backdrop').forEach(function (bd) {
                        bd.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow    = '';
                    document.body.style.paddingRight = '';
                });
            });

            // Topbar chevron rotation saat dropdown user dibuka/ditutup
            const userDropdownEl = document.getElementById('userDropdown');
            const chevronEl      = document.getElementById('topbarChevron');
            if (userDropdownEl && chevronEl) {
                userDropdownEl.addEventListener('show.bs.dropdown', function () {
                    chevronEl.classList.add('is-open');
                });
                userDropdownEl.addEventListener('hide.bs.dropdown', function () {
                    chevronEl.classList.remove('is-open');
                });
            }

        });
    </script>
    @stack('scripts')
</body>
</html>
