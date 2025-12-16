<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mizkev Garage - Solusi Terbaik Untuk Motor Anda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #2d2d2d;
            --accent-color: #00a152;
            --text-dark: #2c3e50;
            --text-light: #ecf0f1;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Navbar Styles */
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-custom.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .btn-login {
            background: white;
            color: var(--primary-color);
            padding: 8px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid white;
        }

        .btn-login:hover {
            background: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        /* Hero Section */
        .hero-section {
            margin-top: 76px;
            min-height: 90vh;
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.95) 0%, rgba(0, 200, 83, 0.85) 100%), 
                        url('https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=2000') center/cover;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(0, 230, 118, 0.1);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: float 6s ease-in-out infinite;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 152, 0, 0.1);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #00a152 0%, #00875a 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 230, 118, 0.4);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 230, 118, 0.6);
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
        }

        .features-section::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 230, 118, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float-bubble 8s ease-in-out infinite;
        }

        .features-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0, 200, 83, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: float-bubble 10s ease-in-out infinite reverse;
        }

        @keyframes float-bubble {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(30px, -30px) scale(1.1);
            }
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            text-align: center;
            position: relative;
            z-index: 1;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.05);
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            z-index: 1;
        }

        /* Shimmer Effect */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        .feature-card {
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            border-radius: 20px;
            padding: 35px;
            text-align: center;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            height: 100%;
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 230, 118, 0.1), transparent);
            transition: left 0.5s;
        }

        .feature-card:hover::before {
            left: 100%;
        }

        .feature-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 230, 118, 0.05) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.5s;
        }

        .feature-card:hover::after {
            opacity: 1;
        }

        .feature-card:hover {
            transform: translateY(-15px) rotateX(5deg) scale(1.02);
            box-shadow: 
                0 25px 50px rgba(0, 230, 118, 0.3),
                0 10px 20px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            background: linear-gradient(145deg, #ffffff, #f8f9ff);
            animation: shimmer 2s ease-in-out;
        }

        .feature-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #00a152 0%, #00875a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2.5rem;
            color: white;
            position: relative;
            box-shadow: 
                0 10px 30px rgba(0, 230, 118, 0.4),
                inset 0 -5px 10px rgba(0, 0, 0, 0.2),
                inset 0 5px 10px rgba(255, 255, 255, 0.3);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: float-icon 3s ease-in-out infinite;
        }

        @keyframes float-icon {
            0%, 100% {
                transform: translateY(0) rotateZ(0deg);
            }
            25% {
                transform: translateY(-10px) rotateZ(-5deg);
            }
            50% {
                transform: translateY(0) rotateZ(0deg);
            }
            75% {
                transform: translateY(-5px) rotateZ(5deg);
            }
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.15) rotateY(360deg);
            box-shadow: 
                0 15px 40px rgba(0, 230, 118, 0.6),
                inset 0 -5px 10px rgba(0, 0, 0, 0.3),
                inset 0 5px 10px rgba(255, 255, 255, 0.4);
        }

        .feature-icon::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .feature-card:hover .feature-icon::before {
            opacity: 1;
        }

        .feature-icon::after {
            content: '';
            position: absolute;
            width: 120%;
            height: 120%;
            border-radius: 50%;
            border: 2px solid rgba(0, 230, 118, 0.3);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse-ring 2s ease-out infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }

        .feature-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover .feature-title {
            color: var(--accent-color);
            transform: scale(1.05);
            text-shadow: 0 4px 8px rgba(0, 230, 118, 0.2);
        }

        .feature-description {
            color: #6c757d;
            line-height: 1.8;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-description {
            color: #495057;
            transform: translateZ(20px);
        }

        /* Services Section */
        .services-section {
            padding: 80px 0;
            background: white;
        }

        .service-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .service-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .service-body {
            padding: 25px;
        }

        .service-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .service-location {
            color: #6c757d;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .service-description {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .service-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #28a745;
            text-align: right;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 60px 0;
            color: white;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1e3b2aff 0%, #208355ff 100%);
            color: white;
            padding: 40px 0 20px;
        }

        .footer-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: white;
            padding-left: 5px;
        }

        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            color: var(--accent-color);
            transform: translateY(-3px);
        }

        /* Carousel Styles */
        .carousel-image {
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            height: 400px;
            object-fit: cover;
        }

        .carousel-fade .carousel-item {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .carousel-fade .carousel-item.active {
            opacity: 1;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 230, 118, 0.8);
            border-radius: 50%;
            padding: 20px;
        }

        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: rgba(0, 230, 118, 1);
        }

        .carousel-caption-custom {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(26, 26, 26, 0.9);
            padding: 10px 30px;
            border-radius: 25px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .carousel-caption-custom h5 {
            margin: 0;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .carousel-image {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('porto') }}">
                <img src="{{ asset('img/logo.jpg') }}" width="50" height="50" alt="Logo">
                <span>Mizkev Garage</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="background: white;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                    <li class="nav-item ms-3">
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 hero-content" data-aos="fade-right">
                    <h1 class="hero-title">Solusi Terbaik Untuk Motor Anda</h1>
                    <p class="hero-subtitle">
                        Mekanik profesional kami siap melayani servis, tune-up, dan perbaikan motor dengan cepat dan hasil memuaskan. Kepercayaan Anda adalah prioritas kami.
                    </p>
                    <a href="#layanan" class="btn btn-primary-custom">
                        <i class="fas fa-calendar-check"></i> Booking Servis Sekarang
                    </a>
                </div>
                <div class="col-lg-5" data-aos="fade-left">
                    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://images.unsplash.com/photo-1558981806-ec527fa84c39?q=80&w=800" class="d-block w-100 carousel-image" alt="Motor 1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?q=80&w=800" class="d-block w-100 carousel-image" alt="Motor 2">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1609630875171-b1321377ee65?q=80&w=800" class="d-block w-100 carousel-image" alt="Motor 3">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1449426468159-d96dbf08f19f?q=80&w=800" class="d-block w-100 carousel-image" alt="Motor 4">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-users"></i> 500+</div>
                        <div class="stat-label">Pelanggan Puas</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-wrench"></i> 1000+</div>
                        <div class="stat-label">Servis Selesai</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-tools"></i> 10+</div>
                        <div class="stat-label">Mekanik Ahli</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-star"></i> 4.9</div>
                        <div class="stat-label">Rating Pelanggan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="tentang">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Mengapa Memilih Kami?</h2>
            <p class="section-subtitle" data-aos="fade-up">Kami memberikan pelayanan terbaik dengan standar profesional</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3 class="feature-title">Mekanik Profesional</h3>
                        <p class="feature-description">Tim mekanik bersertifikat dengan pengalaman bertahun-tahun dalam menangani berbagai jenis motor.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="feature-title">Servis Cepat</h3>
                        <p class="feature-description">Proses servis yang efisien tanpa mengurangi kualitas, motor Anda siap dalam waktu singkat.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Garansi Terjamin</h3>
                        <p class="feature-description">Setiap pekerjaan dilengkapi dengan garansi untuk memberikan kepercayaan penuh kepada Anda.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h3 class="feature-title">Harga Terjangkau</h3>
                        <p class="feature-description">Tarif kompetitif dengan kualitas premium, tanpa biaya tersembunyi.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3 class="feature-title">Sparepart Original</h3>
                        <p class="feature-description">Menggunakan sparepart original dan berkualitas untuk hasil maksimal.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">Layanan 24/7</h3>
                        <p class="feature-description">Customer service siap membantu Anda kapan saja untuk konsultasi dan booking.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section" id="layanan">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Layanan Kami</h2>
            <p class="section-subtitle" data-aos="fade-up">Berbagai layanan servis motor untuk kebutuhan Anda</p>
            
            <div class="row g-4">
                @if($services->count() > 0)
                    @foreach ($services as $index => $item)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="service-card">
                            <img src="{{ asset('img/layanan/'.$item->foto_layanan) }}" alt="{{ $item->nama_layanan }}" class="service-image">
                            <div class="service-body">
                                <h3 class="service-title">{{ $item->nama_layanan }}</h3>
                                <div class="service-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $item->lokasi_layanan }}</span>
                                </div>
                                <p class="service-description">{{ $item->deskripsi_layanan }}</p>
                                <div class="service-price">
                                    Rp {{ number_format($item->harga_layanan, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-tools" style="font-size: 5rem; color: #ddd;"></i>
                        <p class="mt-3 text-muted">Layanan akan segera tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="stats-section" id="kontak">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="display-5 fw-bold mb-4">Hubungi Kami</h2>
                    <p class="lead mb-4">Siap melayani kebutuhan servis motor Anda. Hubungi kami sekarang!</p>
                    <div class="mb-3">
                        <i class="fas fa-phone me-2"></i> <strong>Telepon:</strong> +62 812-3456-7890
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-envelope me-2"></i> <strong>Email:</strong> info@mizkevgarage.com
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i> <strong>Alamat:</strong> Jl. Raya Motor No. 123, Jakarta
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div id="teamCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?q=80&w=800" class="d-block w-100 carousel-image" alt="Tim Mekanik 1">
                                <div class="carousel-caption-custom">
                                    <h5>Tim Mekanik Profesional</h5>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1487754180451-c456f719a1fc?q=80&w=800" class="d-block w-100 carousel-image" alt="Tim Mekanik 2">
                                <div class="carousel-caption-custom">
                                    <h5>Berpengalaman & Terlatih</h5>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?q=80&w=800" class="d-block w-100 carousel-image" alt="Workshop 1">
                                <div class="carousel-caption-custom">
                                    <h5>Fasilitas Modern</h5>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=800" class="d-block w-100 carousel-image" alt="Workshop 2">
                                <div class="carousel-caption-custom">
                                    <h5>Peralatan Lengkap</h5>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h4 class="footer-title">Mizkev Garage</h4>
                    <p>Solusi terbaik untuk perawatan dan perbaikan motor Anda. Kepercayaan dan kepuasan pelanggan adalah prioritas kami.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <h4 class="footer-title">Link Cepat</h4>
                    <a href="#beranda" class="footer-link">Beranda</a>
                    <a href="#layanan" class="footer-link">Layanan</a>
                    <a href="#tentang" class="footer-link">Tentang Kami</a>
                    <a href="#kontak" class="footer-link">Kontak</a>
                </div>
                <div class="col-lg-4 mb-4">
                    <h4 class="footer-title">Jam Operasional</h4>
                    <p>Senin - Jumat: 08:00 - 20:00</p>
                    <p>Sabtu: 08:00 - 18:00</p>
                    <p>Minggu: 09:00 - 15:00</p>
                </div>
            </div>
            <hr style="border-color: rgba(255, 255, 255, 0.2);">
            <div class="text-center py-3">
                <p class="mb-0">&copy; 2025 Mizkev Garage. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Initialize carousel with auto-play
        document.addEventListener('DOMContentLoaded', function() {
            // Hero Carousel
            const heroCarousel = document.querySelector('#heroCarousel');
            if (heroCarousel) {
                const carousel = new bootstrap.Carousel(heroCarousel, {
                    interval: 3000,
                    ride: 'carousel',
                    pause: 'hover',
                    wrap: true
                });
            }

            // Team Carousel
            const teamCarousel = document.querySelector('#teamCarousel');
            if (teamCarousel) {
                const carousel = new bootstrap.Carousel(teamCarousel, {
                    interval: 3000,
                    ride: 'carousel',
                    pause: 'hover',
                    wrap: true
                });
            }
        });
    </script>
</body>
</html>
