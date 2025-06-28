<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div class="flex flex-col min-h-screen">

        <header class="p-6 lg:p-8">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="/">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>

                @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                    <a href="{{ url('/dashboard') }}">
                        <x-primary-button>Panel</x-primary-button>
                    </a>
                    @else
                    <a href="{{ route('login') }}">
                        <x-secondary-button>Zaloguj się</x-secondary-button>
                    </a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}">
                        <x-primary-button>Zarejestruj się</x-primary-button>
                    </a>
                    @endif
                    @endauth
                </nav>
                @endif
            </div>
        </header>

        <main class="flex-grow flex items-center justify-center">
            <div class="max-w-3xl mx-auto text-center p-6">
                <h1 class="text-4xl lg:text-6xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Rozwijaj swoje umiejętności z <span class="text-indigo-600 dark:text-indigo-400">Akademią Wiedzy</span>.
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
                    Dołącz do naszej platformy i uzyskaj dostęp do szerokiej gamy kursów online. Zarządzaj swoją nauką, śledź postępy i zdobywaj nowe kompetencje w jednym miejscu.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('register') }}">
                        <x-primary-button class="text-base px-6 py-3">Rozpocznij naukę</x-primary-button>
                    </a>
                    <a href="{{ route('courses.index') }}" class="text-base font-semibold leading-6 text-gray-900 dark:text-white">
                        Przeglądaj kursy <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </main>

        <footer class="text-center p-6 text-sm text-gray-500 dark:text-gray-400">
            © {{ date('Y') }} Akademia Wiedzy. Wszelkie prawa zastrzeżone.
        </footer>
    </div>
</body>

</html>