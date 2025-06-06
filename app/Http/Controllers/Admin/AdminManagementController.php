<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminManagementController extends Controller
{
    public function index()
    {
        // Lógica para obtener lista de administradores más adelante
        return view('admin.admins.index');
    }
}