<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pemilihan Makanan Kucing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
        .form-control {
            border-radius: 15px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .cat-icon {
            color: #667eea;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        .welcome-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .role-card {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .role-card:hover {
            border-color: #667eea;
            transform: translateY(-2px);
        }
        .role-card.selected {
            border-color: #667eea;
            background-color: rgba(102, 126, 234, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-cat cat-icon" style="font-size: 4rem;"></i>
                        <h2 class="mt-3 mb-2 welcome-text fw-bold">Selamat Datang</h2>
                        <p class="text-muted">Sistem Pendukung Keputusan<br>Pemilihan Makanan Kucing Kitten</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-user-tag me-2"></i>Pilih Role Login
                            </label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="role-card p-3 h-100" onclick="selectRole('admin')">
                                        <div class="text-center">
                                            <i class="fas fa-user-shield text-primary" style="font-size: 2rem;"></i>
                                            <h6 class="mt-2 mb-2">Admin</h6>
                                            <small class="text-muted">
                                                Kelola sistem DSS
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="role-card p-3 h-100" onclick="selectRole('user')">
                                        <div class="text-center">
                                            <i class="fas fa-user text-success" style="font-size: 2rem;"></i>
                                            <h6 class="mt-2 mb-2">User</h6>
                                            <small class="text-muted">
                                                Lihat ranking makanan
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="role" id="role" value="{{ old('role') }}">
                            @error('role')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="Masukkan email Anda">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Masukkan password Anda">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Masuk
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-3">Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                Daftar di sini
                            </a>
                        </p>
                        
                        <div class="row text-center">
                            <div class="col">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Gunakan metode SMART untuk analisis terbaik
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <small class="text-white-50">
                        <i class="fas fa-shield-alt me-1"></i>
                        Sistem Keamanan Terjamin | © 2024 SPK SMART
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectRole(role) {
            // Remove selected class from all cards
            document.querySelectorAll('.role-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card  
            const clickedCard = event.target.closest('.role-card');
            clickedCard.classList.add('selected');
            
            // Set hidden input value
            document.getElementById('role').value = role;
            
            // Remove error styling if exists
            const errorDiv = document.querySelector('.text-danger.small');
            if (errorDiv) {
                errorDiv.style.display = 'none';
                // Hapus class error dari parent jika ada
                const parentDiv = errorDiv.closest('.mb-4');
                if (parentDiv) {
                    parentDiv.querySelectorAll('.role-card').forEach(card => {
                        card.style.borderColor = '';
                        card.style.animation = '';
                    });
                }
            }
        }

        // Set initial selection if old value exists (tapi tidak jika ada error role)
        window.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada error role
            const roleError = document.querySelector('.text-danger.small');
            const oldRole = document.getElementById('role').value;
            
            // Jika ada error role, reset selection dan clear value
            if (roleError) {
                document.getElementById('role').value = '';
                document.querySelectorAll('.role-card').forEach(card => {
                    card.classList.remove('selected');
                });
                return;
            }
            
            // Jika tidak ada error dan ada old value, set selection
            if (oldRole) {
                // Find and click the appropriate role card
                const targetCard = oldRole === 'admin' ? 
                    document.querySelector('.role-card:first-child') : 
                    document.querySelector('.role-card:last-child');
                if (targetCard) {
                    targetCard.classList.add('selected');
                }
            }
        });

        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const role = document.getElementById('role').value;
            if (!role) {
                e.preventDefault();
                alert('Silakan pilih role terlebih dahulu (Admin atau User)');
                
                // Add visual indicator
                const roleSection = document.querySelector('.mb-4');
                roleSection.scrollIntoView({ behavior: 'smooth' });
                
                // Highlight role cards
                document.querySelectorAll('.role-card').forEach(card => {
                    card.style.borderColor = '#dc3545';
                    card.style.animation = 'shake 0.5s';
                });
                
                return false;
            }
        });
    </script>
    
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>
</body>
</html> 