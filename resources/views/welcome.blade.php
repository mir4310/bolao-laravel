<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-900 text-white font-['Figtree']">

    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-500 ease-out">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-end">
            @if (Route::has('login'))
            <div class="flex items-center gap-6">
                @auth
                <a href="{{ url('/dashboard') }}"
                    class="px-6 py-2 rounded-full bg-gray-800 border border-gray-700 hover:bg-gray-700 transition font-bold text-sm">
                    Meus palpites
                </a>
                @else

                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="text-sm font-bold uppercase tracking-widest hover:text-blue-400 transition">
                    Criar Conta
                </a>
                @endif
                <a href="{{ route('login') }}"
                    class="px-6 py-2 bg-green-600 hover:bg-green-500 rounded-full text-sm font-extrabold transition shadow-lg shadow-blue-500/20">
                    Entrar
                </a>
                @endauth
            </div>
            @endif
        </div>
    </nav>

    <header class="relative min-h-[65vh] flex flex-col items-center justify-center text-center px-6 overflow-hidden">

        <div class="absolute inset-0 -z-20">
            <img src="https://mir-s3-cdn-cf.behance.net/project_modules/max_3840_webp/8735ad208410777.66eddc09edb1a.png"
                class="w-full h-full object-cover opacity-40"
                alt="Estádio Copa 2026">
            <div class="absolute inset-0 bg-gradient-to-b from-gray-900/40 via-gray-900/80 to-gray-900"></div>
        </div>

        <div class="z-10 ">
            <h1 class="text-5xl md:text-8xl font-black mb-6 bg-gradient-to-r from-green-400 via-yellow-300 to-blue-500 bg-clip-text text-transparent leading-[1.1]">
                A COPA DO MUNDO <br>CHEGOU!
            </h1>

            <!--p class="text-gray-300 text-lg md:text-2xl max-w-3xl mx-auto mb-10 font-medium drop-shadow-lg">
                Dê seus palpites e conquiste a glória eterna!
            </p-->

            <div class="flex flex-wrap gap-4 justify-center">
                @guest
                <a href="{{ route('login') }}" class="px-12 py-5 bg-green-500 hover:bg-green-400 text-gray-900 font-black rounded-2xl text-xl transition transform hover:scale-105 shadow-[0_10px_40px_rgba(34,197,94,0.4)]">
                    COMEÇAR AGORA
                </a>
                @else
                <a href="{{ url('/dashboard') }}" class="px-12 py-5 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl text-xl transition transform hover:scale-105 shadow-[0_10px_40px_rgba(59,130,246,0.4)]">
                    DAR MEUS PALPITES
                </a>
                @endguest

                <!--button class="px-10 py-5 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl text-lg font-bold hover:bg-white/10 transition">
                    Ver Regulamento
                </button-->
            </div>
        </div>
    </header>

    <section class="max-w-6xl mx-auto px-6 mb-6 grid grid-cols-1 md:grid-cols-2 gap-10">
        <div class="group bg-gray-800/40 p-10 rounded-[2rem] border border-gray-700 hover:border-blue-500/50 transition duration-500">
            <div class="text-blue-500 text-5xl mb-6 group-hover:scale-110 transition-transform">📅</div>
            <h3 class="text-2xl font-black mb-3 italic uppercase">Calendário Real</h3>
            <p class="text-gray-400 text-lg leading-relaxed">Não perca um lance. Jogos atualizados em tempo real diretamente da tabela oficial da FIFA 2026.</p>
        </div>

        <div class="group bg-gray-800/40 p-10 rounded-[2rem] border border-gray-700 hover:border-yellow-500/50 transition duration-500">
            <div class="text-yellow-500 text-5xl mb-6 group-hover:scale-110 transition-transform">📊</div>
            <h3 class="text-2xl font-black mb-3 italic uppercase">Ranking Vivo</h3>
            <p class="text-gray-400 text-lg leading-relaxed">Acompanhe sua posição no bolão mesmo durante a partida. Secar os amigos nunca foi tão divertido.</p>
        </div>
    </section>

    <footer class="py-12 text-center text-gray-500 text-sm border-t border-gray-800 bg-gray-950">
        <p>&copy; 2026 Bolão entre Amigos.</p>
        <div class="inline-flex items-center gap-3 flex-wrap justify-center">
            <a href="https://github.com/mir4310/bolao-laravel" target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 hover:text-gray-600 transition-colors duration-150">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                </svg>
                mir4310/bolao-laravel
            </a>
        </div>
    </footer>

    <script>
        const navbar = document.getElementById('navbar');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add(
                    'bg-gray-900/70',
                    'backdrop-blur-md',
                    'shadow-lg'
                );
            } else {
                navbar.classList.remove(
                    'bg-gray-900/70',
                    'backdrop-blur-md',
                    'shadow-lg'
                );
            }
        });
    </script>
</body>

</html>