<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<body">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="wrapper" style="height: 100vh;;">
        <aside id="sidebar" class="fixed-sidebar" style="height: 100vh">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <h5 class="text-light"><strong>MG</strong></h1>
                    </button>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-item {{ request()->is('create-order') ? 'sidebar-active' : '' }}">
                        <a href="{{ route('create-order') }}" class="sidebar-link">
                            <i class="bi bi-border-all"></i>
                            <span>Buat Pesanan</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('management-layanan') ? 'sidebar-active' : '' }}">
                        <a href="{{ route('management-layanan') }}" class="sidebar-link">
                            <i class="bi bi-gear-wide-connected"></i>
                            <span>Manajemen Kelola Layanan</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('management-mechanic') ? 'sidebar-active' : '' }}">
                        <a href="{{ route('management-mechanic') }}" class="sidebar-link">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Manajemen Kelola Mekanik</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('management-motors') ? 'sidebar-active' : '' }}">
                        <a href="{{ route('management-motors') }}" class="sidebar-link">
                            <i class="bi bi-bicycle"></i>
                            <span>Manajemen Kelola Motor</span>
                        </a>
                    </li>

                    </li>
                    <li class="sidebar-item {{ request()->is('customer') ? 'sidebar-active' : '' }}">
                    <a href="{{ route('management-customer') }}" class="sidebar-link">
                    <i class="bi bi-people"></i>
                    <span>Manajemen Kelola Customer</span>
                    </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('management-servis') ? 'sidebar-active' : '' }}">
                    <a href="{{ route('management-servis') }}" class="sidebar-link">
                    <i class="bi bi-wrench"></i>
                    <span>Manajemen Kelola Servis</span>
                    </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('management-spareparts') ? 'sidebar-active' : '' }}">
                    <a href="{{ route('spareparts.index') }}" class="sidebar-link">
                    <i class="bi bi-tools"></i>
                    <span>Manajemen Kelola Sparepart</span>
                    </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('transaction') ? 'sidebar-active' : '' }}">
                        <a href="{{ route('transaction') }}" class="sidebar-link">
                            <i class="bi bi-ui-checks"></i>
                            <span>Transaksi</span>
                        </a>

                    </li>
                </ul>
                
            </aside>
            
            <div class="container content p-3">
                <div class="row mb-4">
                    <div class="col-md-10">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('img/profile.png') }}" alt="Logo" class="rounded me-4" width="65" height="65" />
                            
                            <div class="mt-2">
                                <h5 style="font-weight: bold">{{ auth()->user()->username }}</h5>
                                <p>
                                    Admin
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 d-flex justify-content-start justify-content-lg-end align-items-center mb-4 mt-3 mb-lg-0 mt-lg-0">
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmLogout">Keluar</button>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <div class="modal fade" id="confirmLogout" tabindex="-1" aria-labelledby="confirmLogoutLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            Apakah anda yakin untuk keluar?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Keluar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
    </body>
    </html>