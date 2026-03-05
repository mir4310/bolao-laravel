<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Classificação') }}
        </h2>
    </x-slot>

    @foreach ($partidasEmAndamento as $partida)

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">

                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 text-sm">

                            <!-- HEADER -->
                            <thead class="bg-gray-50">
                                <tr>
                                    <th colspan="3" class="px-3 sm:px-6 py-4 text-center font-thin">

                                        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">

                                            <!-- Bandeira Casa -->
                                            <img src="{{ $partida->homeTeamBandeira }}"
                                                class="h-6 w-9 object-cover shadow-sm"
                                                alt="{{ $partida->homeTeam }}"
                                                title="{{ $partida->homeTeam }}"
                                                onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';" />

                                            <!-- Placar -->
                                            <div class="flex flex-col sm:flex-row items-center gap-2 text-center">

                                                <span class="font-medium">
                                                    {{ $partida->homeTeam }}
                                                </span>

                                                <div class="flex items-center gap-1 font-bold text-lg">
                                                    <span>{{ $partida->homeGoals }}</span>
                                                    <span>x</span>
                                                    <span>{{ $partida->awayGoals }}</span>
                                                </div>

                                                <span class="font-medium">
                                                    {{ $partida->awayTeam }}
                                                </span>

                                            </div>

                                            <!-- Bandeira Fora -->
                                            <img src="{{ $partida->awayTeamBandeira }}"
                                                class="h-6 w-9 object-cover shadow-sm"
                                                alt="{{ $partida->awayTeam }}"
                                                title="{{ $partida->awayTeam }}"
                                                onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';" />
                                        </div>

                                        <div class="mt-2 text-xs sm:text-sm italic text-gray-500">
                                            Partida em andamento
                                        </div>

                                    </th>
                                </tr>

                                <!-- Cabeçalho Desktop -->
                                <tr class="hidden sm:table-row">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Palpite
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pontos
                                    </th>
                                </tr>
                            </thead>

                            <!-- BODY -->
                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse($partida->palpites as $palpites)

                                <!-- 📱 MOBILE (Card) -->
                                <tr class="sm:hidden">
                                    <td colspan="3" class="px-4 py-4">
                                        <div class="flex flex-col gap-1">

                                            <span class="font-semibold text-gray-800 break-words">
                                                {{ $palpites->user->name }}
                                            </span>

                                            <span class="text-gray-600">
                                                <span class="font-medium">Palpite:</span>
                                                @if($palpites->home_team_goals === null || $palpites->away_team_goals === null)
                                                Não palpitou
                                                @else
                                                {{ $palpites->home_team_goals }} x {{ $palpites->away_team_goals }}
                                                @endif
                                            </span>

                                            <span class="text-gray-700 font-medium">
                                                Pontos: {{ $palpites->pontos }}
                                            </span>

                                        </div>
                                    </td>
                                </tr>

                                <!-- 💻 DESKTOP (Tabela Normal) -->
                                <tr class="hidden sm:table-row">
                                    <td class="px-6 py-3 text-gray-600 break-words">
                                        {{ $palpites->user->name }}
                                    </td>

                                    <td class="px-6 py-3 text-center font-medium text-gray-900">
                                        @if($palpites->home_team_goals === null || $palpites->away_team_goals === null)
                                        Não palpitou
                                        @else
                                        {{ $palpites->home_team_goals }} x {{ $palpites->away_team_goals }}
                                        @endif
                                    </td>

                                    <td class="px-6 py-3 text-center font-semibold text-gray-700">
                                        {{ $palpites->pontos }}
                                    </td>
                                </tr>

                                @empty

                                <tr>
                                    <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                                        Nenhum apostador encontrado ou os pontos ainda não foram calculados.
                                    </td>
                                </tr>

                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th colspan=3 scope="col" class="px-6 py-3 text-left text-lg font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('Classificação Geral') }}
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col" class="px-2 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Posição') }}
                                    </th>
                                    <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Nome') }}
                                    </th>
                                    <th scope="col" class="px-2 py-3 text-left text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Pontos') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $posicao = 0;
                                    $ultimaPontuacao = 0;
                                @endphp

                                @forelse($ranking as $index => $user)

                                @if($user->palpites_sum_pontos != $ultimaPontuacao)
                                    @php
                                    $posicao = $index+1;
                                    $ultimaPontuacao = $user->palpites_sum_pontos;
                                    @endphp
                                @endif
                                

                                <tr @class(['bg-green-100'=> $posicao==1, 'bg-sky-100'=> $posicao==2, 'bg-yellow-100'=> $posicao==3 ] )>
                                    <td  @class(['px-2 py-2 whitespace-nowrap text-sm text-center font-medium text-gray-900'])>
                                        {{ $posicao }}º
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-center font-medium text-gray-700">
                                        {{ $user->palpites_sum_pontos ?? 0 }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Nenhum apostador encontrado ou os pontos ainda não foram calculados.
                                    </td>
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