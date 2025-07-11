<x-app-layout>
    {{-- Nagłówek strony, który pojawi się w szarym pasku u góry --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dodaj nowy kurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Twój formularz jest tutaj --}}
                    <form action="{{ route('courses.store') }}" method="POST">
                        @csrf

                        {{-- Pole Tytuł --}}
                        <div>
                            <x-input-label for="title" :value="__('Tytuł')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Pole Opis --}}
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Opis')" />
                            <textarea name="description" id="description" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Pole Link do Wideo --}}
                        <div class="mt-4">
                            <x-input-label for="video_url" :value="__('Link do wideo (np. YouTube)')" />
                            <x-text-input id="video_url" class="block mt-1 w-full" type="text" name="video_url" :value="old('video_url')" placeholder="https://www.youtube.com/watch?v=..." />
                            <x-input-error :messages="$errors->get('video_url')" class="mt-2" />
                        </div>

                        {{-- Pole Data rozpoczęcia --}}
                        <div class="mt-4">
                            <x-input-label for="start_date" :value="__('Data rozpoczęcia')" />
                            <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        {{-- Pole Wybór Kategorii (Relacja one-to-many) --}}
                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Kategoria')" />
                            <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>
                                <option value="">Wybierz kategorię</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        {{-- Pole Wybór Tagów (Relacja many-to-many) --}}
                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tagi</label>
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($tags as $tag)
                                <label for="tag_{{ $tag->id }}" class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 cursor-pointer transition-colors">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700"
                                        {{ (is_array(old('tags')) && in_array($tag->id, old('tags'))) ? ' checked' : '' }}>
                                    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $tag->name }}</span>
                                </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-primary-button>
                                Zapisz kurs
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>