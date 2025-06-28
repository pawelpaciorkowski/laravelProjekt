<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Tagi Kursów') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showModal: false, modalAction: '', modalTitle: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Komunikaty --}}
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Przyciski i wyszukiwarka --}}
                    <div class="flex items-center justify-between mb-6">
                        @if(in_array(auth()->user()->role, ['admin', 'moderator']))
                        <a href="{{ route('tags.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Dodaj Tag
                        </a>
                        @endif
                        <form action="{{ route('tags.index') }}" method="GET" class="ml-auto">
                            <x-text-input type="text" name="search" placeholder="Szukaj tagów..." value="{{ request('search') }}" />
                            <x-primary-button class="ml-2">Szukaj</x-primary-button>
                        </form>
                    </div>

                    {{-- Tabela --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            {{-- ... (thead bez zmian) ... --}}
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($tags as $tag)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $tag->name }}</td>
                                    @if(in_array(auth()->user()->role, ['admin', 'moderator']))
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('tags.edit', $tag) }}" class="text-indigo-600 hover:text-indigo-900">Edytuj</a>

                                        <button x-on:click.prevent="$dispatch('open-modal', { name: 'confirm-tag-deletion', action: '{{ route('tags.destroy', $tag) }}', title: 'Czy na pewno chcesz usunąć tag {{ $tag->name }}?' })"
                                            class="ml-4 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                            Usuń
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                {{-- ... --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Paginacja --}}
                    @if ($tags->hasPages())
                    <div class="mt-4">{{ $tags->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
        <x-confirm-deletion-modal name="confirm-tag-deletion" />
    </div>
</x-app-layout>