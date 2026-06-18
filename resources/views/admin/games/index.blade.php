<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Jogos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.games.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Novo Jogo') }}
                        </a>
                    </div>

                    <!-- Filtro por Fase -->
                    <form method="GET" action="{{ route('admin.games.index') }}" class="mb-6 flex items-center gap-4">
                        <label for="fase" class="font-medium text-gray-700">Filtrar por Fase:</label>
                        <select name="fase" id="fase" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" onchange="this.form.submit()">
                            <option value="">Todas as Fases</option>
                            @foreach($fases as $fase)
                            <option value="{{ $fase }}" {{ request('fase') == $fase ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $fase)) }}
                            </option>
                            @endforeach
                        </select>

                        <label for="status" class="font-medium text-gray-700 ml-4">Status:</label>
                        <select name="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" onchange="this.form.submit()">
                            <option value="" {{ request()->has('status') && request('status') == '' ? 'selected' : '' }}>Todos</option>
                            <option value="0" {{ !request()->has('status') || request('status') == '0' ? 'selected' : '' }}>Não Iniciados</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Finalizados</option>
                        </select>
                    </form>

                    <!-- Tabela de Jogos -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border" style="margin: 0 auto; width: 99%;">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fase</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data / Hora</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Mandante</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Placar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visitante</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ID Integração</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($games as $game)
                                <tr onclick="window.location='{{ route('admin.games.edit', $game->id) }}'" class="cursor-pointer hover:bg-gray-100 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left font-medium">
                                        {{ $game->fase  ?? 'Time ' . $game->fase }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left font-medium">
                                        {{ $game->group  ?? 'Time ' . $game->group }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($game->date)->format('d/m/Y') }} <br>
                                        <span class="text-xs">{{ \Carbon\Carbon::parse($game->hour)->format('H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">
                                        {{ $game->homeTeam->name ?? 'Time ' . $game->home_team_id }} <img src="{{ $game->homeTeam->bandeira }}" class="inline-block h-5 w-8 mr-2" alt="Bandeira"   onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';"/>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-bold bg-gray-50" style="font-size: 1rem;">
                                        {{ $game->home_team_goals ?? '-' }} x {{ $game->away_team_goals ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left font-medium">
                                        <img src="{{ $game->awayTeam->bandeira }}" class="inline-block h-5 w-8 mr-2" alt="Bandeira" onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';"/> {{ $game->awayTeam->name ?? 'Time ' . $game->away_team_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($game->status == 0)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Não Iniciada</span>
                                        @elseif($game->status == 1)
                                            @if(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $game->date . ' ' . $game->hour, 'America/Sao_Paulo')->isFuture())
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Em breve</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 animate-pulse">Em Andamento</span>
                                            @endif
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Finalizado</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-mono text-gray-600">
                                        {{ $game->api_id ?: '—' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Nenhum jogo encontrado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>