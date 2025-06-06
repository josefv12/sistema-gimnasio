<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// Descomenta la siguiente línea si usas una versión de Laravel anterior a la 9 (ej. Laravel 8)
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    // Para Laravel < 9, la línea de arriba sería:
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}