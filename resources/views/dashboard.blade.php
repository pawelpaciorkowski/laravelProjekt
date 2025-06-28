<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Panel informacyjny') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Witaj z powrotem, {{ Auth::user()->name }}!</h1>
                <p class="text-lg text-gray-500 dark:text-gray-400 mt-1">Oto co się dzieje w Akademii Wiedzy.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex items-center p-5">
                    <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-800 mr-4">
                        <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Użytkownicy</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $userCount }}</p>
                    </div>
                </div>

                <a href="{{ route('courses.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex items-center p-5 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-800 mr-4">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kursy</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $courseCount }}</p>
                    </div>
                </a>

                <a href="{{ route('categories.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex items-center p-5 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-800 mr-4">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategorie</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $categoryCount }}</p>
                    </div>
                </a>

                <a href="{{ route('tags.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex items-center p-5 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-800 mr-4">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v-3c0-1.105.895-2 2-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tagi</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $tagCount }}</p>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ostatnio dodane kursy</h3>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($recentCourses as $course)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $course->title }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $course->category->name ?? 'Brak kategorii' }}</p>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $course->created_at->diffForHumans() }}</span>
                            </li>
                            @empty
                            <li class="py-3 text-center text-gray-500 dark:text-gray-400">Brak dodanych kursów.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Moje kursy</h3>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($myCourses as $course)
                            <li class="py-3">
                                <a href="{{ route('courses.show', $course) }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $course->title }}
                                </a>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $course->category->name ?? 'Brak kategorii' }}</p>
                            </li>
                            @empty
                            <li class="py-3 text-center text-gray-500 dark:text-gray-400">Nie jesteś zapisany/a na żaden kurs.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>