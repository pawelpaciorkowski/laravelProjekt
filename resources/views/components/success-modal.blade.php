@props(['name'])

<div
    x-data="{ show: false, title: '', message: '' }"
    x-show="show"
    x-on:open-modal.window="if ($event.detail.name === '{{ $name }}') { show = true; title = $event.detail.title; message = $event.detail.message; }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto">
    <div x-on:click="show = false" class="fixed inset-0 bg-black/50"></div>

    <div class="relative w-full max-w-lg p-6 mx-auto my-8 bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div class="p-6 text-center">
            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-green-100 dark:bg-green-800 rounded-full">
                <svg class="w-10 h-10 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 dark:text-white" x-text="title"></h2>
            <p class="mt-2 text-gray-600 dark:text-gray-300" x-text="message"></p>

            <div class="mt-8">
                <x-primary-button type="button" x-on:click="$dispatch('close')">
                    Wspaniale!
                </x-primary-button>
            </div>
        </div>
    </div>
</div>