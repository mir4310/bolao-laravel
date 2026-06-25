<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Palpites') }}
        </h2>
    </x-slot>

    <style>
        @media (max-width: 767px) {
            /* Chrome, Safari, Edge, Opera */
            input.no-spin-mobile::-webkit-outer-spin-button,
            input.no-spin-mobile::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            /* Firefox */
            input.no-spin-mobile[type=number] {
                -moz-appearance: textfield;
            }
        }
    </style>

    <!-- Toast AJAX Status Message -->
    <div id="ajax-status-message"
        class="fixed top-5 right-5 z-50 hidden max-w-sm px-4 py-3 rounded-lg shadow-lg text-white transition-all duration-300">
        <span id="ajax-status-text"></span>
    </div>

    {{-- ===== FAIXA DE PAGAMENTO PENDENTE ===== --}}
    @if(is_null(auth()->user()->data_pagamento))
    <div class="w-full bg-red-600 text-white px-4 py-3 flex items-start md:items-center gap-3 shadow-md" role="alert" style="justify-content: center;">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5 md:mt-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <p class="text-sm font-semibold leading-snug">
            <span>Pagamento pendente: Faça o PIX de <b>R$ 30,00</b> para confirmar a participação. Os pagamentos deverão ser realizados até o término da 1ª rodada da fase de grupos.</span><br>
            <span class="font-semibold tracking-wide">(14)99658-1771 — Cledemir Barduco Junior — NuBank.</span> 
            
        </p>
    </div>
    @endif
    {{-- ===== FIM FAIXA DE PAGAMENTO ===== --}}

    <div class="py-6 md:py-12">
        <div style="padding-bottom:10px;" class="max-w-7xl mx-auto md:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm md:rounded-lg">
                <div class="p-4 md:p-6 text-gray-900">

                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block md:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    {{-- ===== FILTROS ===== --}}
                    @php
                        $faseNomes = [
                            1 => 'Fase de Grupos',
                            2 => '1/16 Avos de Final',
                            3 => 'Oitavas de Final',
                            4 => 'Quartas de Final',
                            5 => 'Semifinal',
                            6 => 'Final',
                        ];
                        $fases  = $games->pluck('fase')->filter()->unique()->sort()->values();
                        $grupos = $games->pluck('group')->filter()->unique()->sort()->values();
                    @endphp

                    {{-- Botões: Filtros + Ocultar Encerrados + Chute de Ouro --}}
                    {{-- Mobile: linha 1 = Filtros + Ocultar (metade cada); linha 2 = Chute de Ouro (largura toda) --}}
                    {{-- Desktop: tudo em uma linha --}}
                    <div class="mb-4 flex flex-col md:flex-row md:flex-wrap md:items-center gap-3">

                        {{-- Linha 1 no mobile: Filtros + Ocultar encerrados --}}
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <button type="button" id="filters-toggle"
                                class="flex-none inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300
                                       bg-white text-gray-700 font-semibold text-sm shadow-sm
                                       hover:bg-gray-50 hover:border-gray-400 transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                <svg id="filters-chevron" class="w-4 h-4 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                                </svg>
                                Filtros
                                <span id="active-filters-badge"
                                    class="hidden ml-1 px-1.5 py-0.5 rounded-full text-xs font-bold bg-indigo-600 text-white leading-none">
                                    0
                                </span>
                            </button>

                            <!-- Toggle Ocultar/Exibir Finalizados -->
                            <label class="flex-1 min-w-0 overflow-hidden inline-flex items-center justify-center gap-2 cursor-pointer bg-white px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-700 font-semibold text-sm hover:bg-gray-50 transition-all duration-200">
                                <input type="checkbox" id="hide-finished-checkbox" class="sr-only peer" checked>
                                <div class="relative w-9 h-5 flex-shrink-0 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="select-none text-gray-600 truncate">Ocultar encerrados</span>
                            </label>
                        </div>

                        {{-- Linha 2 no mobile: Chute de Ouro (largura toda) --}}
                        <button type="button" id="chute-ouro-toggle"
                            class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-yellow-400
                                   bg-gradient-to-r from-yellow-400 to-amber-500 text-white font-semibold text-sm shadow-sm
                                   hover:from-yellow-500 hover:to-amber-600 transition-all duration-200
                                   focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <svg id="chute-ouro-chevron" class="w-4 h-4 text-white transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                            ⭐ Chute de Ouro
                            @if($chuteDeOuro && ($chuteDeOuro->chute01 || $chuteDeOuro->chute02 || $chuteDeOuro->chute03))
                            <span class="ml-1 w-2 h-2 rounded-full bg-white inline-block"></span>
                            @endif
                        </button>
                    </div>

                    {{-- Painel Colapsável --}}
                    <div id="filters-panel"
                         style="max-height: 0; overflow: hidden; transition: max-height 0.35s ease, opacity 0.25s ease; opacity: 0;">
                        <div class="pb-4 border-b border-gray-100 mb-5">

                            {{-- Filtro por Data --}}
                            <div class="mb-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Filtrar por Data</p>
                                <div class="flex flex-wrap gap-2" id="date-filter-buttons">
                                    <button type="button" data-date="all"
                                        class="date-filter-btn active px-3 py-1.5 rounded-full text-sm font-semibold border border-transparent
                                               bg-amber-500 text-white shadow-sm transition-all duration-200
                                               hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-400">
                                        📅 Todas as Datas
                                    </button>
                                    <button type="button" data-date="today_tomorrow"
                                        class="date-filter-btn px-3 py-1.5 rounded-full text-sm font-semibold border border-gray-300
                                               bg-white text-gray-600 shadow-sm transition-all duration-200
                                               hover:bg-amber-50 hover:border-amber-400 hover:text-amber-700
                                               focus:outline-none focus:ring-2 focus:ring-amber-400">
                                        🕐 Hoje e Amanhã
                                    </button>
                                    <button type="button" data-date="week"
                                        class="date-filter-btn px-3 py-1.5 rounded-full text-sm font-semibold border border-gray-300
                                               bg-white text-gray-600 shadow-sm transition-all duration-200
                                               hover:bg-amber-50 hover:border-amber-400 hover:text-amber-700
                                               focus:outline-none focus:ring-2 focus:ring-amber-400">
                                        📆 Próximos 7 Dias
                                    </button>
                                </div>
                            </div>

                            {{-- Filtro por Fase --}}
                            @if($fases->isNotEmpty())
                            <div class="mb-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Filtrar por Fase</p>
                                <div class="flex flex-wrap gap-2" id="fase-filter-buttons">
                                    <button type="button"
                                        data-fase="all"
                                        class="fase-filter-btn active px-3 py-1.5 rounded-full text-sm font-semibold border border-transparent
                                               bg-emerald-600 text-white shadow-sm transition-all duration-200
                                               hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        Todas as Fases
                                    </button>
                                    @foreach($fases as $fase)
                                    <button type="button"
                                        data-fase="{{ $fase }}"
                                        class="fase-filter-btn px-3 py-1.5 rounded-full text-sm font-semibold border border-gray-300
                                               bg-white text-gray-600 shadow-sm transition-all duration-200
                                               hover:bg-emerald-50 hover:border-emerald-400 hover:text-emerald-700
                                               focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                        {{ $faseNomes[$fase] ?? 'Fase '.$fase }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            {{-- Filtro por Grupo --}}
                            @if($grupos->isNotEmpty())
                            <div id="group-filter-wrapper">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Filtrar por Grupo</p>
                                <div class="flex flex-wrap gap-2" id="group-filter-buttons">
                                    <button type="button"
                                        data-filter="all"
                                        class="group-filter-btn active px-3 py-1.5 rounded-full text-sm font-semibold border border-transparent
                                               bg-indigo-600 text-white shadow-sm transition-all duration-200
                                               hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                        Todos
                                    </button>
                                    @foreach($grupos as $grupo)
                                    <button type="button"
                                        data-filter="{{ $grupo }}"
                                        class="group-filter-btn px-3 py-1.5 rounded-full text-sm font-semibold border border-gray-300
                                               bg-white text-gray-600 shadow-sm transition-all duration-200
                                               hover:bg-indigo-50 hover:border-indigo-400 hover:text-indigo-700
                                               focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                        Grupo {{ $grupo }}
                                    </button>
                                    @endforeach
                                </div>
                                <p id="group-filter-label" class="mt-2 text-xs text-gray-400 hidden">
                                    Exibindo: <span id="group-filter-label-text" class="font-semibold text-indigo-600"></span>
                                    &mdash; <button type="button" id="group-filter-clear" class="underline text-gray-400 hover:text-gray-600">ver todos</button>
                                </p>
                            </div>
                            @endif

                        </div>
                    </div>
                    {{-- ===== FIM FILTROS ===== --}}

                    {{-- ===== PAINEL CHUTE DE OURO ===== --}}
                    <div id="chute-ouro-panel"
                         style="max-height: 0; overflow: hidden; transition: max-height 0.35s ease, opacity 0.25s ease; opacity: 0;">

                        <div class="mb-5 p-4 md:p-6 rounded-xl border-2 border-yellow-300 bg-gradient-to-br from-yellow-50 to-amber-50 shadow-md">

                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-2xl">⭐</span>
                                <div>
                                    <h3 class="text-base font-bold text-amber-800">Chute de Ouro</h3>
                                    <p class="text-xs text-amber-600">Suas apostas especiais valem pontos bônus!</p>
                                </div>
                            </div>

                            <form id="chute-ouro-form" action="{{ route('chute-de-ouro.store') }}" method="POST">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                    {{-- Chute 01: Campeã --}}
                                    <div class="flex flex-col gap-1">
                                        <label for="chute01" class="text-xs font-bold text-amber-800 uppercase tracking-wide flex items-center gap-1">
                                            🏆 Seleção Campeã
                                        </label>
                                        <p class="text-xs text-amber-600 mb-1">Que seleção será campeã?</p>
                                        <div class="relative">
                                            <select id="chute01" name="chute01"
                                                class="w-full appearance-none pl-3 pr-8 py-2.5 rounded-lg border border-yellow-300 bg-white text-sm font-semibold text-gray-800
                                                       shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                                                <option value="">Escolha uma seleção...</option>
                                                @foreach($teams as $team)
                                                <option value="{{ $team->id }}"
                                                    {{ old('chute01', $chuteDeOuro?->chute01) == $team->id ? 'selected' : '' }}>
                                                    {{ $team->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </div>
                                        {{-- Bandeira do selecionado --}}
                                        <div id="flag-chute01" class="mt-1 flex items-center gap-2 min-h-[28px]"></div>
                                    </div>

                                    {{-- Chute 02: Vice-campeã --}}
                                    <div class="flex flex-col gap-1">
                                        <label for="chute02" class="text-xs font-bold text-amber-800 uppercase tracking-wide flex items-center gap-1">
                                            🥈 Seleção Vice-campeã
                                        </label>
                                        <p class="text-xs text-amber-600 mb-1">Que seleção será vice-campeã?</p>
                                        <div class="relative">
                                            <select id="chute02" name="chute02"
                                                class="w-full appearance-none pl-3 pr-8 py-2.5 rounded-lg border border-yellow-300 bg-white text-sm font-semibold text-gray-800
                                                       shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                                                <option value="">Escolha uma seleção...</option>
                                                @foreach($teams as $team)
                                                <option value="{{ $team->id }}"
                                                    {{ old('chute02', $chuteDeOuro?->chute02) == $team->id ? 'selected' : '' }}>
                                                    {{ $team->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </div>
                                        {{-- Bandeira do selecionado --}}
                                        <div id="flag-chute02" class="mt-1 flex items-center gap-2 min-h-[28px]"></div>
                                    </div>

                                    {{-- Chute 03: Artilheiro --}}
                                    <div class="flex flex-col gap-1">
                                        <label for="chute03" class="text-xs font-bold text-amber-800 uppercase tracking-wide flex items-center gap-1">
                                            ⚽ Artilheiro da Copa
                                        </label>
                                        <p class="text-xs text-amber-600 mb-1">De qual seleção será o artilheiro?</p>
                                        <div class="relative">
                                            <select id="chute03" name="chute03"
                                                class="w-full appearance-none pl-3 pr-8 py-2.5 rounded-lg border border-yellow-300 bg-white text-sm font-semibold text-gray-800
                                                       shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                                                <option value="">Escolha uma seleção...</option>
                                                @foreach($teams as $team)
                                                <option value="{{ $team->id }}"
                                                    {{ old('chute03', $chuteDeOuro?->chute03) == $team->id ? 'selected' : '' }}>
                                                    {{ $team->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </div>
                                        {{-- Bandeira do selecionado --}}
                                        <div id="flag-chute03" class="mt-1 flex items-center gap-2 min-h-[28px]"></div>
                                    </div>

                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button type="submit" id="chute-ouro-submit"
                                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full font-bold text-sm text-white
                                               bg-gradient-to-r from-yellow-500 to-amber-600
                                               shadow-md hover:from-yellow-600 hover:to-amber-700
                                               transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Salvar Chute de Ouro
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                    {{-- ===== FIM CHUTE DE OURO ===== --}}

                    <form id="palpites-form" action="{{ route('palpites.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                            @forelse($games as $game)
                            @php
                            $gameDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $game->date . ' ' . $game->hour, 'America/Sao_Paulo');
                            $isLocked = now()->diffInMinutes($gameDateTime, false) < 60 || $game->status != 0 || $game->email_sent != 0;
                            $palpite = $game->userPalpite;
                            $erroPalpite = ($palpite->home_team_goals ?? null) === null || ($palpite->away_team_goals ?? null) === null;

                            @endphp
                            <div data-game-id="{{ $game->id }}" data-group="{{ $game->group }}" data-fase="{{ $game->fase }}" data-date="{{ $game->date }}" data-status="{{ $game->status }}" style="padding: 10px; @if($game->status == 0) padding-bottom: 22px; @endif" @class(['relative border rounded-lg p-3 md:p-4 shadow-sm hover:shadow-md transition-shadow;','bg-gray-100'=> $isLocked, 'bg-red-50' => !$isLocked && $erroPalpite, 'bg-green-50' => !$isLocked && !$erroPalpite])>

                                <span class="absolute top-2 left-2 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border
                                    @if($game->status == 0)
                                        bg-blue-50 text-blue-700 border-blue-200
                                    @elseif($game->status == 1)
                                        bg-amber-50 text-amber-700 border-amber-200 @if(!$gameDateTime->isFuture()) animate-pulse @endif
                                    @else
                                        bg-gray-100 text-gray-600 border-gray-200
                                    @endif">
                                    <span class="h-2 w-2 rounded-full
                                        @if($game->status == 0)
                                            bg-blue-500
                                        @elseif($game->status == 1)
                                            bg-amber-500
                                        @else
                                            bg-gray-400
                                        @endif"></span>
                                    @if($game->status == 0)
                                        Agendada
                                    @elseif($game->status == 1)
                                        @if($gameDateTime->isFuture())
                                            Em breve
                                        @else
                                            Em Andamento
                                        @endif
                                    @else
                                        Encerrada
                                    @endif
                                </span>

                                <div class="text-center text-sm text-gray-500 mb-2 pt-6 md:pt-4" style="padding-top: 0.5rem">
                                     <span class="font-bold block text-gray-700 text-base">
                                        @php
                                            $faseLabel = match((int)$game->fase) {
                                                1 => 'Fase de Grupos - Grupo ' . $game->group,
                                                2 => 'Segunda Fase - 1/16 de Final',
                                                3 => 'Oitavas de Final',
                                                4 => 'Quartas de Final',
                                                5 => 'Semifinal',
                                                6 => ((int)$game->group === 1 ? 'Final' : 'Disputa de Terceiro e Quarto'),
                                                default => 'Fase ' . $game->fase . ' - Grupo ' . $game->group,
                                            };
                                        @endphp
                                        {{ $faseLabel }}
                                    </span>
                                    {{ $gameDateTime->format('d/m/Y H:i') }}
                                </div>

                                <!-- Times e Inputs -->
                                <div class="flex flex-row items-center justify-between gap-2">

                                    <!-- Mandante -->
                                    <div class="flex flex-col items-center flex-1 min-w-[72px]">
                                        <img src="{{ $game->homeTeam->bandeira }}"
                                            class="h-6 w-9 md:h-8 md:w-12 object-cover mb-1 shadow-sm"
                                            alt="{{ $game->homeTeam->name }}"
                                            style="height: 32px; width: 48px;"
                                            onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';" />
                                        <span class="text-sm md:text-s text-center leading-tight truncate w-full">
                                            {{ $game->homeTeam->name }}
                                            @if($game->status >= 1)
                                            <br /><b><span class="text-lg">({{$game->home_team_goals ?? 0}})</span></b>
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Placar -->
                                    <div class="flex flex-row items-center gap-1 sm:gap-2 justify-center shrink-0">
                                        @if($isLocked)
                                        <span @class([
                                            'text-gray-500 text-center block w-full',
                                            'font-bold text-xl md:text-2xl gap-2 px-4 py-2 bg-gray-200 rounded-lg' => !$erroPalpite,
                                            'text-base sm:text-base md:text-lg font-semibold' => $erroPalpite
                                        ])>
                                            @if(!$erroPalpite)
                                            {{ old('palpites.'.$game->id.'.home_goals', $palpite->home_team_goals) }}
                                            x
                                            {{ old('palpites.'.$game->id.'.away_goals', $palpite->away_team_goals) }}
                                            @else
                                            Você não palpitou<br/>😢 😢 😢
                                            @endif
                                        </span>
                                        @else
                                        <input type="number"
                                            name="palpites[{{ $game->id }}][home_goals]"
                                            value="{{ old('palpites.'.$game->id.'.home_goals', $palpite->home_team_goals ?? '') }}"
                                            class="w-10 sm:w-12 md:w-[8rem] lg:w-[5rem] h-10 md:h-11 text-center border border-gray-300 rounded-md shadow-sm no-spin-mobile
                                                          focus:border-indigo-500 focus:ring-indigo-500 font-bold text-base md:text-lg p-0"
                                            min="0"
                                            {{ $isLocked ? 'disabled' : '' }}>

                                        <span class="text-gray-400 font-bold text-sm md:text-base">×</span>

                                        <input type="number"
                                            name="palpites[{{ $game->id }}][away_goals]"
                                            value="{{ old('palpites.'.$game->id.'.away_goals', $palpite->away_team_goals ?? '') }}"
                                            class="w-10 sm:w-12 md:w-[8rem] lg:w-[5rem] h-10 md:h-11 text-center border border-gray-300 rounded-md shadow-sm no-spin-mobile
                                                          focus:border-indigo-500 focus:ring-indigo-500 font-bold text-base md:text-lg p-0"
                                            min="0"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                        @endif
                                    </div>

                                    <!-- Visitante -->
                                    <div class="flex flex-col items-center flex-1 min-w-[72px]">
                                        <img src="{{ $game->awayTeam->bandeira }}"
                                            class="h-6 w-9 md:h-8 md:w-12 object-cover mb-1 shadow-sm"
                                            alt="{{ $game->awayTeam->name }}"
                                            style="height: 32px; width: 48px;"
                                            onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';" />
                                        <span class="text-sm md:text-s text-center leading-tight truncate w-full">
                                            {{ $game->awayTeam->name }}
                                            @if($game->status >= 1)
                                            <br /><b><span class="text-lg">({{$game->away_team_goals ?? 0}})</span></b>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                @if($isLocked)
                                @php $pontos = optional($palpite)->pontos ?? 0; @endphp
                                <span class="absolute top-2 right-2 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $pontos > 0 ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-gray-200 text-gray-500 border border-gray-300' }}">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Pontos: {{ $pontos }}
                                </span>
                                @endif

                                @if($game->status >= 1)
                                <div class="mt-4 pt-3 border-t border-gray-200 flex justify-center">
                                    <a href="{{ route('partida.apostas', $game->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-lg transition duration-200 shadow-sm border border-indigo-100">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver apostas dos participantes
                                    </a>
                                </div>
                                @endif

                            </div>
                            @empty
                            <div class="col-span-3 text-center text-gray-500 py-8">
                                Nenhum jogo disponível para apostas no momento.
                            </div>
                            @endforelse

                            <div id="no-games-found-message" class="col-span-1 lg:col-span-2 text-center text-gray-500 py-8 hidden">
                                Nenhuma partida encontrada para os filtros selecionados.
                            </div>
                        </div>

                        <div class="fixed bottom-3 left-1/2 -translate-x-1/2 w-full max-w-[90rem] px-4 md:px-6 lg:px-8 pointer-events-none z-50 flex justify-end">
                            <button type="submit"
                                class="pointer-events-auto"
                                style="
                                    background:#3e7738;
                                    color:#fff;
                                    padding:20px 30px;
                                    border-radius:9999px;
                                    font-weight:700;
                                    font-size:14px;
                                    box-shadow:0 6px 15px rgba(0,0,0,0.25);
                                    border:none;
                                    cursor:pointer;
                                "
                                onmouseover="this.style.background='#4b8f44'"
                                onmouseout="this.style.background='#3e7738'">
                                Salvar Palpites
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('palpites-form');
            const statusMessageDiv = document.getElementById('ajax-status-message');
            const statusMessageSpan = statusMessageDiv.querySelector('span');
            const submitButton = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Previne o envio padrão do formulário

                const formData = new FormData(form);
                const originalButtonText = submitButton.innerHTML;

                // Desabilita o botão e mostra o estado de "carregando"
                submitButton.disabled = true;
                submitButton.innerHTML = 'Salvando...';

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json', // Essencial para o Laravel retornar JSON
                        }
                    })
                    .then(response => response.json().then(data => ({
                        status: response.status,
                        body: data
                    })))
                    .then(({
                        status,
                        body
                    }) => {
                        statusMessageDiv.classList.remove('hidden', 'bg-red-100', 'border-red-400', 'text-red-700', 'bg-green-100', 'border-green-400', 'text-green-700');

                        if (status === 200 && body.success) {
                            if (body.jogos_ignorados > 0) {
                                // Havia jogos cujo prazo venceu enquanto a tela estava aberta
                                showToast(
                                    'Atenção: ' + body.jogos_ignorados + ' jogo(s) com prazo encerrado não foram salvos. Atualizando a tela...',
                                    'warning',
                                    3000
                                );
                                setTimeout(() => window.location.reload(), 2500);
                            } else {
                                // Sucesso normal — só atualiza as cores
                                showToast(body.success);
                                atualizarCoresCards();
                            }
                        } else {
                            // Erro de validação ou outro erro do servidor
                            const firstError = body.errors ? Object.values(body.errors)[0][0] : 'Ocorreu um erro inesperado.';
                            statusMessageDiv.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                            showToast(body.message || firstError, 'error');
                        }
                    })
                    .catch(error => {
                        // Erro de rede ou falha na requisição
                        statusMessageDiv.classList.remove('hidden', 'bg-green-100', 'border-green-400', 'text-green-700');
                        statusMessageDiv.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                        showToast('Falha ao salvar. Verifique sua conexão e tente novamente.', 'error');
                    })
                    .finally(() => {
                        // Reabilita o botão e restaura o texto original
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonText;
                    });
            });
        });

        function showToast(message, type = 'success', time = 3000) {
            const toast = document.getElementById('ajax-status-message');
            const text = document.getElementById('ajax-status-text');

            text.innerText = message;

            toast.classList.remove('hidden', 'bg-green-500', 'bg-red-500', 'bg-yellow-500');

            switch (type) {
                case 'error':
                    toast.classList.add('bg-red-500');
                    break;
                case 'warning':
                    toast.classList.add('bg-yellow-500', 'text-black');
                    break;
                default:
                    toast.classList.add('bg-green-500');
            }

            toast.classList.add('opacity-100');

            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, time);
        }

        function atualizarCoresCards() {
            document.querySelectorAll('[data-game-id]').forEach(card => {
                const gameId = card.dataset.gameId;

                const homeInput = document.querySelector(`input[name="palpites[${gameId}][home_goals]"]`);
                const awayInput = document.querySelector(`input[name="palpites[${gameId}][away_goals]"]`);

                if (!homeInput || !awayInput) return;

                const home = homeInput.value;
                const away = awayInput.value;

                card.classList.remove('bg-red-50', 'bg-green-50');

                if (home !== '' && away !== '') {
                    card.classList.add('bg-green-50');
                } else {
                    card.classList.add('bg-red-50');
                }
            });
        }

        // ===== TOGGLE DO PAINEL DE FILTROS =====
        (function () {
            const toggle  = document.getElementById('filters-toggle');
            const panel   = document.getElementById('filters-panel');
            const chevron = document.getElementById('filters-chevron');
            let isOpen = false;

            toggle && toggle.addEventListener('click', () => {
                isOpen = !isOpen;
                if (isOpen) {
                    panel.style.maxHeight = panel.scrollHeight + 300 + 'px'; // +300 para espaço extra
                    panel.style.opacity  = '1';
                    chevron.style.transform = 'rotate(180deg)';
                    toggle.classList.add('border-indigo-400', 'text-indigo-700');
                    toggle.classList.remove('border-gray-300', 'text-gray-700');
                } else {
                    panel.style.maxHeight = '0';
                    panel.style.opacity   = '0';
                    chevron.style.transform = 'rotate(0deg)';
                    toggle.classList.remove('border-indigo-400', 'text-indigo-700');
                    toggle.classList.add('border-gray-300', 'text-gray-700');
                }
            });
        })();
        // ===== FIM TOGGLE =====

        // ===== TOGGLE DO PAINEL CHUTE DE OURO =====
        (function () {
            const toggleBtn = document.getElementById('chute-ouro-toggle');
            const panel     = document.getElementById('chute-ouro-panel');
            const chevron   = document.getElementById('chute-ouro-chevron');
            let isOpen = false;

            toggleBtn && toggleBtn.addEventListener('click', () => {
                isOpen = !isOpen;
                if (isOpen) {
                    panel.style.maxHeight = panel.scrollHeight + 250 + 'px';
                    panel.style.opacity   = '1';
                    chevron.style.transform = 'rotate(180deg)';
                } else {
                    panel.style.maxHeight = '0';
                    panel.style.opacity   = '0';
                    chevron.style.transform = 'rotate(0deg)';
                }
            });

            // Dados de seleções vindos do PHP para exibir bandeiras
            const teamsData = @json($teams->map(fn($t) => ['id' => $t->id, 'name' => $t->name, 'slug' => $t->slug]));

            function getTeamFlag(teamId) {
                const team = teamsData.find(t => String(t.id) === String(teamId));
                if (!team || !team.slug) return null;
                return {
                    url: `https://flagcdn.com/w160/${team.slug.toLowerCase()}.png`,
                    name: team.name
                };
            }

            function updateFlag(selectId, flagDivId) {
                const select  = document.getElementById(selectId);
                const flagDiv = document.getElementById(flagDivId);
                if (!select || !flagDiv) return;

                select.addEventListener('change', () => renderFlag(select.value, flagDiv));
                // Renderiza estado inicial (chute já salvo)
                if (select.value) renderFlag(select.value, flagDiv);
            }

            function renderFlag(teamId, flagDiv) {
                flagDiv.innerHTML = '';
                if (!teamId) return;
                const team = getTeamFlag(teamId);
                if (!team) return;
                flagDiv.innerHTML = `
                    <img src="${team.url}" alt="${team.name}"
                         class="h-5 w-8 object-cover rounded shadow-sm border border-yellow-200"
                         onerror="this.style.display='none'">
                    <span class="text-xs font-semibold text-amber-700">${team.name}</span>
                `;
            }

            updateFlag('chute01', 'flag-chute01');
            updateFlag('chute02', 'flag-chute02');
            updateFlag('chute03', 'flag-chute03');

            // Ajusta altura do painel se estiver aberto quando a bandeira muda
            document.querySelectorAll('#chute01,#chute02,#chute03').forEach(sel => {
                sel.addEventListener('change', () => {
                    if (isOpen) panel.style.maxHeight = panel.scrollHeight + 200 + 'px';
                });
            });
        })();
        // ===== FIM TOGGLE CHUTE DE OURO =====

        // ===== AJAX CHUTE DE OURO =====
        (function () {
            const form   = document.getElementById('chute-ouro-form');
            const btn    = document.getElementById('chute-ouro-submit');
            if (!form || !btn) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const original = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = 'Salvando...';

                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    }
                })
                .then(r => r.json().then(data => ({ status: r.status, body: data })))
                .then(({ status, body }) => {
                    if (status === 200 && body.success) {
                        showToast(body.success, 'success');
                    } else {
                        const msg = body.errors
                            ? Object.values(body.errors)[0][0]
                            : (body.message || 'Erro ao salvar.');
                        showToast(msg, 'error');
                    }
                })
                .catch(() => showToast('Falha ao salvar. Verifique sua conexão.', 'error'))
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = original;
                });
            });
        })();
        // ===== FIM AJAX CHUTE DE OURO =====

        // ===== FILTROS: FASE + GRUPO =====
        (function () {
            // Estado ativo
            const state = { fase: 'all', group: 'all', date: 'all' };

            const badge   = document.getElementById('active-filters-badge');
            const panel   = document.getElementById('filters-panel');

            const faseNomes = {
                '1': 'Fase de Grupos',
                '2': '1/16 Avos de Final',
                '3': 'Oitavas de Final',
                '4': 'Quartas de Final',
                '5': 'Semifinal',
                '6': 'Final',
            };

            // Helpers de data (comparação em YYYY-MM-DD sem horas no fuso local)
            function getLocalDateStr(d) {
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
            function todayStr() {
                return getLocalDateStr(new Date());
            }
            function offsetDateStr(days) {
                const d = new Date();
                d.setDate(d.getDate() + days);
                return getLocalDateStr(d);
            }

            const dateBtns      = document.querySelectorAll('.date-filter-btn');
            const faseBtns      = document.querySelectorAll('.fase-filter-btn');
            const groupBtns     = document.querySelectorAll('.group-filter-btn');
            const cards         = document.querySelectorAll('[data-game-id][data-fase]');
            const groupWrapper  = document.getElementById('group-filter-wrapper');
            const groupLabel    = document.getElementById('group-filter-label');
            const groupLabelTxt = document.getElementById('group-filter-label-text');
            const groupClearBtn = document.getElementById('group-filter-clear');
            const hideFinishedCheckbox = document.getElementById('hide-finished-checkbox');
            if (hideFinishedCheckbox) {
                const savedHideFinished = localStorage.getItem('hide_finished_games');
                if (savedHideFinished !== null) {
                    hideFinishedCheckbox.checked = savedHideFinished === 'true';
                }
            }
            const noGamesMessage = document.getElementById('no-games-found-message');

            // Verifica se uma data de jogo (YYYY-MM-DD) passa no filtro de data ativo
            function matchesDateFilter(cardDate) {
                if (state.date === 'all') return true;
                const today    = todayStr();
                const tomorrow = offsetDateStr(1);
                const weekEnd  = offsetDateStr(7);
                if (state.date === 'today_tomorrow') {
                    return cardDate === today || cardDate === tomorrow;
                }
                if (state.date === 'week') {
                    return cardDate >= today && cardDate <= weekEnd;
                }
                return true;
            }

            // Atualiza badge com o número de filtros ativos (diferentes do padrão)
            function updateBadge() {
                let count = 0;
                if (state.date  !== 'all') count++;
                if (state.fase  !== 'all') count++;
                if (state.group !== 'all') count++;
                if (badge) {
                    badge.textContent = count;
                    badge.classList.toggle('hidden', count === 0);
                }
                // Garante que o painel tem altura suficiente se estiver aberto
                if (panel && panel.style.maxHeight !== '0px' && panel.style.maxHeight !== '') {
                    panel.style.maxHeight = panel.scrollHeight + 300 + 'px';
                }
            }

            // Aplica visibilidade dos cards com base em TODOS os filtros
            function renderCards() {
                const hideFinished = hideFinishedCheckbox ? hideFinishedCheckbox.checked : false;
                let visibleCount = 0;

                cards.forEach(card => {
                    const matchFase  = state.fase  === 'all' || card.dataset.fase  === state.fase;
                    const matchGroup = state.group === 'all' || card.dataset.group === state.group;
                    const matchDate  = matchesDateFilter(card.dataset.date);
                    const matchStatus = !(hideFinished && card.dataset.status === '2');

                    const isVisible = matchFase && matchGroup && matchDate && matchStatus;
                    card.style.display = isVisible ? '' : 'none';
                    if (isVisible) {
                        visibleCount++;
                    }
                });

                if (noGamesMessage) {
                    if (visibleCount === 0) {
                        noGamesMessage.classList.remove('hidden');
                    } else {
                        noGamesMessage.classList.add('hidden');
                    }
                }
            }

            // Estilo ativo/inativo para botões de DATA (âmbar)
            function updateDateBtnStyles() {
                dateBtns.forEach(btn => {
                    const isActive = btn.dataset.date === state.date;
                    btn.classList.toggle('bg-amber-500',      isActive);
                    btn.classList.toggle('text-white',        isActive);
                    btn.classList.toggle('border-transparent',isActive);
                    btn.classList.toggle('bg-white',         !isActive);
                    btn.classList.toggle('text-gray-600',    !isActive);
                    btn.classList.toggle('border-gray-300',  !isActive);
                });
            }

            // Estilo ativo/inativo para botões de FASE (verde esmeralda)
            function updateFaseBtnStyles() {
                faseBtns.forEach(btn => {
                    const isActive = btn.dataset.fase === state.fase;
                    btn.classList.toggle('bg-emerald-600',    isActive);
                    btn.classList.toggle('text-white',        isActive);
                    btn.classList.toggle('border-transparent',isActive);
                    btn.classList.toggle('bg-white',         !isActive);
                    btn.classList.toggle('text-gray-600',    !isActive);
                    btn.classList.toggle('border-gray-300',  !isActive);
                });
            }

            // Estilo ativo/inativo para botões de GRUPO (índigo)
            function updateGroupBtnStyles() {
                groupBtns.forEach(btn => {
                    const isActive = btn.dataset.filter === state.group;
                    btn.classList.toggle('bg-indigo-600',    isActive);
                    btn.classList.toggle('text-white',       isActive);
                    btn.classList.toggle('border-transparent',isActive);
                    btn.classList.toggle('bg-white',        !isActive);
                    btn.classList.toggle('text-gray-600',   !isActive);
                    btn.classList.toggle('border-gray-300', !isActive);
                });

                if (state.group === 'all') {
                    groupLabel && groupLabel.classList.add('hidden');
                } else {
                    if (groupLabel && groupLabelTxt) {
                        groupLabelTxt.textContent = 'Grupo ' + state.group;
                        groupLabel.classList.remove('hidden');
                    }
                }
            }

            // Ao selecionar uma FASE
            faseBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    state.fase  = btn.dataset.fase;
                    state.group = 'all'; // reseta grupo ao trocar fase

                    // Oculta filtro de grupo em fases eliminatórias (fase != 1 e != all)
                    if (groupWrapper) {
                        const showGroup = state.fase === 'all' || state.fase === '1';
                        groupWrapper.style.display = showGroup ? '' : 'none';
                    }

                    updateFaseBtnStyles();
                    updateGroupBtnStyles();
                    renderCards();
                    updateBadge();
                });
            });

            // Ao selecionar um GRUPO
            groupBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    state.group = btn.dataset.filter;
                    updateGroupBtnStyles();
                    renderCards();
                    updateBadge();
                });
            });

            // "Ver todos" no label do grupo
            groupClearBtn && groupClearBtn.addEventListener('click', () => {
                state.group = 'all';
                updateGroupBtnStyles();
                renderCards();
                updateBadge();
            });

            // Ao selecionar uma DATA
            dateBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    state.date = btn.dataset.date;
                    updateDateBtnStyles();
                    renderCards();
                    updateBadge();
                });
            });

            // Ao alternar visibilidade de encerrados
            if (hideFinishedCheckbox) {
                hideFinishedCheckbox.addEventListener('change', () => {
                    localStorage.setItem('hide_finished_games', hideFinishedCheckbox.checked);
                    renderCards();
                });
            }

            // Executa no load da página para aplicar o filtro inicial (ocultar finalizados por padrão)
            renderCards();
        })();
        // ===== FIM FILTROS =====
    </script>
</x-app-layout>