<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                        <p class="text-sm font-medium text-green-800 text-center">
                            {{ session('success') }}
                        </p>
                    </div>
                    @endif

                    @if (session('success_password'))
                    <div class="mb-6 rounded-md bg-amber-50 p-4 border border-amber-200">
                        <p class="text-sm font-semibold text-amber-800 text-center">
                            A senha do usuário foi redefinida com sucesso!<br/>
                            Nova Senha Gerada: <strong class="text-lg font-black font-mono select-all text-amber-950 bg-amber-100 px-2.5 py-1 rounded border border-amber-300 ml-1">{{ session('success_password') }}</strong>
                        </p>
                    </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Nome')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="data_pagamento" :value="__('Data do Pagamento')" />
                            <x-text-input id="data_pagamento" name="data_pagamento" type="date" class="mt-1 block w-full" :value="old('data_pagamento', optional($user->data_pagamento)->format('Y-m-d'))" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_pagamento')" />
                        </div>

                        {{-- Campo de Role / Admin --}}
                        <div class="flex items-start gap-3 p-4 rounded-lg border border-gray-200 bg-gray-50">
                            <div class="flex items-center h-5 mt-0.5">
                                <input id="role_admin" name="role" type="checkbox" value="administrador"
                                    {{ old('role', $user->role) === 'administrador' ? 'checked' : '' }}
                                    class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            </div>
                            <div>
                                <label for="role_admin" class="font-semibold text-sm text-gray-800 cursor-pointer">
                                    Administrador
                                </label>
                                <p class="text-xs text-gray-500 mt-0.5">Concede acesso total ao painel administrativo.</p>
                            </div>
                        </div>

                        {{-- Campo Ativo --}}
                        <div class="flex items-start gap-3 p-4 rounded-lg border border-gray-200 bg-gray-50">
                            <div class="flex items-center h-5 mt-0.5">
                                <input id="ativo" name="ativo" type="checkbox" value="1"
                                    {{ old('ativo', $user->ativo) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer">
                            </div>
                            <div>
                                <label for="ativo" class="font-semibold text-sm text-gray-800 cursor-pointer">
                                    Usuário Ativo
                                </label>
                                <p class="text-xs text-gray-500 mt-0.5">Desmarcar impede o acesso do usuário ao sistema sem excluí-lo.</p>
                            </div>
                        </div>
                        <!--div>
                            <x-input-label for="password" :value="__('Nova Senha (deixe em branco para manter)')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmar Nova Senha')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                        </div-->

                        <div class="flex items-center justify-between mt-6">
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Salvar Alterações') }}</x-primary-button>
                                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                            </div>
                        </div>
                    </form>

                    <!-- Seção de Ações Especiais / Redefinir Senha -->
                    <div class="mt-8 border-t pt-6">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Ações de Segurança</h4>
                        <div class="flex flex-wrap gap-4 items-center">
                            <form method="POST" action="{{ route('admin.users.reset-password', $user->id) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 focus:bg-amber-600 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Tem certeza que deseja redefinir a senha deste usuário? A nova senha gerada será exibida na tela após o processamento.')">
                                    {{ __('Redefinir Senha') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Formulário Oculto de Exclusão -->
                    @if(auth()->id() !== $user->id)


                    <!-- Botão de Excluir -->
                    <form method="POST" id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" class="mt-4 border-t pt-4">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-end">
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm" onclick="return confirm(`{{ __('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.') }}`)">
                                {{ __('Excluir Usuário') }}
                            </button>
                        </div>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>