<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Wyświetla listę wszystkich kursów z wyszukiwarką i paginacją.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Rozpoczynamy budowę zapytania, od razu ładując relację 'category',
        // aby uniknąć problemu N+1 zapytań w widoku.
        $query = Course::with('category');

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        $courses = $query->latest()->paginate(10); // Sortujemy od najnowszych i dzielimy na strony

        return view('courses.index', compact('courses'));
    }

    /**
     * Pokazuje formularz do tworzenia nowego kursu.
     * Przekazuje do widoku wszystkie kategorie i tagi do wyboru.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('courses.create', compact('categories', 'tags'));
    }

    /**
     * Zapisuje nowy kurs w bazie danych na podstawie danych z formularza.
     */
    public function store(Request $request)
    {
        // Walidacja - tu spełniasz wymóg o min. 5 regułach!
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'category_id' => 'required|integer|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id', // Walidacja każdego ID w tablicy
        ]);

        $course = Course::create($validated);

        // Przypisanie tagów do kursu (relacja many-to-many)
        if ($request->has('tags')) {
            $course->tags()->attach($request->tags);
        }

        return redirect()->route('courses.index')->with('success', 'Kurs dodany pomyślnie.');
    }

    /**
     * Wyświetla szczegóły pojedynczego kursu.
     */
    public function show(Course $course)
    {
        // Załaduj relacje, aby były dostępne w widoku (szczególnie przydatne, jeśli nie ma eager loading)
        $course->load('category', 'tags', 'participants');
        return view('courses.show', compact('course'));
    }

    /**
     * Pokazuje formularz do edycji istniejącego kursu.
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('courses.edit', compact('course', 'categories', 'tags'));
    }

    /**
     * Aktualizuje istniejący kurs w bazie danych.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'category_id' => 'required|integer|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
        ]);

        $course->update($validated);

        // Używamy sync() do aktualizacji relacji many-to-many.
        // Usunie stare powiązania i doda nowe w jednym kroku.
        // `?? []` zapewnia, że przekazujemy pustą tablicę, jeśli żadne tagi nie zostały zaznaczone.
        $course->tags()->sync($request->tags ?? []);

        return redirect()->route('courses.index')->with('success', 'Kurs zaktualizowany pomyślnie.');
    }

    /**
     * Usuwa kurs z bazy danych.
     */
    public function destroy(Course $course)
    {
        // Dzięki onDelete('cascade') w migracji, usunięcie kursu
        // automatycznie usunie powiązania w tabelach pivot.
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Kurs usunięty pomyślnie.');
    }
    /**
     * Zapisuje zalogowanego użytkownika na kurs.
     */
    public function enroll(Course $course)
    {
        // Używamy metody attach, aby dodać wpis do tabeli pośredniej
        // unikając duplikatów.
        $course->participants()->syncWithoutDetaching([Auth::id()]);

        return back()->with('success', 'Zostałeś pomyślnie zapisany na kurs.');
    }

    /**
     * Wypisuje zalogowanego użytkownika z kursu.
     */
    public function unenroll(Course $course)
    {
        // Używamy metody detach, aby usunąć wpis z tabeli pośredniej.
        $course->participants()->detach(Auth::id());

        return back()->with('success', 'Zostałeś wypisany z kursu.');
    }
}
