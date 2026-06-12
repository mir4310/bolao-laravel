<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="mt-4">
            <x-input-label for="telefone" :value="__('Telefone Celular')" />
            <x-text-input id="telefone" name="telefone" type="text" class="mt-1 block w-full" :value="old('telefone', $user->telefone)" />
            <x-input-error class="mt-2" :messages="$errors->get('telefone')" />
        </div>

        <div class="mt-4">
            <x-input-label for="quem_indicou" :value="__('Quem indicou você?')" />
            <x-text-input id="quem_indicou" name="quem_indicou" type="text" class="mt-1 block w-full" :value="old('quem_indicou', $user->quem_indicou)" />
            <x-input-error class="mt-2" :messages="$errors->get('quem_indicou')" />
        </div>


        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-full" id="avatar-generator">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Gerador de Avatar') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Personalize seu avatar para usar no bolão.') }}
                    </p>
                </header>

                <div class="mt-6 flex flex-col md:flex-row gap-8">
                    <!-- Preview -->
                    <div class="flex-1 flex flex-col items-center justify-start p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <img id="avatarPreview" class="w-64 h-64 md:w-64 md:h-64 rounded-full shadow-md bg-white mb-4" src="" alt="Avatar Preview">
                        <!--button type="button" onclick="copyURL()" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Copiar URL
                            </button-->
                    </div>

                    <!-- Controls -->
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="topType" class="block font-medium text-sm text-gray-700">Cabelo / Chapéu</label>
                            <select id="topType" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="NoHair">Careca</option>
                                <option value="Eyepatch">Tapa-olho</option>
                                <option value="Hat">Chapéu</option>
                                <option value="Hijab">Hijab</option>
                                <option value="Turban">Turbante</option>
                                <option value="WinterHat1">Touca de Inverno 1</option>
                                <option value="WinterHat2">Touca de Inverno 2</option>
                                <option value="WinterHat3">Touca de Inverno 3</option>
                                <option value="WinterHat4">Touca de Inverno 4</option>
                                <option value="LongHairBigHair">Longo Volumoso</option>
                                <option value="LongHairBob">Longo Bob</option>
                                <option value="LongHairBun">Longo Coque</option>
                                <option value="LongHairCurly">Longo Cacheado</option>
                                <option value="LongHairCurvy">Longo Ondulado</option>
                                <option value="LongHairDreads">Longo Dreads</option>
                                <option value="LongHairFrida">Longo Frida</option>
                                <option value="LongHairFro">Longo Black Power</option>
                                <option value="LongHairFroBand">Longo Black Power Faixa</option>
                                <option value="LongHairNotTooLong">Longo Médio</option>
                                <option value="LongHairShavedSides">Longo Lados Raspados</option>
                                <option value="LongHairMiaWallace">Longo Mia Wallace</option>
                                <option value="LongHairStraight">Longo Liso</option>
                                <option value="LongHairStraight2">Longo Liso 2</option>
                                <option value="LongHairStraightStrand">Longo Liso Mechas</option>
                                <option value="ShortHairDreads01">Curto Dreads 1</option>
                                <option value="ShortHairDreads02">Curto Dreads 2</option>
                                <option value="ShortHairFrizzle">Curto Crespo</option>
                                <option value="ShortHairShaggyMullet">Curto Mullet</option>
                                <option value="ShortHairShortCurly">Curto Cacheado</option>
                                <option value="ShortHairShortFlat">Curto Liso</option>
                                <option value="ShortHairShortRound">Curto Redondo</option>
                                <option value="ShortHairShortWaved">Curto Ondulado</option>
                                <option value="ShortHairSides">Curto Lados</option>
                                <option value="ShortHairTheCaesar">Curto Caesar</option>
                                <option value="ShortHairTheCaesarSidePart">Curto Caesar Lado</option>
                            </select>
                        </div>

                        <div id="accessoriesType-div">
                            <label for="accessoriesType" class="block font-medium text-sm text-gray-700">Acessórios</label>
                            <select id="accessoriesType" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Blank">Nenhum</option>
                                <option value="Kurt">Kurt</option>
                                <option value="Prescription01">Óculos Grau 1</option>
                                <option value="Prescription02">Óculos Grau 2</option>
                                <option value="Round">Redondo</option>
                                <option value="Sunglasses">Óculos Escuros</option>
                                <option value="Wayfarers">Wayfarers</option>
                            </select>
                        </div>

                        <div id="hairColor-div">
                            <label for="hairColor" class="block font-medium text-sm text-gray-700">Cor do Cabelo</label>
                            <select id="hairColor" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Auburn">Ruivo Escuro</option>
                                <option value="Black">Preto</option>
                                <option value="Blonde">Loiro</option>
                                <option value="BlondeGolden">Loiro Dourado</option>
                                <option value="Brown">Castanho</option>
                                <option value="BrownDark">Castanho Escuro</option>
                                <option value="PastelPink">Rosa Pastel</option>
                                <option value="Platinum">Platina</option>
                                <option value="Red">Vermelho</option>
                                <option value="SilverGray">Cinza Prateado</option>
                            </select>
                        </div>

                        <div>
                            <label for="facialHairType" class="block font-medium text-sm text-gray-700">Barba / Bigode</label>
                            <select id="facialHairType" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Blank">Nenhum</option>
                                <option value="BeardMedium">Barba Média</option>
                                <option value="BeardLight">Barba Rala</option>
                                <option value="BeardMajestic">Barba Majestosa</option>
                                <option value="MoustacheFancy">Bigode Chique</option>
                                <option value="MoustacheMagnum">Bigode Magnum</option>
                            </select>
                        </div>

                        <div id="facialHairColor-div">
                            <label for="facialHairColor" class="block font-medium text-sm text-gray-700">Cor da Barba</label>
                            <select id="facialHairColor" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Auburn">Ruivo Escuro</option>
                                <option value="Black">Preto</option>
                                <option value="Blonde">Loiro</option>
                                <option value="BlondeGolden">Loiro Dourado</option>
                                <option value="Brown">Castanho</option>
                                <option value="BrownDark">Castanho Escuro</option>
                                <option value="Platinum">Platina</option>
                                <option value="Red">Vermelho</option>
                            </select>
                        </div>

                        <div>
                            <label for="clotheType" class="block font-medium text-sm text-gray-700">Roupa</label>
                            <select id="clotheType" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="BlazerShirt">Blazer e Camisa</option>
                                <option value="BlazerSweater">Blazer e Suéter</option>
                                <option value="CollarSweater">Gola e Suéter</option>
                                <option value="GraphicShirt">Camiseta Estampada</option>
                                <option value="Hoodie">Moletom</option>
                                <option value="Overall">Macacão</option>
                                <option value="ShirtCrewNeck">Camiseta Gola Careca</option>
                                <option value="ShirtScoopNeck">Camiseta Gola Canoa</option>
                                <option value="ShirtVNeck">Camiseta Gola V</option>
                            </select>
                        </div>

                        <div id="clotheColor-div">
                            <label for="clotheColor" class="block font-medium text-sm text-gray-700">Cor da Roupa</label>
                            <select id="clotheColor" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Black">Preto</option>
                                <option value="Blue01">Azul 1</option>
                                <option value="Blue02">Azul 2</option>
                                <option value="Blue03">Azul 3</option>
                                <option value="Gray01">Cinza 1</option>
                                <option value="Gray02">Cinza 2</option>
                                <option value="Heather">Mescla</option>
                                <option value="PastelBlue">Azul Pastel</option>
                                <option value="PastelGreen">Verde Pastel</option>
                                <option value="PastelOrange">Laranja Pastel</option>
                                <option value="PastelRed">Vermelho Pastel</option>
                                <option value="PastelYellow">Amarelo Pastel</option>
                                <option value="Pink">Rosa</option>
                                <option value="Red">Vermelho</option>
                                <option value="White">Branco</option>
                            </select>
                        </div>

                        <div>
                            <label for="eyeType" class="block font-medium text-sm text-gray-700">Olhos</label>
                            <select id="eyeType" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Default">Normal</option>
                                <option value="Close">Fechados</option>
                                <option value="Cry">Chorando</option>
                                <option value="Dizzy">Tonto</option>
                                <option value="EyeRoll">Revirando</option>
                                <option value="Happy">Feliz</option>
                                <option value="Hearts">Corações</option>
                                <option value="Side">De Lado</option>
                                <option value="Squint">Apertado</option>
                                <option value="Surprised">Surpreso</option>
                                <option value="Wink">Piscando</option>
                                <option value="WinkWacky">Piscando Louco</option>
                            </select>
                        </div>

                        <div>
                            <label for="eyebrowType" class="block font-medium text-sm text-gray-700">Sobrancelha</label>
                            <select id="eyebrowType" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Default">Normal</option>
                                <option value="DefaultNatural">Normal Natural</option>
                                <option value="Angry">Bravo</option>
                                <option value="AngryNatural">Bravo Natural</option>
                                <option value="FlatNatural">Reta Natural</option>
                                <option value="RaisedExcited">Animado</option>
                                <option value="RaisedExcitedNatural">Animado Natural</option>
                                <option value="SadConcerned">Preocupado</option>
                                <option value="SadConcernedNatural">Preocupado Natural</option>
                                <option value="UnibrowNatural">Monocelha</option>
                                <option value="UpDown">Cima Baixo</option>
                                <option value="UpDownNatural">Cima Baixo Natural</option>
                            </select>
                        </div>

                        <div>
                            <label for="mouthType" class="block font-medium text-sm text-gray-700">Boca</label>
                            <select id="mouthType" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Default">Normal</option>
                                <option value="Concerned">Preocupado</option>
                                <option value="Disbelief">Incrédulo</option>
                                <option value="Eating">Comendo</option>
                                <option value="Grimace">Careta</option>
                                <option value="Sad">Triste</option>
                                <option value="ScreamOpen">Grito</option>
                                <option value="Serious">Sério</option>
                                <option value="Smile">Sorriso</option>
                                <option value="Tongue">Língua</option>
                                <option value="Twinkle">Brilho</option>
                                <option value="Vomit">Vomitando</option>
                            </select>
                        </div>

                        <div>
                            <label for="skinColor" class="block font-medium text-sm text-gray-700">Cor da Pele</label>
                            <select id="skinColor" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Tanned">Bronzeada</option>
                                <option value="Yellow">Amarela</option>
                                <option value="Pale">Pálida</option>
                                <option value="Light">Clara</option>
                                <option value="Brown">Marrom</option>
                                <option value="DarkBrown">Marrom Escuro</option>
                                <option value="Black">Negra</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
        <input type="hidden" name="avatar" id="avatar" value="{{ old('avatar', $user->getRawOriginal('avatar')) }}" />
    </form>

    <script>
        document.getElementById('telefone').addEventListener('input', function(e) {
            // Remove tudo que não for número
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);

            // Monta a formatação: (XX) XXXXX-XXXX
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    </script>
</section>



<script>
    function updateUI() {
        const topType = document.getElementById("topType").value;
        const facialHairType = document.getElementById("facialHairType").value;

        // Lógica simples para ocultar campos irrelevantes (igual ao site)
        const hasHair = !['NoHair', 'Eyepatch', 'Hat', 'Hijab', 'Turban', 'WinterHat1', 'WinterHat2', 'WinterHat3', 'WinterHat4'].includes(topType);
        const hasFacialHair = facialHairType !== 'Blank';

        const hairColorDiv = document.getElementById("hairColor-div");
        if (hairColorDiv) hairColorDiv.style.display = hasHair ? 'block' : 'none';

        const facialHairColorDiv = document.getElementById("facialHairColor-div");
        if (facialHairColorDiv) facialHairColorDiv.style.display = hasFacialHair ? 'block' : 'none';

        //Oculta a escolha da cor da roupa dependendo da roupa escolhida. Nem todos os tipos de roupa obedecem as cores
        const roupaEscolhida = document.getElementById("clotheType").value;
        const hasRoupa = !['BlazerShirt', 'BlazerSweater'].includes(roupaEscolhida);
        const clotheColorDiv = document.getElementById("clotheColor-div");
        if (clotheColorDiv) clotheColorDiv.style.display = hasRoupa ? 'block' : 'none';
    }

    function atualizarAvatar() {
        updateUI();

        const params = new URLSearchParams();
        params.append("avatarStyle", "Transparent"); // Ou Circle

        // Mapeamento direto dos campos
        params.append("topType", document.getElementById("topType").value);
        params.append("accessoriesType", document.getElementById("accessoriesType").value);

        // Só envia cor do cabelo se tiver cabelo (para evitar URL suja, embora a API ignore)
        const topType = document.getElementById("topType").value;
        if (!['NoHair', 'Eyepatch', 'Hat', 'Hijab', 'Turban', 'WinterHat1', 'WinterHat2', 'WinterHat3', 'WinterHat4'].includes(topType)) {
            params.append("hairColor", document.getElementById("hairColor").value);
        }

        const facialHairType = document.getElementById("facialHairType").value;
        params.append("facialHairType", facialHairType);

        if (facialHairType !== 'Blank') {
            params.append("facialHairColor", document.getElementById("facialHairColor").value);
        }

        params.append("clotheType", document.getElementById("clotheType").value);
        params.append("clotheColor", document.getElementById("clotheColor").value);
        params.append("eyeType", document.getElementById("eyeType").value);
        params.append("eyebrowType", document.getElementById("eyebrowType").value);
        params.append("mouthType", document.getElementById("mouthType").value);
        params.append("skinColor", document.getElementById("skinColor").value);

        // Usando a API direta do avataaars.io que aceita exatamente esses parâmetros
        const url = "https://avataaars.io/?" + params.toString();

        document.getElementById("avatarPreview").src = url;
        document.getElementById("avatar").value = url;
        window.avatarURL = url;
    }

    document.addEventListener("DOMContentLoaded", () => {
        const container = document.getElementById("avatar-generator");
        if (!container) return;

        //Ajusta o formulário para o avatar já salvo do usuário
        const savedAvatar = document.getElementById("avatar").value;
        if (savedAvatar) {
            let queryString = savedAvatar;
            if (savedAvatar.includes('?')) {
                queryString = savedAvatar.substring(savedAvatar.indexOf('?') + 1);
            }
            const params = new URLSearchParams(queryString);
            params.forEach((value, key) => {
                const el = document.getElementById(key);
                if (el) el.value = value;
            });
        }

        //A qualquer alteração nos campos do avatar, atualiza a URL e o campo oculto
        container.querySelectorAll("select,input").forEach(el => {
            el.addEventListener("change", atualizarAvatar);
        });
        atualizarAvatar();
    });
</script>