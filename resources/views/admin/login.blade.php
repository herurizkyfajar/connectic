<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ConnecTIK</title>
    <link rel="icon" href="{{ asset('images/rtik.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #1565c0 0%, #1976d2 50%, #2196f3 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', 'Segoe UI', sans-serif;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }
        
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 520px;
            padding: 20px;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            padding: 2.5rem 2.25rem 2.25rem;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }
        
        .logo {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.1rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 20px rgba(25, 118, 210, 0.3);
        }
        
        .login-header h2 {
            color: #111827;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .login-header p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .login-tabs {
            margin-bottom: 1.5rem;
            border-radius: 999px;
            background-color: #f3f4f6;
            padding: 0.25rem;
        }
        
        .login-tabs .nav-link {
            border-radius: 999px;
            font-weight: 500;
            font-size: 0.9rem;
            color: #4b5563;
            padding: 0.5rem 1.1rem;
        }
        
        .login-tabs .nav-link.active {
            background-color: #111827;
            color: #f9fafb;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.35rem;
            font-size: 0.9rem;
        }
        
        .form-label i {
            color: #2563eb;
            margin-right: 8px;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
        }
        
        .form-control {
            padding: 11px 14px 11px 42px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.16rem rgba(37, 99, 235, 0.12);
            outline: none;
        }
        
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            z-index: 10;
            transition: color 0.2s ease;
        }
        
        .toggle-password:hover {
            color: #2563eb;
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
        }
        
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.45);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login-anggota {
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
            box-shadow: 0 8px 20px rgba(236, 72, 153, 0.35);
        }
        
        .btn-login-anggota:hover {
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.45);
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 1.25rem;
        }
        
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .back-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .back-link a:hover {
            color: #1d4ed8;
        }
        
        @media (max-width: 576px) {
            .login-card {
                padding: 2.1rem 1.5rem 1.8rem;
            }
            
            .logo {
                width: 60px;
                height: 60px;
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2>Masuk ke ConnecTIK</h2>
                <p>Pilih jenis akun untuk mengelola Sistem Manajemen RTIK</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Login gagal.</strong> Periksa kembali data akun Anda.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <ul class="nav nav-pills justify-content-between login-tabs" id="loginTab" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100 active" id="admin-tab-link" data-bs-toggle="tab" data-bs-target="#admin-tab" type="button" role="tab" aria-controls="admin-tab" aria-selected="true">
                        <i class="fas fa-shield-alt me-1"></i> Admin
                    </button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="anggota-tab-link" data-bs-toggle="tab" data-bs-target="#anggota-tab" type="button" role="tab" aria-controls="anggota-tab" aria-selected="false">
                        <i class="fas fa-users me-1"></i> Anggota
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="loginTabContent">
                <div class="tab-pane fade show active" id="admin-tab" role="tabpanel" aria-labelledby="admin-tab-link">
                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="username" class="form-label">
                                <i class="fas fa-user"></i>Username Admin
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       id="username" 
                                       name="username" 
                                       placeholder="Masukkan username admin"
                                       value="{{ old('username') }}" 
                                       required 
                                       autofocus>
                            </div>
                            @error('username')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i>Password
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password"
                                       required>
                                <span class="toggle-password" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-login mb-1">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Sebagai Admin
                        </button>
                    </form>
                </div>

                <div class="tab-pane fade" id="anggota-tab" role="tabpanel" aria-labelledby="anggota-tab-link">
                    <form method="POST" action="{{ route('anggota.login') }}" class="mt-2">
                        @csrf
                        
                        <div class="form-group">
                            <label for="anggota-username" class="form-label">
                                <i class="fas fa-user"></i>Username atau Email Anggota
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       id="anggota-username"
                                       name="username" 
                                       value="{{ old('username') }}" 
                                       placeholder="Email atau Nama Anggota"
                                       required>
                            </div>
                            @error('username')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="anggota-password" class="form-label">
                                <i class="fas fa-lock"></i>Password
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="anggota-password"
                                       name="password" 
                                       placeholder="Masukkan password anggota"
                                       required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn-login btn-login-anggota">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Sebagai Anggota
                        </button>
                    </form>
                </div>
            </div>

            <div class="back-link">
                <a href="{{ route('landing') }}">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
