<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Edytuj kurs: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Zwróć uwagę na action i metodę PUT --}}
                    <form action="{{ route('courses.update', $course) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Pole Tytuł --}}
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tytuł</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700" value="{{ old('title', $course->title) }}" required>
                        </div>

                        {{-- Pole Opis --}}
                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Opis</label>
                            <textarea name="description" id="description" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700" required>{{ old('description', $course->description) }}</textarea>
                        </div>

                        {{-- Pole Data rozpoczęcia --}}
                        <div class="mt-4">
                            <label for="start_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Data rozpoczęcia</label>
                            <input type="date" name="start_date" id="start_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700" value="{{ old('start_date', $course->start_date) }}" required>
                        </div>

                        {{-- Pole Wybór Kategorii --}}
                        <div class="mt-4">
                            <label for="category_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Kategoria</label>
                            <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700" required>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if($category->id == old('category_id', $course->category_id)) selected @endif>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pole Wybór Tagów --}}
                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tagi</label>
                            @php
                            $courseTags = old('tags', $course->tags->pluck('id')->toArray());
                            @endphp
                            @foreach ($tags as $tag)
                            <div class="flex items-center mt-1">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700"
                                    @if(in_array($tag->id, $courseTags)) checked @endif>
                                <label for="tag_{{ $tag->id }}" class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $tag->name }}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Zaktualizuj kurs
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>