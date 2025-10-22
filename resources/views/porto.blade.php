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

</head>
<body>
    <script>
    function animateCard(card) {
    card.classList.add('clicked');
    setTimeout(() => {
    card.classList.remove('clicked');
    }, 300); 
    }
    </script>

    <script>
    function animateCard(card) {
    card.style.transform = 'scale(1.05)';
    setTimeout(() => {
    card.style.transform = 'translateY(-8px) scale(1.03)';
    }, 200);
    }
</script>
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
            <a href="https://wa.me/6285790677021?text=Halo%20saya%20mau%20servis%20motor" class="btn btn-primary btn-lg">Booking Servis Sekarang</a>
        </div>
    </header>

    <!-- Bagian Sponsor -->
<section id="sponsor" class="bg-light py-4">
  <div class="container text-center mb-3">
    <h3 class="fw-bold mb-4">Didukung Oleh</h3>
  </div>
  <div class="slider">
    <div class="slide-track">
      <div class="slide"><img src="{{ asset('img/sponsor/Shell_logo.svg.png') }}" alt="Shell" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Honda_Logo.svg.png') }}" alt="Honda" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Yamaha_Logo.png') }}" alt="Yamaha" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Kawasaki_Logo.png') }}" alt="Kawasaki" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Suzuki_Logo.png') }}" alt="Suzuki" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Motul_Logo.png') }}" alt="Motul" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Michelin_Logo.png') }}" alt="Michelin" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Ipone_Logo.png') }}" alt="Ipone" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Prostreet_Logo.png') }}" alt="Prostreet" /></div>

      <div class="slide"><img src="{{ asset('img/sponsor/Shell_logo.svg.png') }}" alt="Shell" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Honda_Logo.svg.png') }}" alt="Honda" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Yamaha_Logo.png') }}" alt="Yamaha" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Kawasaki_Logo.png') }}" alt="Kawasaki" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Suzuki_Logo.png') }}" alt="Suzuki" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Motul_Logo.png') }}" alt="Motul" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Michelin_Logo.png') }}" alt="Michelin" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Ipone_Logo.png') }}" alt="Ipone" /></div>
      <div class="slide"><img src="{{ asset('img/sponsor/Prostreet_Logo.png') }}" alt="Prostreet" /></div>

    </div>
  </div>
</section>

   <!-- Bagian Layanan -->
<section id="layanan" class="section-padding bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold text-dark">Layanan Unggulan Kami</h2>
      <p class="text-muted">Kami menyediakan berbagai layanan untuk menjaga performa motor Anda tetap prima.</p>
    </div>

    <div class="row g-4">
      @foreach ($services as $item)
      <div class="col-md-4">
        <div class="card service-card border-0 shadow-lg" onclick="animateCard(this)">
          <div class="service-image position-relative">
            <img src="{{ asset('img/layanan/'.$item->foto_layanan) }}" 
                 class="w-100 rounded-top" alt="{{ $item->nama_layanan }}">
            <div class="overlay d-flex align-items-center justify-content-center">
              <span class="text-white fw-semibold">Lihat Detail</span>
            </div>
          </div>

          <div class="card-body bg-white p-4">
            <h4 class="fw-bold text-dark">{{ $item->nama_layanan }}</h4>
            <p class="text-muted mb-2"><i class="bi bi-geo-alt"></i> {{ $item->lokasi_layanan }}</p>
            <p class="text-secondary">{{ $item->deskripsi_layanan }}</p>
            <div class="text-end">
              <span class="fw-bold text-success fs-5">
                Rp {{ number_format($item->harga_layanan, 0, ',', '.') }}
              </span>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>


        <section id="mengapa-kami" class="section-padding bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <img src="https://unsplash.com/photos/KlOw94HiuGc/download?ixid=M3wxMjA3fDB8MXxzZWFyY2h8Nnx8bWVjaGFuaWMlMjBtb3RvcnxpZHwwfHx8fDE3NTk5NzYxMzd8MA&force=true" alt="Mekanik profesional" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0">
                        <h2 class="fw-bold">Kenapa Wajib Bengkel Motor Mizkev Garage?</h2>
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
                        <img src="https://unsplash.com/photos/dC1fBLsEUwY/download?ixid=M3wxMjA3fDB8MXxzZWFyY2h8N3x8a2F3YXNha2l8aWR8MHx8fHwxNzU5OTc2NTIwfDA&force=true" class="img-fluid rounded shadow-sm" alt="Motor 1">
                    </div>
                    <div class="col-md-4">
                        <img src="https://images.pexels.com/photos/1662556/pexels-photo-1662556.jpeg?cs=srgb&dl=pexels-wendywei-1662556.jpg&fm=jpg&_gl=1*fgwkw4*_ga*MjA5NjQ1OTg0LjE3NTk5NzcxMTY.*_ga_8JE65Q40S6*czE3NTk5NzcxMTUkbzEkZzEkdDE3NTk5NzcyMTEkajI1JGwwJGgw" class="img-fluid rounded shadow-sm" alt="Motor 2">
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
                        <p><i class="bi bi-geo-alt-fill me-2 text-danger"></i><a href="https://maps.app.goo.gl/M2W4rBk3dUeCht2L6?g_st=aw" target="_blank" class="text-decoration-none text-dark">Jl. Wuluh No.20, Nologaten, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</a></p>
                        <p><i class="bi bi-envelope-fill me-2 text-danger"></i><a href="mailto:servis.motorku@gmail.com" class="text-decoration-none text-dark">miskevgarage@gmail.com</a></p>
                        <p><i class="bi bi-whatsapp me-2 text-success"></i><a href="https://wa.me/6285790677021?text=Halo%20saya%20mau%20servis%20motor" target="_blank" class="text-decoration-none text-dark">0857-9067-7021</a></p>
                        <p><i class="bi bi-instagram me-2 text-danger"></i><a href="https://www.instagram.com/motorku_service" target="_blank" class="text-decoration-none text-dark">MiskevGarageOfficial</a></p>
                        <p><i class="bi bi-tiktok me-2 text-dark"></i><a href="https://www.tiktok.com/@motorku_service" target="_blank" class="text-decoration-none text-dark">OfficialMizkev</a></p>
                        <p><i class="bi bi-clock-fill me-2"></i><strong>Jam Buka:</strong> Senin - Sabtu, 08:00 - 17:00 WIB</p>
                    </div>
                <div class="col-lg-6">
                        <h4 class="fw-bold mb-3">Lokasi Kami</h4>
                    <div class="ratio ratio-16x9">
                        <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.152339976176!2d110.40742271532345!3d-7.796940493133932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a597c08cb88bd%3A0x2238e667e7052cea!2sMizkev%20Garage!5e0!3m2!1sid!2sid!4v1699499999999!5m2!1sid!2sid"
                        style="border:0;"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="rounded shadow">
                        </iframe>
                    </div>
                </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; 2025 Mizkev Garage. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>