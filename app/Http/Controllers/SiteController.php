<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function regulamento()
    {
        $participantes = User::whereNotNull('data_pagamento')->count();
        $valorBolao = 30;

        return view('regulamento', compact('participantes', 'valorBolao'));
    }
}
