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