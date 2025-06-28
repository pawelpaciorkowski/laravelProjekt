<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Tagi') }}
        </h2>
    </x-slot>

    <div class="py-12">
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
                        <a href="{{ route('tags.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Dodaj Tag
                        </a>
                        <form action="{{ route('tags.index') }}" method="GET">
                            <x-text-input type="text" name="search" placeholder="Szukaj tagów..." value="{{ request('search') }}" />
                            <x-primary-button class="ml-2">
                                Szukaj
                            </x-primary-button>
                        </form>
                    </div>

                    {{-- Tabela z tagami --}}
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nazwa</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Akcje</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($tags as $tag)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tag->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('tags.edit', $tag) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Edytuj</a>
                                    <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 ml-4" onclick="return confirm('Czy na pewno chcesz usunąć ten tag?');">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                    Brak tagów do wyświetlenia.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginacja --}}
                    @if ($tags->hasPages())
                    <div class="mt-4">
                        {{ $tags->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>