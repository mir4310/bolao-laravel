<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configurações Globais') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Mensagens de Sucesso ou Erro --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Resultados do Chute de Ouro</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Defina quais foram as seleções Campeã, Vice-campeã e os Artilheiros. Estas configurações serão usadas para calcular os pontos de todos os apostadores.
                    </p>

                    <form action="{{ route('admin.settings.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            
                            {{-- Campeã --}}
                            <div>
                                <label for="chute_campea" class="block text-sm font-bold text-gray-700 mb-1">🏆 Seleção Campeã</label>
                                <select name="chute_campea" id="chute_campea" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                    <option value="">-- Selecione a Campeã --</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" @selected($settings['chute_campea'] == $team->id)>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Vice-campeã --}}
                            <div>
                                <label for="chute_vice" class="block text-sm font-bold text-gray-700 mb-1">🥈 Seleção Vice-campeã</label>
                                <select name="chute_vice" id="chute_vice" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                    <option value="">-- Selecione a Vice-campeã --</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" @selected($settings['chute_vice'] == $team->id)>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Artilheiros (Múltiplo) --}}
                        <div class="mb-6">
                            <label for="chute_artilheiros" class="block text-sm font-bold text-gray-700 mb-1">⚽ Seleções Artilheiras (Múltipla escolha)</label>
                            <p class="text-xs text-gray-500 mb-2">Pressione e segure Ctrl (Windows) ou Command (Mac) para selecionar múltiplos times em caso de empate na artilharia.</p>
                            <select name="chute_artilheiros[]" id="chute_artilheiros" multiple class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" style="min-height: 150px;">
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" @selected(in_array($team->id, $settings['chute_artilheiros']))>{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salvar Configurações
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Processar Chute de Ouro --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-amber-200">
                <div class="p-6 bg-amber-50">
                    <h3 class="text-lg font-bold mb-2 text-amber-800">Processar Pontuação</h3>
                    <p class="text-sm text-amber-700 mb-6">
                        Ao clicar neste botão, o sistema irá aplicar 30 pontos para cada acerto (Campeã, Vice ou Artilheiro) 
                        para todos os usuários baseando-se nas opções configuradas e salvas acima.
                    </p>

                    <form action="{{ route('admin.settings.process') }}" method="POST" onsubmit="return confirm('Tem certeza que deseja processar e atribuir os pontos para todos os usuários agora?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-amber-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <span class="mr-2 text-lg">⭐</span> Processar Pontos do Chute de Ouro
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
