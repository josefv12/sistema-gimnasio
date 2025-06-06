<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Entrenador</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-group.remember {
            display: flex;
            align-items: center;
        }

        .form-group.remember input[type="checkbox"] {
            width: auto;
            margin-right: 0.5rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-login:hover {
            background-color: #218838;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 0.75rem;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 1.2rem;
            list-style: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Login Entrenador</h1>

        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('trainer.login') }}">
            @csrf

            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input id="correo" type="email" name="correo" value="{{ old('correo') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="form-group remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Recordarme</label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-login">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</body>

</html>