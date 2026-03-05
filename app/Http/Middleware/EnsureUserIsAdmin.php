<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Verifica se o usuário é uma instância do Model User e se é admin
        if ($user instanceof User && $user->isAdmin()) {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado.');
    }
}