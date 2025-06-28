<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Szczegóły kursu: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-semibold">{{ $course->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Kategoria: {{ $course->category->name }}</p>
                    <p class="text-sm text-gray-500">Data rozpoczęcia: {{ $course->start_date }}</p>

                    <div class="mt-4">
                        @foreach($course->tags as $tag)
                        <span class="inline-block bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-200 mr-2 mb-2">#{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    <p class="mt-6">{{ $course->description }}</p>

                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        {{-- Logika przycisków Zapisz/Wypisz --}}
                        @if(Auth::user()->enrollments->contains($course))
                        {{-- Użytkownik jest już zapisany --}}
                        <form action="{{ route('courses.unenroll', $course) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                                Wypisz się z kursu
                            </button>
                        </form>
                        @else
                        {{-- Użytkownik nie jest zapisany --}}
                        <form action="{{ route('courses.enroll', $course) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                                Zapisz się na kurs
                            </button>
                        </form>
                        @endif
                    </div>

                    <div class="mt-8">
                        <h4 class="text-xl font-semibold">Uczestnicy ({{ $course->participants->count() }})</h4>
                        <ul class="list-disc list-inside mt-2">
                            @forelse($course->participants as $participant)
                            <li>{{ $participant->name }}</li>
                            @empty
                            <li>Brak zapisanych uczestników.</li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>