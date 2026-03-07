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

                                            <span class="font-semibold text-gray-600 text-lg break-words">
                                                <div class="flex items-center justify-center gap-3">
                                                    <img class="w-10 h-10 md:w-10 md:h-10 rounded-full shadow-md bg-white" src="{{ $palpites->user->avatar }}" onerror="this.onerror=null;this.src='/img/no-avatar.png';" title="{{ $palpites->user->name }}" alt="{{ $palpites->user->name }}">
                                                    <span>{{ $palpites->user->name }}</span>
                                                </div>
                                            </span>

                                            <span class="text-gray-600 text-lg text-center">
                                                <span class="font-medium">Palpite:</span>
                                                @if($palpites->home_team_goals === null || $palpites->away_team_goals === null)
                                                Não palpitou
                                                @else
                                                {{ $palpites->home_team_goals }} x {{ $palpites->away_team_goals }}
                                                @endif
                                                <span style="margin-left: 15px;" class="inline-flex items-center justify-center min-w-[40px] text-center px-2 py-1 text-xs font-semibold rounded-full bg-green-200">{{ $palpites->pontos }}</span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <!-- 💻 DESKTOP (Tabela Normal) -->
                                <tr class="hidden sm:table-row hover:bg-gray-100">
                                    <td class="px-6 py-3 break-words">
                                        <div class="flex items-center gap-3 text-gray-600 text-lg">
                                            <img class="w-10 h-10 md:w-10 md:h-10 rounded-full shadow-md bg-white" src="{{ $palpites->user->avatar }}" onerror="this.onerror=null;this.src='/img/no-avatar.png';" title="{{ $palpites->user->name }}" alt="{{ $palpites->user->name }}">
                                            <span>{{ $palpites->user->name }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-3 text-center font-medium text-gray-600 text-base">
                                        @if($palpites->home_team_goals === null || $palpites->away_team_goals === null)
                                        Não palpitou
                                        @else
                                        {{ $palpites->home_team_goals }} x {{ $palpites->away_team_goals }}
                                        @endif
                                    </td>

                                    <td class="px-6 py-3 text-center font-semibold text-gray-600 text-base">
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
                                        {{ __('#') }}
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


                                <tr @class(['bg-green-100'=> $posicao==1, 'bg-sky-100'=> $posicao==2, 'bg-yellow-100'=> $posicao==3, 'hover:bg-green-200'=> $posicao==1, 'hover:bg-sky-200'=> $posicao==2, 'hover:bg-yellow-200'=> $posicao==3 ] )>
                                    <td @class(['px-2 py-2 whitespace-nowrap text-sm md:text-base text-center font-medium text-gray-900 min-w-[5ch] sm:min-w-[10ch] lg:min-w-[15ch]'])>
                                        {{ $posicao }}º
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500 w-full max-w-[1px]">
                                        <div class="flex items-center gap-3 min-w-0 truncate">
                                            <img class="w-8 h-8 md:w-10 md:h-10 rounded-full shadow-md bg-white flex-shrink-0"
                                                src="{{ $user->avatar }}"
                                                onerror="this.onerror=null;this.src='/img/no-avatar.png';"
                                                title="{{ $user->name }}"
                                                alt="{{ $user->name }}">

                                            <span class="text-gray-800 text-sm md:text-base ">
                                                {{ $user->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm md:text-base text-center font-medium text-gray-700 min-w-[5ch] sm:min-w-[15ch] lg:min-w-[30ch]">
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