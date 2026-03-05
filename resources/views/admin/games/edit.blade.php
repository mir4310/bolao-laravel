<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Jogo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                        <div class="flex justify-center">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-6 text-center">
                        <h3 class="text-lg font-bold">Editar Partida</h3>
                    </div>

                    <form method="POST" action="{{ route('admin.games.update', $game->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Mandante e Gols -->
                            <div class="flex gap-4 items-end">
                                <div class="flex-grow">
                                    <x-input-label for="home_team_id" :value="__('Mandante')" />
                                    <select name="home_team_id" id="home_team_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ $game->home_team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-24">
                                    <x-input-label for="home_team_goals" :value="__('Gols')" />
                                    <x-text-input id="home_team_goals" name="home_team_goals" type="number" min="0" class="mt-1 block w-full text-center" :value="old('home_team_goals', $game->home_team_goals)" />
                                </div>
                            </div>

                            <!-- Visitante e Gols -->
                            <div class="flex gap-4 items-end">
                                <div class="flex-grow">
                                    <x-input-label for="away_team_id" :value="__('Visitante')" />
                                    <select name="away_team_id" id="away_team_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ $game->away_team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-24">
                                    <x-input-label for="away_team_goals" :value="__('Gols')" />
                                    <x-text-input id="away_team_goals" name="away_team_goals" type="number" min="0" class="mt-1 block w-full text-center" :value="old('away_team_goals', $game->away_team_goals)" />
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Grupo -->
                            <div>
                                <x-input-label for="group" :value="__('Grupo')" />
                                <x-text-input id="group" name="group" type="text" maxlength="1" class="mt-1 block w-full uppercase" :value="old('group', $game->group)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('group')" />
                            </div>

                            <!-- Fase -->
                            <div>
                                <x-input-label for="fase" :value="__('Fase')" />
                                <x-text-input id="fase" name="fase" type="text" class="mt-1 block w-full" :value="old('fase', $game->fase)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('fase')" />
                            </div>

                            <!-- Pontos -->
                            <div>
                                <x-input-label for="pontos" :value="__('Pontos')" />
                                <x-text-input id="pontos" name="pontos" type="text" class="mt-1 block w-full" :value="old('pontos', $game->pontos)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('pontos')" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status do Jogo')" />
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="0" {{ $game->status == 0 ? 'selected' : '' }}>Não Iniciado</option>
                                    <option value="1" {{ $game->status == 1 ? 'selected' : '' }}>Em Andamento</option>
                                    <option value="2" {{ $game->status == 2 ? 'selected' : '' }}>Finalizado</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Data -->
                            <div>
                                <x-input-label for="date" :value="__('Data')" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', $game->date)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date')" />
                            </div>

                            <!-- Hora -->
                            <div>
                                <x-input-label for="hour" :value="__('Hora')" />
                                <x-text-input id="hour" name="hour" type="time" class="mt-1 block w-full" :value="old('hour', $game->hour)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('hour')" />
                            </div>

                            <!-- Cidade -->
                            <div>
                                <x-input-label for="city" :value="__('Cidade')" />
                                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $game->city)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('city')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Salvar Alterações') }}</x-primary-button>
                                <a href="{{ route('admin.games.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Cancelar') }}</a>
                            </div>
                        </div>
                    </form>

                    <!-- Botão de Excluir -->
                    <form method="POST" action="{{ route('admin.games.destroy', $game->id) }}" class="mt-4 border-t pt-4">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-end">
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm" onclick="return confirm('Tem certeza que deseja excluir esta partida? Esta ação não pode ser desfeita.')">
                                {{ __('Excluir Partida') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>