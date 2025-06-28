<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Tagi Kursów') }}
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
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex items-center justify-between mb-6">
                        {{-- Przycisk dodawania widoczny tylko dla moderatorów i adminów --}}
                        @if(in_array(auth()->user()->role, ['admin', 'moderator']))
                        <a href="{{ route('tags.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Dodaj Tag
                        </a>
                        @else
                        <div></div> {{-- Pusty div dla zachowania układu --}}
                        @endif
                        <form action="{{ route('tags.index') }}" method="GET">
                            <x-text-input type="text" name="search" placeholder="Szukaj tagów..." value="{{ request('search') }}" />
                            <x-primary-button class="ml-2">Szukaj</x-primary-button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nazwa</th>
                                    @if(in_array(auth()->user()->role, ['admin', 'moderator']))
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($tags as $tag)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $tag->name }}</td>
                                    {{-- Komórka z akcjami widoczna tylko dla moderatorów i adminów --}}
                                    @if(in_array(auth()->user()->role, ['admin', 'moderator']))
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('tags.edit', $tag) }}" class="text-indigo-600 hover:text-indigo-900">Edytuj</a>
                                        <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Czy na pewno chcesz usunąć ten tag?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Usuń</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Brak tagów.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>