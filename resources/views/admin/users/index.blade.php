<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciar Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    <!--div class="flex justify-end mb-6">
                        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Novo Usuário') }}
                        </a>
                    </div-->

                    <form method="GET" class="flex flex-row sm:flex-cols justify-between items-center mb-4 w-full gap-2">
                        {{-- Pesquisa --}}
                        <div class="flex items-center w-3/4 md:w-1/2 gap-2">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Pesquisar usuário..."
                                class="border w-full border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">
                            <button type="submit" class="ml-2 px-3 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700 transition">
                                Buscar
                            </button>
                        </div>

                        {{-- Quantidade de registros por página --}}
                        <div class="flex items-center justify-end">
                            <label for="perPage" class="hidden md:inline text-sm text-gray-700 mr-2">Exibir:</label>
                            <select
                                name="perPage"
                                id="perPage"
                                onchange="this.form.submit()"
                                class="border border-gray-300 rounded-md text-sm px-3 py-2 w-[65px]">
                                @foreach([10,25,50,100] as $size)
                                <option value="{{ $size }}" {{ (request('perPage', 25) == $size) ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        <a href="{{ request()->fullUrlWithQuery([
                                                'sort' => 'name',
                                                'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                                            ]) }}">
                                            Nome
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Telefone') }}
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                        <a href="{{ request()->fullUrlWithQuery([
                                                'sort' => 'created_at',
                                                'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                                            ]) }}">
                                            Registrado Em
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Pagamento') }}
                                    </th>
''                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr onclick="window.location='{{ route('admin.users.edit', $user->id) }}'" class="hover:bg-gray-50 cursor-pointer transition">
                                    <td class="flex items-center px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <img class="w-8 h-8 mr-2 md:w-10 md:h-10 rounded-full shadow-md bg-white flex-shrink-0"
                                            src="{{ $user->avatar }}"
                                            onerror="this.onerror=null;this.src='/img/no-avatar.png';"
                                            title="{{ $user->name }}"
                                            alt="{{ $user->name }}">

                                        <div class="flex flex-col mr-2 text-left">
                                            <span class="text-base font-semibold text-gray-800 flex items-center gap-1.5">
                                                {{ $user->name }}
                                                @if($user->role === 'administrador')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">
                                                    Admin
                                                </span>
                                                @endif
                                            </span>
                                            <span class="text-sm text-gray-400">
                                                {{ $user->email }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                        {{ $user->telefone ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        @if($user->data_pagamento)
                                        <span title="{{ optional($user->data_pagamento)->format('d/m/Y') ?? '' }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ __('Pago')}}</span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ __('Em Aberto')}}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <div class="mt-6">
                            {{ $users->links('components.pagination.dashboard') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>