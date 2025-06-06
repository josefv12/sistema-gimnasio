<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'), // El guard 'web' (para Clientes) es el predeterminado
        // Ahora que tenemos brokers específicos, podemos hacer que 'passwords'
        // apunte al broker más común o dejarlo para ser especificado en las rutas/controladores.
        // Por convención, lo dejaremos apuntando al que usa el guard 'web'.
        'passwords' => env('AUTH_PASSWORD_BROKER', 'clientes'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        'web' => [ // Para Clientes
            'driver' => 'session',
            'provider' => 'clientes',
        ],

        'admin' => [ // Para Administradores
            'driver' => 'session',
            'provider' => 'administradores',
        ],

        'trainer' => [ // Para Entrenadores
            'driver' => 'session',
            'provider' => 'entrenadores',
        ],

        // Guard para autenticación API basada en tokens (recomendado)
        'sanctum' => [
            'driver' => 'sanctum',
            'provider' => null, // Sanctum puede autenticar cualquier modelo Authenticatable
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        // El provider 'users' por defecto puede ser eliminado si no usas App\Models\User
        /*
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        */

        'administradores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Administrador::class,
        ],

        'entrenadores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Entrenador::class,
        ],

        'clientes' => [
            'driver' => 'eloquent',
            'model' => App\Models\Cliente::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Aquí defines la configuración para el reseteo de contraseñas para cada
    | tipo de usuario (provider). Dado que los emails son únicos globalmente,
    | todos pueden usar la misma 'table' para almacenar los tokens.
    |
    */
    'passwords' => [
        'clientes' => [
            'provider' => 'clientes', // Debe coincidir con un provider definido arriba
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'), // Tabla estándar de Laravel
            'expire' => 60, // Minutos de validez del token
            'throttle' => 60, // Segundos de espera entre intentos de generar un nuevo token
        ],

        'administradores' => [
            'provider' => 'administradores',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],

        'entrenadores' => [
            'provider' => 'entrenadores',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];