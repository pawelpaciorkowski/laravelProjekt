<form action="{{ route('courses.store') }}" method="POST">
    @csrf

    {{-- Pole Tytuł --}}
    <div>
        <label for="title">Tytuł</label>
        <input type="text" name="title" id="title" required>
    </div>

    {{-- Pole Opis --}}
    <div class="mt-4">
        <label for="description">Opis</label>
        <textarea name="description" id="description" required></textarea>
    </div>

    {{-- Pole Data rozpoczęcia --}}
    <div class="mt-4">
        <label for="start_date">Data rozpoczęcia</label>
        <input type="date" name="start_date" id="start_date" required>
    </div>

    {{-- Pole Wybór Kategorii (Relacja one-to-many) --}}
    <div class="mt-4">
        <label for="category_id">Kategoria</label>
        <select name="category_id" id="category_id" required>
            <option value="">Wybierz kategorię</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Pole Wybór Tagów (Relacja many-to-many) --}}
    <div class="mt-4">
        <label>Tagi</label>
        @foreach ($tags as $tag)
        <div>
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}">
            <label for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        <button type="submit">Zapisz kurs</button>
    </div>
</form>