<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Palpites de ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm md:rounded-lg">
                <div class="p-4 md:p-6 text-gray-900">

                    {{-- Botão Voltar --}}
                    <div class="mb-6">
                        <a href="{{ route('ranking.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Voltar para Classificação
                        </a>
                    </div>

                    @php
                        $totalComChute = ($user->palpites_sum_pontos ?? 0) + ($chuteDeOuro?->total_pontos ?? 0);
                    @endphp

                    {{-- Cabeçalho do Apostador --}}
                    <div class="flex flex-col sm:flex-row items-center gap-4 p-4 md:p-6 mb-4 rounded-xl border border-gray-200 bg-gray-50 shadow-sm">
                        <img class="w-16 h-16 md:w-20 md:h-20 rounded-full shadow-md bg-white border-2 border-indigo-100 flex-shrink-0"
                            src="{{ $user->avatar }}"
                            onerror="this.onerror=null;this.src='/img/no-avatar.png';"
                            alt="{{ $user->name }}">
                        <div class="text-center sm:text-left flex-grow">
                            <h3 class="text-lg md:text-xl font-extrabold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">Participante do Bolão</p>
                        </div>
                        <div class="bg-indigo-600 text-white font-extrabold px-6 py-3 rounded-xl shadow-md text-center shrink-0">
                            <span class="block text-xs uppercase tracking-wider font-semibold opacity-80">Pontuação Total</span>
                            <span class="text-2xl md:text-3xl">{{ $totalComChute }} pts</span>
                        </div>
                    </div>

                    {{-- Bloco do Chute de Ouro --}}
                    @if($chuteDeOuro)
                    <div class="mb-8 rounded-xl border border-amber-200 bg-amber-50/50 p-4 md:p-5 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">⭐</span>
                            <h4 class="text-base font-bold text-amber-800 uppercase tracking-wide">Chute de Ouro</h4>
                        </div>
                        
                        <div class="flex items-center justify-center gap-4 md:gap-8 flex-wrap">
                            @foreach([['team01','🏆','Campeã'],['team02','🥈','Vice'],['team03','⚽','Artilheiro']] as [$rel, $emoji, $label])
                            @php $t = $chuteDeOuro->$rel; @endphp
                            <div class="flex flex-col items-center gap-1 min-w-[70px]">
                                <span class="text-[10px] text-amber-700/80 font-bold uppercase tracking-wider">{{ $emoji }} {{ $label }}</span>
                                @if($t)
                                    <img src="{{ $t->bandeira }}" class="h-6 w-9 object-cover shadow-sm rounded border border-amber-200/50" alt="{{ $t->name }}" onerror="this.style.display='none'">
                                    <span class="text-xs text-gray-800 font-bold text-center leading-tight truncate w-full max-w-[80px]">{{ $t->name }}</span>
                                @else
                                    <span class="text-sm text-gray-400 italic">—</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="bg-amber-100 text-amber-900 font-bold px-4 py-2 rounded-lg text-center shrink-0 border border-amber-300">
                            <span class="block text-[10px] uppercase tracking-wider opacity-80">Pontos</span>
                            <span class="text-lg">{{ $chuteDeOuro->total_pontos ?? 0 }}</span>
                        </div>
                    </div>
                    @endif


                    {{-- Título da Seção --}}
                    <div class="mb-4">
                        <h4 class="text-base font-bold text-gray-700 uppercase tracking-wide">Histórico de Palpites</h4>
                        <p class="text-xs text-gray-500">Exibindo palpites de partidas em andamento, encerradas ou com apostas encerradas.</p>
                    </div>

                    {{-- Grid de Palpites --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        @forelse($games as $game)
                            @php
                                $palpite = $game->palpites->first();
                                $hasPalpite = !is_null($palpite) && !is_null($palpite->home_team_goals) && !is_null($palpite->away_team_goals);
                                $gameDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $game->date . ' ' . $game->hour, 'America/Sao_Paulo');
                                $isFuture = $gameDateTime->isFuture();
                                $pontos = $hasPalpite ? $palpite->pontos : 0;
                            @endphp

                            <div class="relative border rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow
                                @if(!$hasPalpite) bg-red-50/50 border-red-200
                                @elseif($game->status == 2 && $pontos > 0) bg-green-50/50 border-green-200
                                @else bg-white border-gray-200 @endif">

                                {{-- Status da Partida --}}
                                <span class="absolute top-2 left-2 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border
                                    @if($game->status == 1 && $isFuture)
                                        bg-blue-50 text-blue-700 border-blue-200
                                    @elseif($game->status == 1 && !$isFuture)
                                        bg-amber-50 text-amber-700 border-amber-200 animate-pulse
                                    @else
                                        bg-gray-100 text-gray-600 border-gray-200
                                    @endif">
                                    <span class="h-2 w-2 rounded-full
                                        @if($game->status == 1 && $isFuture)
                                            bg-blue-500
                                        @elseif($game->status == 1 && !$isFuture)
                                            bg-amber-500
                                        @else
                                            bg-gray-400
                                        @endif"></span>
                                    @if($game->status == 1)
                                        @if($isFuture)
                                            Em breve
                                        @else
                                            Em Andamento
                                        @endif
                                    @else
                                        Encerrada
                                    @endif
                                </span>

                                {{-- Pontos Recebidos --}}
                                <span class="absolute top-2 right-2 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold border
                                    @if($game->status == 1 && $isFuture)
                                        bg-blue-50 text-blue-700 border-blue-200
                                    @elseif($pontos > 0)
                                        bg-green-100 text-green-800 border-green-300
                                    @else
                                        bg-gray-200 text-gray-500 border-gray-300
                                    @endif">
                                    @if($game->status == 1 && $isFuture)
                                        Aguardando
                                    @else
                                        Pontos: {{ $pontos }}
                                    @endif
                                </span>

                                {{-- Detalhes da Partida --}}
                                <div class="text-center text-sm text-gray-500 mb-2 pt-6">
                                    <span class="font-bold block text-gray-700 text-sm">
                                        Fase: {{ ucfirst(str_replace('_', ' ', $game->fase)) }} - Grupo: {{ $game->group }}
                                    </span>
                                    {{ $gameDateTime->format('d/m/Y H:i') }}
                                </div>

                                {{-- Times e Placar --}}
                                <div class="flex flex-row items-center justify-between gap-2 mt-4">
                                    {{-- Mandante --}}
                                    <div class="flex flex-col items-center flex-1 min-w-[72px]">
                                        <img src="{{ $game->homeTeam->bandeira }}"
                                            class="h-6 w-9 md:h-8 md:w-12 object-cover mb-1 shadow-sm"
                                            alt="{{ $game->homeTeam->name }}"
                                            style="height: 32px; width: 48px;"
                                            onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';" />
                                        <span class="text-xs md:text-sm text-center leading-tight truncate w-full">
                                            {{ $game->homeTeam->name }}
                                            @if($game->status >= 1)
                                                <br/><b><span class="text-base text-gray-900">({{ $game->home_team_goals ?? 0 }})</span></b>
                                            @endif
                                        </span>
                                    </div>

                                    {{-- Placar do Palpite --}}
                                    <div class="flex flex-col items-center justify-center shrink-0 px-2 sm:px-4">
                                        <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider mb-1">Palpite</span>
                                        @if($hasPalpite)
                                            <div class="flex items-center gap-2 px-3 py-1 bg-indigo-50 border border-indigo-100 rounded-lg">
                                                <span class="text-lg md:text-xl font-black text-indigo-900">{{ $palpite->home_team_goals }}</span>
                                                <span class="text-gray-400 font-bold text-xs">x</span>
                                                <span class="text-lg md:text-xl font-black text-indigo-900">{{ $palpite->away_team_goals }}</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-red-500 font-bold italic text-center">Não palpitou <br/>😢</span>
                                        @endif
                                    </div>

                                    {{-- Visitante --}}
                                    <div class="flex flex-col items-center flex-1 min-w-[72px]">
                                        <img src="{{ $game->awayTeam->bandeira }}"
                                            class="h-6 w-9 md:h-8 md:w-12 object-cover mb-1 shadow-sm"
                                            alt="{{ $game->awayTeam->name }}"
                                            style="height: 32px; width: 48px;"
                                            onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/b/b0/No_flag.svg';" />
                                        <span class="text-xs md:text-sm text-center leading-tight truncate w-full">
                                            {{ $game->awayTeam->name }}
                                            @if($game->status >= 1)
                                                <br/><b><span class="text-base text-gray-900">({{ $game->away_team_goals ?? 0 }})</span></b>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="col-span-2 text-center text-gray-500 py-8">
                                Nenhuma partida com palpites liberados para este usuário até o momento.
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
