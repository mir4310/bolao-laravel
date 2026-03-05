<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Palpites') }}
        </h2>
    </x-slot>

    <!-- Toast AJAX Status Message -->
    <div id="ajax-status-message"
        class="fixed top-5 right-5 z-50 hidden max-w-sm px-4 py-3 rounded-lg shadow-lg text-white transition-all duration-300">
        <span id="ajax-status-text"></span>
    </div>

    <div class="py-6 md:py-12">
        <div style="padding-bottom:10px" class="max-w-7xl mx-auto md:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm md:rounded-lg">
                <div class="p-4 md:p-6 text-gray-900">

                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block md:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    <form id="palpites-form" action="{{ route('palpites.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                            @forelse($games as $game)
                            @php
                            $gameDateTime = \Carbon\Carbon::parse($game->date . ' ' . $game->hour);
                            $isLocked = $gameDateTime->isPast() || $game->status != 0 || $game->email_sent != 0;
                            $palpite = $game->userPalpite;
                            $erroPalpite = ($palpite->home_team_goals ?? null) === null || ($palpite->away_team_goals ?? null) === null;

                            @endphp
                            <div data-game-id="{{ $game->id }}" style="padding: 10px;" @class(['border rounded-lg p-3 md:p-4 shadow-sm hover:shadow-md transition-shadow;','bg-gray-100'=> $isLocked, 'bg-red-50' => !$isLocked && $erroPalpite, 'bg-green-50' => !$isLocked && !$erroPalpite])">

                                <div class="text-center text-s text-gray-500 mb-2">
                                    <span class="font-bold block text-gray-700">
                                        Fase: {{ ucfirst(str_replace('_', ' ', $game->fase)) }} - Grupo: {{ $game->group }}
                                    </span>
                                    {{ $gameDateTime->format('d/m/Y H:i') }} - {{ $game->city }}
                                </div>

                                <!-- Times e Inputs -->
                                <div class="flex flex-col md:flex-row items-center justify-between gap-2">

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
                                            <br />({{$game->home_team_goals ?? 0}})
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Placar -->
                                    <div class="flex flex-col md:flex-row items-center gap-1 md:gap-2 justify-center shrink-0">
                                        @if($isLocked)
                                        <span class="text-gray-400 font-bold text-xl md:text-3xl">
                                            @if(!$erroPalpite)
                                            {{ old('palpites.'.$game->id.'.home_goals', $palpite->home_team_goals) }}
                                            x
                                            {{ old('palpites.'.$game->id.'.away_goals', $palpite->away_team_goals) }}
                                            @else
                                            Você não palpitou! 😢
                                            @endif
                                        </span>
                                        @else
                                        <input type="number"
                                            name="palpites[{{ $game->id }}][home_goals]"
                                            value="{{ old('palpites.'.$game->id.'.home_goals', $palpite->home_team_goals ?? '') }}"
                                            class="w-[8rem] sm:w-[8rem] sm:w-[8rem] lg:w-[5rem] h-10 md:h-11 text-center border border-gray-300 rounded-md shadow-sm
                                                          focus:border-indigo-500 focus:ring-indigo-500 font-bold text-base md:text-lg p-0"
                                            min="0"
                                            {{ $isLocked ? 'disabled' : '' }}>

                                        <span class="text-gray-400 font-bold text-sm md:text-base">×</span>

                                        <input type="number"
                                            name="palpites[{{ $game->id }}][away_goals]"
                                            value="{{ old('palpites.'.$game->id.'.away_goals', $palpite->away_team_goals ?? '') }}"
                                            class="w-[8rem] sm:w-[8rem] sm:w-[8rem] lg:w-[5rem] h-10 md:h-11 text-center border border-gray-300 rounded-md shadow-sm
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
                                            <br />({{$game->away_team_goals ?? 0}})
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                @if($isLocked)
                                <div class="mt-2 text-center text-xs text-gray-500">
                                    Aposta encerrada! Pontuação na partida: {{ optional($palpite)->pontos ?? 0 }}
                                </div>
                                @endif

                            </div>
                            @empty
                            <div class="col-span-3 text-center text-gray-500 py-8">
                                Nenhum jogo disponível para apostas no momento.
                            </div>
                            @endforelse
                        </div>

                        <!--div class="bg-green-200 md:bg-green-100 fixed bottom-0 left-0 right-0 bg-gray-100 border-t border-gray-300 shadow-lg p-4 z-50"-->
                        <div class="max-w-7xl mx-auto flex justify-center" style="
                                    position: fixed;
                                    right: 15px;
                                    bottom: 12px;">
                            <button type="submit"
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
                        <!--/div-->

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
                            // Sucesso
                            statusMessageDiv.classList.add('bg-green-100', 'border-green-400', 'text-green-700');
                            showToast(body.success);
                            atualizarCoresCards();
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
    </script>
</x-app-layout>