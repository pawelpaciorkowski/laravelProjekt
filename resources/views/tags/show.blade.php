<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Szczegóły Tagu: ') . $tag->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-semibold">{{ $tag->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">ID Tagu: {{ $tag->id }}</p>
                    <p class="text-sm text-gray-500">Utworzono: {{ $tag->created_at->format('Y-m-d H:i') }}</p>
                    <p class="text-sm text-gray-500">Ostatnia aktualizacja: {{ $tag->updated_at->format('Y-m-d H:i') }}</p>

                    <div class="mt-6">
                        <a href="{{ route('tags.edit', $tag) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                            Edytuj Tag
                        </a>
                        <a href="{{ route('tags.index') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                            Wróć do listy tagów
                        </a>
                    </div>

                    {{-- Opcjonalnie: Lista kursów, do których przypisany jest ten tag --}}
                    {{-- Aby to działało, musiałbyś dodać relację `courses()` w modelu `Tag` --}}
                    {{-- i załadować ją w `TagController@show` (np. `$tag->load('courses');`) --}}
                    {{--
                    <div class="mt-8">
                        <h4 class="text-xl font-semibold">Kursy z tym tagiem</h4>
                        <ul class="list-disc list-inside mt-2">
                            @forelse($tag->courses as $course)
                            <li><a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:underline">{{ $course->title }}</a></li>
                    @empty
                    <li>Brak kursów z tym tagiem.</li>
                    @endforelse
                    </ul>
                </div>
                --}}

            </div>
        </div>
    </div>
    </div>
</x-app-layout>