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
                        <style>
                            @media (min-width: 640px) {
                                .col-partida-nome {
                                    width: 60%;
                                }
                                .col-partida-palpite {
                                    width: 20%;
                                }
                                .col-partida-pontos {
                                    width: 20%;
                                }
                            }
                        </style>
                        <table class="w-full table-fixed divide-y divide-gray-200 text-sm">
                            <colgroup>
                                <col class="col-partida-nome">
                                <col class="col-partida-palpite">
                                <col class="col-partida-pontos">
                            </colgroup>
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
                                    <td colspan="3" class="px-3 py-2 overflow-hidden">
                                        <div class="flex items-center justify-between gap-2">

                                            <!-- Avatar + Nome + Palpite -->
                                            <div class="flex items-center gap-2 min-w-0 flex-1">
                                                <img class="w-9 h-9 rounded-full shadow-sm bg-white shrink-0" src="{{ $palpites->user->avatar }}" onerror="this.onerror=null;this.src='/img/no-avatar.png';" title="{{ $palpites->user->name }}" alt="{{ $palpites->user->name }}">
                                                <div class="min-w-0 flex-1">
                                                    <div @class([
                                                        'text-sm truncate leading-tight',
                                                        'font-bold text-gray-950' => $palpites->user_id === auth()->id(),
                                                        'font-normal text-gray-800' => $palpites->user_id !== auth()->id(),
                                                    ])>
                                                        {{ $palpites->user->name }}
                                                    </div>
                                                    <div @class([
                                                        'text-xs mt-0.5',
                                                        'font-bold text-gray-700' => $palpites->user_id === auth()->id(),
                                                        'text-gray-500' => $palpites->user_id !== auth()->id(),
                                                    ])>
                                                        @if($palpites->home_team_goals === null || $palpites->away_team_goals === null)
                                                            😢
                                                        @else
                                                            {{ $palpites->home_team_goals }} x {{ $palpites->away_team_goals }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pontos -->
                                            <div class="shrink-0 text-right">
                                                <div @class([
                                                    'text-sm',
                                                    'font-bold text-gray-950' => $palpites->user_id === auth()->id(),
                                                    'font-medium text-gray-600' => $palpites->user_id !== auth()->id(),
                                                ])>
                                                    {{ $palpites->pontos }} pts
                                                </div>
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
                        <style>
                            .col-posicao {
                                width: 70px;
                            }
                            .col-pontos {
                                width: 70px;
                            }
                            @media (min-width: 768px) {
                                .col-posicao {
                                    width: 150px;
                                }
                                .col-pontos {
                                    width: 150px;
                                }
                            }
                        </style>
                        <table style="table-layout:fixed;width:100%;" class="divide-y divide-gray-200">
                            <colgroup>
                                <col class="col-posicao">
                                <col>
                                <col class="col-pontos">
                            </colgroup>
                            <thead class="bg-gray-50">
                                <tr>
                                    <th colspan=3 scope="col" class="px-6 py-3 text-left text-lg font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('Classificação Geral') }}
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('#') }}
                                    </th>
                                    <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Nome') }}
                                    </th>
                                    <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
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

                                @php
                                    $chute = $chutesDeOuro->get($user->id);
                                    $totalComChute = ($user->palpites_sum_pontos ?? 0) + ($chute?->total_pontos ?? 0);
                                    $isMe = $user->id === auth()->id();
                                @endphp

                                <tr onclick="window.location='{{ route('ranking.user-palpites', $user->id) }}'" @class([
                                    'cursor-pointer transition-colors',
                                    'bg-green-100 hover:bg-green-200' => $posicao == 1,
                                    'bg-sky-100 hover:bg-sky-200' => $posicao == 2,
                                    'bg-yellow-100 hover:bg-yellow-200' => $posicao == 3,
                                    'bg-zinc-200 hover:bg-zinc-300' => $isMe && $posicao > 3,
                                    'hover:bg-gray-100' => !$isMe && $posicao > 3,
                                ])>
                                    <td @class([
                                        'px-1 py-2 whitespace-nowrap text-sm text-center align-top pt-3',
                                        'font-bold text-gray-950' => $isMe,
                                        'font-medium text-gray-900' => !$isMe
                                    ])>
                                        {{ $posicao }}º
                                    </td>
                                    <td style="max-width:0;overflow:hidden;" class="px-2 py-2 w-full">
                                        {{-- Nome + avatar --}}
                                        <div class="flex items-center gap-2" style="min-width:0;">
                                            <img class="w-8 h-8 md:w-10 md:h-10 rounded-full shadow-md bg-white flex-shrink-0"
                                                src="{{ $user->avatar }}"
                                                onerror="this.onerror=null;this.src='/img/no-avatar.png';"
                                                title="{{ $user->name }}"
                                                alt="{{ $user->name }}">

                                            <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;min-width:0;" @class([
                                                'text-sm md:text-base',
                                                'text-gray-950 font-bold' => $isMe,
                                                'text-gray-800' => !$isMe
                                            ])>
                                                {{ $user->name }}
                                            </span>
                                            @if(is_null($user->data_pagamento))
                                            <span title="Pagamento pendente" class="inline-flex items-center flex-shrink-0" alt="Pagamento pendente">⚠️</span>
                                            @else
                                            <span title="Pagamento confirmado" class="inline-flex items-center flex-shrink-0 text-green-500" alt="Pagamento confirmado">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </span>
                                            @endif
                                        </div>

                                        {{-- Chute de Ouro — visível apenas em tablet/desktop (md+) --}}
                                        @if($chute)
                                        <div class="hidden md:flex w-full justify-center items-center gap-10 mt-2 pt-2">
                                            @foreach([['team01','🏆','Campeã'],['team02','🥈','Vice'],['team03','⚽','Artilheiro']] as [$rel, $emoji, $label])
                                            @php $t = $chute->$rel; @endphp
                                            <div class="flex flex-col items-center gap-0.5 min-w-[60px]">
                                                <span class="text-xs text-gray-400 font-medium">{{ $emoji }}</span>
                                                @if($t)
                                                    <img src="{{ $t->bandeira }}" class="h-6 w-9 object-cover shadow-sm rounded-sm" alt="{{ $t->name }}" onerror="this.style.display='none'">
                                                    <span class="text-xs text-gray-500 text-center leading-tight">{{ $t->name }}</span>
                                                @else
                                                    <span class="text-sm text-gray-300">—</span>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </td>
                                    <td @class([
                                        'px-2 py-2 whitespace-nowrap text-sm md:text-base text-center align-top pt-3',
                                        'font-bold text-gray-950' => $isMe,
                                        'font-medium text-gray-700' => !$isMe
                                    ])>
                                        {{ $totalComChute }}
                                    </td>
                                </tr>

                                {{-- Linha mobile: Chute de Ouro (tablet/celular — abaixo do md) --}}
                                @if($chute)
                                <tr @class([
                                    'md:hidden cursor-pointer',
                                    'bg-green-100' => $posicao == 1,
                                    'bg-sky-100' => $posicao == 2,
                                    'bg-yellow-100' => $posicao == 3,
                                    'bg-zinc-200' => $isMe && $posicao > 3,
                                ]) onclick="window.location='{{ route('ranking.user-palpites', $user->id) }}'">
                                    <td colspan="3" class="pb-2 pt-0">
                                        <div class="flex items-center justify-center gap-2 pt-2 w-full px-2">
                                            @foreach([['team01','🏆'],['team02','🥈'],['team03','⚽']] as [$rel, $emoji])
                                            @php $t = $chute->$rel; @endphp
                                            <div class="flex items-center gap-1 flex-1 min-w-0">
                                                <span class="text-xs text-gray-400 shrink-0">{{ $emoji }}</span>
                                                @if($t)
                                                    <img src="{{ $t->bandeira }}" class="h-4 w-6 object-cover shadow-sm shrink-0" alt="{{ $t->name }}" onerror="this.style.display='none'">
                                                    <span class="text-xs text-gray-600 truncate min-w-0">{{ $t->name }}</span>
                                                @else
                                                    <span class="text-xs text-gray-400 italic shrink-0">—</span>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endif

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