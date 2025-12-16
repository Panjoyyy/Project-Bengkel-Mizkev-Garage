<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - Mizkev Garage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.95) 0%, rgba(0, 200, 83, 0.85) 100%);
        }

        .login-container {
            display: flex;
            height: 100vh;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -50px;
            right: -50px;
        }

        .avatar-container {
            position: relative;
            z-index: 1;
            margin-bottom: 30px;
        }

        .avatar-circle {
            width: 180px;
            height: 180px;
            background: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 5px solid rgba(255, 255, 255, 0.3);
            animation: float 3s ease-in-out infinite;
            overflow: hidden;
            position: relative;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .left-panel h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .left-panel p {
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .right-panel {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: #00a152;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .close-btn:hover {
            background: #00875a;
            transform: rotate(90deg);
        }

        .login-form {
            width: 100%;
            max-width: 400px;
        }

        .login-form h3 {
            font-size: 36px;
            font-weight: 700;
            color: #333;
            margin-bottom: 40px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #00a152;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 230, 118, 0.1);
        }

        .form-group input.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #00a152 0%, #00875a 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 230, 118, 0.4);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 230, 118, 0.6);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: none;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .left-panel {
                padding: 30px;
            }

            .avatar-circle {
                width: 120px;
                height: 120px;
            }

            .avatar-circle img {
                width: 100%;
                height: 100%;
            }

            .left-panel h2 {
                font-size: 24px;
            }

            .right-panel {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Panel with Avatar -->
        <div class="left-panel">
            <div class="avatar-container">
                <div class="avatar-circle">
                    <img src="https://img.freepik.com/vektor-gratis/ilustrasi-pria-muda-tersenyum_1308-174669.jpg?semt=ais_hybrid&w=740&q=80" alt="Staff Avatar">
                </div>
            </div>
            <h2>Authentication Staff</h2>
            <p>Mizkev Garage Management System</p>
        </div>

        <!-- Right Panel with Form -->
        <div class="right-panel">
            <a href="{{ route('porto') }}" class="close-btn" title="Kembali ke Beranda">
                <i class="fas fa-times"></i>
            </a>

            <form method="POST" action="{{ route('handleLogin') }}" class="login-form">
                @csrf
                <h3>Sign In</h3>

                @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
                @endif

                <div class="form-group">
                    <label for="username">Username</label>
                    <input 
                        type="text" 
                        class="form-control @error('username') is-invalid @enderror" 
                        id="username"
                        name="username" 
                        placeholder="Masukkan username"
                        value="{{ old('username') }}"
                        autofocus
                    >
                    @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password"
                        name="password" 
                        placeholder="Masukkan password"
                    >
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
