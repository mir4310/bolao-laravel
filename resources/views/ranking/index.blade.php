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

                                        <div class="flex flex-row items-center justify-between gap-4 max-w-lg mx-auto">
                                            
                                            <!-- Mandante -->
                                            <div class="flex flex-col items-center flex-1 min-w-[72px]">
                                                <img src="{{ $partida->homeTeamBandeira }}"
                                                    class="h-6 w-9 object-cover mb-1 shadow-sm"
                                                    alt="{{ $partida->homeTeam }}"
                                                    title="{{ $partida->homeTeam }}"
                                                    onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';" />
                                                <span class="text-sm font-medium text-gray-800 leading-tight truncate max-w-[100px] sm:max-w-none">
                                                    {{ $partida->homeTeam }}
                                                </span>
                                            </div>

                                            <!-- Placar -->
                                            <div class="flex flex-col items-center justify-center shrink-0">
                                                <div class="flex items-center gap-2 font-bold text-lg text-gray-900 bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200">
                                                    <span>{{ $partida->homeGoals }}</span>
                                                    <span class="text-gray-400 text-xs">x</span>
                                                    <span>{{ $partida->awayGoals }}</span>
                                                </div>
                                            </div>

                                            <!-- Visitante -->
                                            <div class="flex flex-col items-center flex-1 min-w-[72px]">
                                                <img src="{{ $partida->awayTeamBandeira }}"
                                                    class="h-6 w-9 object-cover mb-1 shadow-sm"
                                                    alt="{{ $partida->awayTeam }}"
                                                    title="{{ $partida->awayTeam }}"
                                                    onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';" />
                                                <span class="text-sm font-medium text-gray-800 leading-tight truncate max-w-[100px] sm:max-w-none">
                                                    {{ $partida->awayTeam }}
                                                </span>
                                            </div>

                                        </div>

                                        <div class="mt-3 text-xs sm:text-sm italic text-gray-500">
                                            {{ \Carbon\Carbon::parse($partida->date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($partida->hour)->format('H:i') }} <br>
                                            <span class="font-semibold text-gray-600">{{ $partida->status }}</span>
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
                                <tr @class([
                                    'sm:hidden',
                                    'bg-zinc-200' => $palpites->user_id === auth()->id()
                                ])>
                                    <td colspan="3" class="px-3 py-3">
                                        <div class="flex flex-row items-center justify-between gap-2">
                                            
                                            <!-- Avatar e Nome -->
                                            <div class="flex items-center gap-2 min-w-0 flex-1">
                                                <img class="w-8 h-8 rounded-full shadow-sm bg-white shrink-0" src="{{ $palpites->user->avatar }}" onerror="this.onerror=null;this.src='/img/no-avatar.png';" title="{{ $palpites->user->name }}" alt="{{ $palpites->user->name }}">
                                                <span @class([
                                                    'text-sm truncate',
                                                    'font-bold text-gray-950' => $palpites->user_id === auth()->id(),
                                                    'font-normal text-gray-800' => $palpites->user_id !== auth()->id(),
                                                ])>
                                                    {{ $palpites->user->name }}
                                                </span>
                                            </div>

                                            <!-- Palpite -->
                                            <div @class([
                                                'text-center shrink-0 px-2 text-sm text-gray-600',
                                                'text-gray-950 font-bold' => $palpites->user_id === auth()->id(),
                                            ])>
                                                @if($palpites->home_team_goals === null || $palpites->away_team_goals === null)
                                                    <span title="Sem palpite">😢</span>
                                                @else
                                                    {{ $palpites->home_team_goals }} x {{ $palpites->away_team_goals }}
                                                @endif
                                            </div>

                                            <!-- Pontos -->
                                            <div class="shrink-0">
                                                <span class="inline-flex items-center justify-center min-w-[44px] text-center px-2 py-0.5 text-sm font-bold rounded-full bg-green-100 text-green-800 border border-green-300">
                                                    {{ $palpites->pontos }} pts
                                                </span>
                                            </div>

                                        </div>
                                    </td>
                                </tr>

                                <!-- 💻 DESKTOP (Tabela Normal) -->
                                <tr @class([
                                    'hidden sm:table-row hover:bg-gray-100',
                                    'bg-zinc-200' => $palpites->user_id === auth()->id(),
                                    'hover:bg-zinc-300' => $palpites->user_id === auth()->id()
                                ])>
                                    <td class="px-6 py-3 break-words">
                                        <div @class([
                                            'flex items-center gap-3 text-lg',
                                            'text-gray-950 font-bold' => $palpites->user_id === auth()->id(),
                                            'text-gray-600' => $palpites->user_id !== auth()->id()
                                        ])>
                                            <img class="w-10 h-10 md:w-10 md:h-10 rounded-full shadow-md bg-white" src="{{ $palpites->user->avatar }}" onerror="this.onerror=null;this.src='/img/no-avatar.png';" title="{{ $palpites->user->name }}" alt="{{ $palpites->user->name }}">
                                            <span>{{ $palpites->user->name }}</span>
                                        </div>
                                    </td>

                                    <td @class([
                                        'px-6 py-3 text-center text-base',
                                        'font-bold text-gray-950' => $palpites->user_id === auth()->id(),
                                        'font-medium text-gray-600' => $palpites->user_id !== auth()->id()
                                    ])>
                                        @if($palpites->home_team_goals === null || $palpites->away_team_goals === null)
                                        😢
                                        @else
                                        {{ $palpites->home_team_goals }} x {{ $palpites->away_team_goals }}
                                        @endif
                                    </td>

                                    <td @class([
                                        'px-6 py-3 text-center text-base',
                                        'font-bold text-gray-950' => $palpites->user_id === auth()->id(),
                                        'font-semibold text-gray-600' => $palpites->user_id !== auth()->id()
                                    ])>
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
                <div class="p-3 sm:p-6 text-gray-900">
                    <div>
                        <table class="w-full divide-y divide-gray-200">
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


                                <tr onclick="window.location='{{ route('ranking.user-palpites', $user->id) }}'" @class([
                                    'cursor-pointer transition-colors',
                                    'bg-green-100 hover:bg-green-200' => $posicao == 1,
                                    'bg-sky-100 hover:bg-sky-200' => $posicao == 2,
                                    'bg-yellow-100 hover:bg-yellow-200' => $posicao == 3,
                                    'bg-zinc-200 hover:bg-zinc-300' => $user->id === auth()->id() && $posicao > 3,
                                    'hover:bg-gray-100' => $user->id !== auth()->id() && $posicao > 3,
                                ])>
                                    <td @class([
                                        'px-2 py-2 whitespace-nowrap text-sm md:text-base text-center w-8',
                                        'font-bold text-gray-950' => $user->id === auth()->id(),
                                        'font-medium text-gray-900' => $user->id !== auth()->id()
                                    ])>
                                        {{ $posicao }}º
                                    </td>
                                    <td class="px-2 py-2 text-sm text-gray-500 w-full">
                                        <div class="flex items-center gap-3 min-w-0 truncate">
                                            <img class="w-8 h-8 md:w-10 md:h-10 rounded-full shadow-md bg-white flex-shrink-0"
                                                src="{{ $user->avatar }}"
                                                onerror="this.onerror=null;this.src='/img/no-avatar.png';"
                                                title="{{ $user->name }}"
                                                alt="{{ $user->name }}">

                                            <span @class([
                                                'text-sm md:text-base',
                                                'text-gray-950 font-bold' => $user->id === auth()->id(),
                                                'text-gray-800' => $user->id !== auth()->id()
                                            ])>
                                                {{ $user->name }}
                                            </span>
                                            @if(is_null($user->data_pagamento))
                                            <span title="Pagamento pendente" class="inline-flex items-center" alt="Pagamento pendente">⚠️</span>
                                            @else
                                            <span title="Pagamento confirmado" class="inline-flex items-center text-green-500" alt="Pagamento confirmado">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td @class([
                                        'px-2 py-2 whitespace-nowrap text-sm md:text-base text-center w-12',
                                        'font-bold text-gray-950' => $user->id === auth()->id(),
                                        'font-medium text-gray-700' => $user->id !== auth()->id()
                                    ])>
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
                            <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                                <tr>
                                    <td colspan="3" class="px-4 py-3">
                                        @php
                                            $total     = $ranking->count();
                                            $pagos     = $ranking->whereNotNull('data_pagamento')->count();
                                            $pendentes = $ranking->whereNull('data_pagamento')->count();
                                        @endphp
                                        <div class="flex flex-wrap items-center gap-3 text-xs font-semibold text-gray-500">
                                            <span>
                                                Total de participantes:
                                                <span class="text-gray-800 font-bold">{{ $total }}</span>
                                            </span>
                                            <span class="text-gray-300">|</span>
                                            <span class="inline-flex items-center gap-1 text-green-600">
                                                Confirmados: <span class="font-bold">{{ $pagos }}</span>
                                            </span>
                                            <span class="text-gray-300">|</span>
                                            <span class="inline-flex items-center gap-1 text-amber-600">
                                                Pendentes: <span class="font-bold">{{ $pendentes }}</span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($partidasEmAndamento) > 0)
    @php
        $hasActiveGame = collect($partidasEmAndamento)->contains(fn($p) => !$p->isFuture);
    @endphp
    <div id="countdown-badge" 
         onclick="window.location.reload();"
         title="Clique para atualizar agora"
         class="fixed bottom-4 right-4 bg-amber-50 text-amber-700 border border-amber-200 px-4 py-2.5 rounded-full text-xs font-semibold shadow-xl z-50 flex items-center gap-2 hover:bg-amber-100 hover:scale-105 active:scale-95 transition-all duration-200 cursor-pointer select-none @if($hasActiveGame) animate-pulse @endif">
        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
        <span>@if($hasActiveGame) Partida em andamento. @else Partida em breve. @endif<br/>Atualizando em <span id="countdown-timer" class="font-bold text-amber-900">60</span>s</span>
    </div>

    <script>
        let timeLeft = 60;
        const timerElement = document.getElementById('countdown-timer');
        
        const countdownInterval = setInterval(function() {
            timeLeft--;
            if (timerElement) {
                timerElement.textContent = timeLeft;
            }
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                window.location.reload();
            }
        }, 1000);
    </script>
    @endif
</x-app-layout>