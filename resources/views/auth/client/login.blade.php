<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Clientes | Sistema Gimnasio</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #17a2b8;
            --primary-light: #138496;
            --accent: #ff6b35;
            --dark: #212529;
            --light: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-container {
            max-width: 420px;
            width: 100%;
            animation: fadeIn 0.6s ease-out;
        }
        
        .login-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .login-header {
            background-color: var(--primary);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 40px;
            background-color: white;
            clip-path: ellipse(75% 100% at 50% 0%);
        }
        
        .brand-logo {
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .brand-icon {
            font-size: 2rem;
            color: var(--primary);
        }
        
        .form-control {
            height: 50px;
            border-radius: 8px;
            padding-left: 45px;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(23, 162, 184, 0.25);
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            z-index: 4;
        }
        
        .btn-login {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            height: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 5;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 576px) {
            .login-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="login-container">
                    <div class="card login-card">
                        <div class="login-header">
                            <div class="brand-logo">
                                <i class="fas fa-user brand-icon"></i>
                            </div>
                            <h2 class="mb-1">Sistema Gimnasio</h2>
                            <p class="mb-0 opacity-75">Área de Clientes</p>
                        </div>
                        
                        <div class="card-body p-4 p-md-5">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('client.login') }}">
                                @csrf

                                <div class="mb-4 position-relative">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email" class="form-control ps-5" id="correo" name="correo" 
                                           value="{{ old('correo') }}" placeholder="Correo Electrónico" required autofocus>
                                </div>

                                <div class="mb-4 position-relative">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" class="form-control ps-5" id="password" name="password" 
                                           placeholder="Contraseña" required>
                                    <span class="password-toggle" onclick="togglePassword()">
                                        <i class="far fa-eye"></i>
                                    </span>
                                </div>

                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" 
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Recordar sesión</label>
                                </div>

                                <button type="submit" class="btn btn-login w-100 py-2 mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i> INICIAR SESIÓN
                                </button>

                                <div class="text-center">
                                    <p class="mb-0">¿No tienes cuenta? <a href="#" class="text-decoration-none">Regístrate aquí</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        
        // Efecto de carga
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.login-container').style.opacity = '1';
        });
    </script>
</body>

</html>