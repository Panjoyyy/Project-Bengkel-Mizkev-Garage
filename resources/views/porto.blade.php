<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Layanan servis motor profesional dan terpercaya. Mekanik berpengalaman, suku cadang asli, dan harga terjangkau.">
    <meta name="keywords" content="bengkel motor, servis motor, tune up, ganti oli, modifikasi motor">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Link ke CSS lokal -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>Bengkel Motor Pro - Servis Cepat & Terpercaya</title>

<!--Navbar-->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Mizkev Garage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#hero">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mengapa-kami">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#galeri">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header id="hero" class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Solusi Terbaik Untuk Motor Anda</h1>
            <p class="lead my-4">Mekanik profesional kami siap melayani servis, tune-up, dan perbaikan motor dengan cepat dan hasil memuaskan.</p>
            <a href="#kontak" class="btn btn-primary btn-lg">Booking Servis Sekarang</a>
        </div>
    </header>

    <main>
        <section id="layanan" class="section-padding">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Layanan Unggulan Kami</h2>
                    <p class="text-muted">Kami menyediakan berbagai layanan untuk menjaga performa motor Anda.</p>
                </div>
                <div class="row text-center g-4">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                           <div class="card-body">
                                <i class="bi bi-tools service-icon mb-3"></i>
                                <h3 class="card-title h4">Servis Rutin & Tune Up</h3>
                                <p class="card-text">Pemeriksaan dan penyetelan komponen mesin untuk menjaga performa tetap optimal dan efisien.</p>
                           </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <i class="bi bi-oil-can service-icon mb-3"></i>
                                <h3 class="card-title h4">Ganti Oli Mesin</h3>
                                <p class="card-text">Menggunakan oli berkualitas sesuai rekomendasi pabrikan untuk melindungi mesin dari gesekan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <i class="bi bi-gear-wide-connected service-icon mb-3"></i>
                                <h3 class="card-title h4">Perbaikan & Suku Cadang</h3>
                                <p class="card-text">Menangani berbagai masalah kelistrikan, pengereman, hingga turun mesin dengan suku cadang asli.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="mengapa-kami" class="section-padding bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <img src="https://images.unsplash.com/photo-1599493356243-a4142a088195?q=80&w=1932&auto=format&fit=crop" alt="Mekanik profesional" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0">
                        <h2 class="fw-bold">Kenapa Bengkel Motor Pro?</h2>
                        <p class="text-muted mb-4">Kami bukan sekadar bengkel biasa. Kami adalah partner berkendara Anda.</p>
                        <div class="d-flex mb-3">
                            <i class="bi bi-check-circle-fill text-primary fs-4 me-3"></i>
                            <div>
                                <h5 class="fw-bold">Mekanik Berpengalaman</h5>
                                <p>Tim kami terdiri dari mekanik bersertifikat dengan pengalaman bertahun-tahun.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="bi bi-cash-coin text-primary fs-4 me-3"></i>
                            <div>
                                <h5 class="fw-bold">Harga Transparan</h5>
                                <p>Tidak ada biaya tersembunyi. Anda akan tahu estimasi biaya sebelum pengerjaan.</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-patch-check-fill text-primary fs-4 me-3"></i>
                            <div>
                                <h5 class="fw-bold">Suku Cadang Asli</h5>
                                <p>Kami hanya menggunakan suku cadang original dan berkualitas untuk menjamin keamanan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="galeri" class="section-padding">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Galeri Bengkel Kami</h2>
                    <p class="text-muted">Lihat beberapa hasil kerja dan suasana di bengkel kami.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <img src="https://images.unsplash.com/photo-1617083925822-6a4a2f8c0f5f?q=80&w=2070&auto=format&fit=crop" class="img-fluid rounded shadow-sm" alt="Motor 1">
                    </div>
                    <div class="col-md-4">
                        <img src="https://images.unsplash.com/photo-1629885382394-a1dedc73b063?q=80&w=2070&auto=format&fit=crop" class="img-fluid rounded shadow-sm" alt="Motor 2">
                    </div>
                    <div class="col-md-4">
                        <img src="https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=2070&auto=format&fit=crop" class="img-fluid rounded shadow-sm" alt="Motor 3">
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="section-padding bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Hubungi Kami</h2>
                    <p class="text-muted">Punya pertanyaan atau ingin booking servis? Jangan ragu hubungi kami.</p>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h4 class="fw-bold mb-3">Informasi Kontak</h4>
                        <p><i class="bi bi-geo-alt-fill me-2"></i>Jl. Otomotif Raya No. 123, Jakarta, Indonesia</p>
                        <p><i class="bi bi-telephone-fill me-2"></i>(021) 1234-5678</p>
                        <p><i class="bi bi-whatsapp me-2"></i><a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none text-dark">0812-3456-7890</a></p>
                        <p><i class="bi bi-clock-fill me-2"></i><strong>Jam Buka:</strong> Senin - Sabtu, 08:00 - 17:00 WIB</p>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3">Lokasi Kami</h4>
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.476711757803!2d106.8245840748119!3d-6.200805993786801!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1699343361113!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded shadow"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; 2025 Bengkel Motor Pro. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>