@props(['name'])

<div
    x-data="{ show: false, action: '', title: '' }"
    x-show="show"
    x-on:open-modal.window="if ($event.detail.name === '{{ $name }}') { show = true; action = $event.detail.action; title = $event.detail.title; }"
    x-on:close-modal.window="if ($event.detail.name === '{{ $name }}') { show = false }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto">
    <div x-on:click="show = false" class="fixed inset-0 bg-black/50"></div>

    <div class="relative w-full max-w-lg p-6 mx-auto my-8 bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <form method="post" :action="action" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" x-text="title">
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Tej operacji nie będzie można cofnąć. Czy na pewno chcesz kontynuować?
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    {{ __('Anuluj') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Potwierdź usunięcie') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</div>