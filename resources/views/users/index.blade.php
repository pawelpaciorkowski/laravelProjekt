<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Zarządzanie Użytkownikami') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showModal: false, modalAction: '', modalTitle: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Komunikaty o sukcesie / błędzie --}}
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex items-center justify-between mb-6">
                        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Dodaj Użytkownika
                        </a>
                        <form action="{{ route('users.index') }}" method="GET">
                            <x-text-input type="text" name="search" placeholder="Szukaj użytkowników..." value="{{ request('search') }}" />
                            <x-primary-button class="ml-2">Szukaj</x-primary-button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Imię i nazwisko</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rola</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Akcje</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($users as $user)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $user->role }}</td>
                                    <td class="px-4 py-2 text-sm text-right">
                                        <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Edytuj</a>

                                        <button x-on:click.prevent="$dispatch('open-modal', { name: 'confirm-user-deletion', action: '{{ route('users.destroy', $user) }}', title: 'Czy na pewno chcesz zdezaktywować użytkownika {{ $user->name }}?' })"
                                            class="ml-4 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                            Dezaktywuj
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-2 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Brak użytkowników.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($users->hasPages())
                    <div class="mt-4">{{ $users->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
        <x-confirm-deletion-modal name="confirm-user-deletion" />
    </div>
</x-app-layout>