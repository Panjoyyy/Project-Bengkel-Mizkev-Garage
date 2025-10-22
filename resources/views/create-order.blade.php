@extends('admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<div class="background-blur"></div>

<div class="container-fluid py-5 position-relative" style="z-index: 1;">
    <div class="welcome-card mx-auto col-lg-10 col-md-11 col-sm-12">
        <div class="garage-logo mb-4">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo Mizkev Garage">
        </div>

        <h1 class="welcome-title mb-3">Selamat Datang, Admin!</h1>
        <h4 class="text-dark mb-4">Sistem Bengkel <span class="text-danger">Mizkev Garage</span></h4>
        <p class="footer-text mt-5">
            © {{ date('Y') }} Mizkev Garage | Sistem Informasi Bengkel
        </p>
    </div>
</div>
@endsection
