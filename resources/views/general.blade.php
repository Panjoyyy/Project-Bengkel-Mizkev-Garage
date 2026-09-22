<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>{{ $title }}</title>
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #2d2d2d;
            --accent-color: #00a152;
            --accent-secondary: #00875a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.95) 0%, rgba(0, 200, 83, 0.85) 100%),
                        url('https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=2000') center/cover;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
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

        body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(0, 230, 118, 0.1);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
        }

        .navbar-brand {
            color: white !important;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: translateX(5px);
        }

        .navbar-brand img {
            border-radius: 50%;
            border: 3px solid rgba(0, 230, 118, 0.3);
            transition: all 0.3s ease;
        }

        .navbar-brand:hover img {
            border-color: var(--accent-color);
            transform: rotate(5deg) scale(1.05);
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 5;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-color), var(--accent-secondary));
        }

        .card-body {
            padding: 40px;
        }

        .card-body h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 2rem;
        }

        .card-body hr {
            border-color: var(--accent-color);
            opacity: 0.3;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 230, 118, 0.1);
            background: white;
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-secondary));
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 230, 118, 0.3);
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 230, 118, 0.5);
            background: linear-gradient(135deg, var(--accent-secondary), #00a152);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .text-danger {
            font-size: 0.85rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 25px;
            }
            
            .card-body h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar bg-body-tertiary">
            <a href="{{ auth()->check() ? route('create-order') : route('porto') }}" class="navbar-brand">
                
                <img src="{{ asset('img/logo.jpg') }}" width="65" height="65" class="rounded" alt="">
                <strong>Mizkev Garage</strong>
            </a>
        </nav>
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>