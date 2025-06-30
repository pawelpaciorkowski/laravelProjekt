<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Szczegóły kursu
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <div class="md:col-span-2">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $course->title }}</h3>
                            <p class="text-lg text-gray-500 dark:text-gray-400 mt-1">{{ $course->category->name ?? 'Brak kategorii' }}</p>

                            {{-- SEKCJA WIDEO (DYNAMICZNA) --}}
                            @if($course->video_url)
                            @php
                            // funkcja do wyciągnięcia ID filmu z linku YouTube
                            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $course->video_url, $matches);
                            $youtubeId = $matches[1] ?? null;
                            @endphp

                            @if($youtubeId)
                            <div class="mt-6 aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-lg">
                                {{-- PRAWIDŁOWY FORMAT LINKU DO OSADZENIA --}}
                                <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                            @else
                            {{-- Komunikat, jeśli link nie jest z YouTube --}}
                            <div class="mt-6 p-4 bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 rounded-lg">
                                Podany link wideo nie jest obsługiwanym linkiem YouTube.
                            </div>
                            @endif
                            @else
                            {{-- Placeholder, jeśli wideo nie zostało dodane --}}
                            <div class="mt-6 aspect-w-16 aspect-h-9 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                    </svg>
                                    <p class="mt-2 text-sm font-semibold text-gray-400 dark:text-gray-500">Dla tego kursu nie dodano wideo.</p>
                                </div>
                            </div>
                            @endif

                            <div class="mt-8">
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">O kursie</h4>
                                <p class="mt-2 text-gray-600 dark:text-gray-300 leading-relaxed">{{ $course->description }}</p>
                            </div>

                            <div class="mt-8">
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Program kursu</h4>
                                <ul class="mt-4 space-y-3">
                                    @php
                                    $lessons = [
                                    ['title' => 'Wprowadzenie i konfiguracja środowiska', 'duration' => '25 min'],
                                    ['title' => 'Podstawowe koncepcje i składnia', 'duration' => '45 min'],
                                    ['title' => 'Praktyczny projekt: Budowa pierwszej aplikacji', 'duration' => '1h 30min'],
                                    ['title' => 'Zaawansowane techniki i dobre praktyki', 'duration' => '1h 15min'],
                                    ['title' => 'Testowanie i wdrożenie na produkcję', 'duration' => '55 min'],
                                    ];
                                    @endphp
                                    @foreach ($lessons as $index => $lesson)
                                    <li class="p-4 flex items-center justify-between bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                        <div class="flex items-center">
                                            <span class="text-indigo-500 dark:text-indigo-400 font-bold text-lg mr-4">{{ $index + 1 }}</span>
                                            <div>
                                                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $lesson['title'] }}</p>
                                                <p class="text-sm text-gray-500">{{ $lesson['duration'] }}</p>
                                            </div>
                                        </div>
                                        <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                        </svg>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="md:col-span-1">
                            <div class="sticky top-8 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-6">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Informacje o kursie</h4>

                                <ul class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-300">

                                    <li class="flex items-center"><svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg> Data rozpoczęcia: <strong class="ml-1 font-semibold text-gray-800 dark:text-gray-100">{{ $course->start_date }}</strong></li>
                                    <li class="flex items-center"><svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg> Uczestnicy: <strong class="ml-1 font-semibold text-gray-800 dark:text-gray-100">{{ $course->participants->count() }}</strong></li>
                                    <li class="flex items-center"><svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg> Czas trwania: <strong class="ml-1 font-semibold text-gray-800 dark:text-gray-100">~5 godzin</strong></li>
                                    <li class="flex items-center"><svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg> Dostęp: <strong class="ml-1 font-semibold text-gray-800 dark:text-gray-100">Dostęp na zawsze</strong></li>
                                </ul>

                                <div class="mt-6">
                                    @if(Auth::user()->enrollments->contains($course))
                                    <div class="text-center p-3 rounded-md bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 font-semibold">Jesteś uczestnikiem tego kursu</div>
                                    <form action="{{ route('courses.unenroll', $course) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="w-full text-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">Wypisz się</button>
                                    </form>
                                    @else
                                    <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-bold text-white uppercase tracking-widest hover:bg-indigo-700">Zapisz się na kurs</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-success-modal name="enrollment-success" />

    @if (session('enrollment_success'))
    <div class="hidden" x-data x-init="
        $nextTick(() => {
            //  konfetti!
            const duration = 3 * 1000;
            const animationEnd = Date.now() + duration;
            const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) {
              return Math.random() * (max - min) + min;
            }

            const interval = setInterval(function() {
              const timeLeft = animationEnd - Date.now();

              if (timeLeft <= 0) {
                return clearInterval(interval);
              }

              const particleCount = 50 * (timeLeft / duration);
              confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
              confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);

            //  modal z wiadomością
            $dispatch('open-modal', {
                name: 'enrollment-success',
                title: 'Zapisano na Kurs!',
                message: '{{ session('enrollment_success') }}'
            });
        });
    "></div>
    @endif
</x-app-layout>