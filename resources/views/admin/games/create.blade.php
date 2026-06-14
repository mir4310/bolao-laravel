<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Novo Jogo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.games.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Mandante -->
                            <div>
                                <x-input-label for="home_team_id" :value="__('Mandante')" />
                                <select name="home_team_id" id="home_team_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ old('home_team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Visitante -->
                            <div>
                                <x-input-label for="away_team_id" :value="__('Visitante')" />
                                <select name="away_team_id" id="away_team_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ old('away_team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Grupo -->
                            <div>
                                <x-input-label for="group" :value="__('Grupo')" />
                                <x-text-input id="group" name="group" type="text" maxlength="1" class="mt-1 block w-full uppercase" :value="old('group')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('group')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Data -->
                            <div>
                                <x-input-label for="date" :value="__('Data')" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date')" />
                            </div>

                            <!-- Hora -->
                            <div>
                                <x-input-label for="hour" :value="__('Hora')" />
                                <x-text-input id="hour" name="hour" type="time" class="mt-1 block w-full" :value="old('hour')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('hour')" />
                            </div>

                            <!-- Cidade -->
                            <div>
                                <x-input-label for="city" :value="__('Cidade')" />
                                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('city')" />
                            </div>

                            <!-- Fase -->
                            <div>
                                <x-input-label for="fase" :value="__('Fase')" />
                                <x-text-input id="fase" name="fase" type="text" class="mt-1 block w-full" :value="old('fase', '1')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('fase')" />
                            </div>


                            <!-- Pontos -->
                            <div>
                                <x-input-label for="pontos" :value="__('Multiplicador de Pontos')" />
                                <x-text-input id="pontos" name="pontos" type="text" class="mt-1 block w-full" :value="old('pontos', '1')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('pontos')" />
                            </div>

                            <!-- ID Integração -->
                            <div>
                                <x-input-label for="api_id" :value="__('ID Integração')" />
                                <x-text-input id="api_id" name="api_id" type="text" maxlength="50" class="mt-1 block w-full" :value="old('api_id')" />
                                <x-input-error class="mt-2" :messages="$errors->get('api_id')" />
                            </div>
                        </div>

                        <!-- Status (Oculto, padrão 0) -->
                        <input type="hidden" name="status" value="0">

                        <div class="flex items-center gap-4 mt-4">
                            <x-primary-button>{{ __('Cadastrar Jogo') }}</x-primary-button>
                            <a href="{{ route('admin.games.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>