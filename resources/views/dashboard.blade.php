<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Panel informacyjny') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Karty ze statystykami --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                {{-- Karta Użytkownicy --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Użytkownicy</h3>
                        <p class="text-3xl font-bold mt-2">{{ $userCount }}</p>
                    </div>
                </div>
                {{-- Kursy --}}
                <a href="{{ route('courses.index') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-200">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Kursy</h3>
                        <p class="text-3xl font-bold mt-2">{{ $courseCount }}</p>
                    </div>
                </a>
                {{-- Kategorie --}}
                <a href="{{ route('categories.index') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-200">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Kategorie</h3>
                        <p class="text-3xl font-bold mt-2">{{ $categoryCount }}</p>
                    </div>
                </a>
                <!-- {{-- Karta Tagi --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Tagi</h3>
                        <p class="text-3xl font-bold mt-2">{{ $tagCount }}</p>
                    </div>
                </div> -->
            </div>

            {{-- Lista ostatnich kursów --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Ostatnio dodane kursy</h3>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($recentCourses as $course)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $course->title }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Kategoria: {{ $course->category->name ?? 'Brak' }}</p>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $course->created_at->diffForHumans() }}</span>
                        </li>
                        @empty
                        <li class="py-3 text-center text-gray-500 dark:text-gray-400">
                            Brak dodanych kursów.
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- NOWA SEKCJA: MOJE KURSY --}}
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Moje kursy</h3>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($myCourses as $course)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <a href="{{ route('courses.show', $course) }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $course->title }}
                                </a>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Kategoria: {{ $course->category->name ?? 'Brak' }}</p>
                            </div>
                            <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded-md text-xs font-semibold uppercase tracking-widest">
                                Przejdź
                            </a>
                        </li>
                        @empty
                        <li class="py-3 text-center text-gray-500 dark:text-gray-400">
                            Nie jesteś zapisany/a na żaden kurs.
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>