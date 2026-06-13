<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apostas da Partida') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">

                    <div class="mb-4">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Voltar para Palpites
                        </a>
                    </div>

                    <div>
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
                                                    @if($partida->status >= 1)
                                                        <span>{{ $partida->homeGoals ?? 0 }}</span>
                                                    @else
                                                        <span class="text-gray-400 font-medium">-</span>
                                                    @endif
                                                    <span class="text-gray-400 text-xs">x</span>
                                                    @if($partida->status >= 1)
                                                        <span>{{ $partida->awayGoals ?? 0 }}</span>
                                                    @else
                                                        <span class="text-gray-400 font-medium">-</span>
                                                    @endif
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
                                            {{ $partida->date }} - {{ $partida->hour }}
                                        </div>

                                    </th>
                                </tr>

                                <!-- Cabeçalho Desktop -->
                                <tr class="hidden sm:table-row">
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Nome
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Palpite
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
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
                                 <td colspan="3" class="px-3 py-2">
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
                                    'hidden sm:table-row hover:bg-gray-50 transition-colors',
                                    'bg-zinc-200' => $palpites->user_id === auth()->id(),
                                    'hover:bg-zinc-300' => $palpites->user_id === auth()->id()
                                ])>
                                    <td class="px-6 py-3.5 break-words">
                                        <div @class([
                                            'flex items-center gap-3 text-base',
                                            'font-bold text-gray-950' => $palpites->user_id === auth()->id(),
                                            'text-gray-600' => $palpites->user_id !== auth()->id()
                                        ])>
                                            <img class="w-10 h-10 rounded-full shadow-md bg-white" src="{{ $palpites->user->avatar }}" onerror="this.onerror=null;this.src='/img/no-avatar.png';" title="{{ $palpites->user->name }}" alt="{{ $palpites->user->name }}">
                                            <span>{{ $palpites->user->name }}</span>
                                        </div>
                                    </td>

                                    <td @class([
                                        'px-6 py-3.5 text-center text-base',
                                        'font-bold text-gray-950' => $palpites->user_id === auth()->id(),
                                        'font-medium text-gray-600' => $palpites->user_id !== auth()->id()
                                    ])>
                                        @if($palpites->home_team_goals === null || $palpites->away_team_goals === null)
                                            <span title="Não palpitou">😢</span>
                                        @else
                                            {{ $palpites->home_team_goals }} x {{ $palpites->away_team_goals }}
                                        @endif
                                    </td>

                                    <td class="px-6 py-3.5 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[50px] text-center px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 border border-green-300">
                                            {{ $palpites->pontos }} pts
                                        </span>
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
    @if($partida->status == 1)
    <div id="countdown-badge" 
         onclick="window.location.reload();"
         title="Clique para atualizar agora"
         class="fixed bottom-4 right-4 bg-amber-50 text-amber-700 border border-amber-200 px-4 py-2.5 rounded-full text-xs font-semibold shadow-xl z-50 flex items-center gap-2 hover:bg-amber-100 hover:scale-105 active:scale-95 transition-all duration-200 cursor-pointer select-none @if(!$partida->isFuture) animate-pulse @endif">
        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
        <span>@if($partida->isFuture) Partida em breve. @else Partida em andamento. @endif<br/>Atualizando em <span id="countdown-timer" class="font-bold text-amber-900">60</span>s</span>
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