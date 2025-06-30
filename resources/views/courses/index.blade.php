<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Kursy') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showModal: false, modalAction: '', modalTitle: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Komunikat o sukcesie --}}
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Przycisk dodawania i wyszukiwarka --}}
                    <div class="flex items-center justify-between mb-6">
                        @if(in_array(auth()->user()->role, ['admin', 'moderator']))
                        <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Dodaj Kurs
                        </a>
                        @endif
                        <form action="{{ route('courses.index') }}" method="GET" class="ml-auto">
                            <x-text-input type="text" name="search" placeholder="Szukaj kursów..." value="{{ request('search') }}" />
                            <x-primary-button class="ml-2">
                                Szukaj
                            </x-primary-button>
                        </form>
                    </div>

                    {{-- Tabela z kursami --}}
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tytuł</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategoria</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data rozpoczęcia</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($courses as $course)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->category->name ?? 'Brak' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->start_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:text-blue-900">Pokaż</a>
                                    @if(in_array(auth()->user()->role, ['admin', 'moderator']))
                                    <a href="{{ route('courses.edit', $course) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">Edytuj</a>

                                    <button x-on:click.prevent="$dispatch('open-modal', { name: 'confirm-course-deletion', action: '{{ route('courses.destroy', $course) }}', title: 'Czy na pewno chcesz usunąć kurs: {{ addslashes($course->title) }}?' })"
                                        class="ml-4 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                        Usuń
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                    Brak kursów do wyświetlenia.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginacja --}}
                    <div class="mt-4">
                        {{ $courses->links() }}
                    </div>

                </div>
            </div>
        </div>

        <x-confirm-deletion-modal name="confirm-course-deletion" />
    </div>
</x-app-layout>