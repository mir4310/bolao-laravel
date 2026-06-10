<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // 1️⃣ Busca por nome ou email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->query('search').'%')
                  ->orWhere('email', 'like', '%'.$request->query('search').'%');
            });
        }

        // 2️⃣ Ordenação
        $sort = $request->query('sort', 'name');           // usando query()
        $direction = $request->query('direction', 'asc');  // usando query()

        if (in_array($sort, ['name', 'created_at', 'data_pagamento'])) {
            $query->orderBy($sort, $direction);
        }

        // 3️⃣ Quantidade de registros por página
        $allowedPerPage = [10, 25, 50, 100];
        $perPage = (int) $request->query('perPage', 25);
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 25;
        }

        // 4️⃣ Paginação
        $users = $query->paginate($perPage)->withQueryString();

        // 5️⃣ Retorna view
        return view('admin.users.index', compact('users'));
    }

    #public function create()
    #{
    #    return view('admin.users.create');
    #}

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'data_pagamento' => ['nullable', 'date'],
            'role' => ['nullable', 'string', 'in:administrador,usuario'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'data_pagamento' => $request->data_pagamento,
            // checkbox: envia 'administrador' se marcado, null se desmarcado
            'role' => $request->input('role') === 'administrador' ? 'administrador' : 'usuario',
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
