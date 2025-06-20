<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request; // Upewnij się, że to jest zaimportowane

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pobieramy wszystkie kategorie z bazy i przekazujemy do widoku
        $categories = Category::paginate(10); // paginate dzieli wyniki na strony
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Zwracamy widok z formularzem dodawania nowej kategorii
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Walidacja danych z formularza
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255', // Pole wymagane, unikalne w tabeli 'categories', max 255 znaków
        ]);

        // Tworzenie nowej kategorii w bazie
        Category::create($validated);

        // Przekierowanie na listę kategorii z komunikatem o sukcesie
        return redirect()->route('categories.index')->with('success', 'Kategoria została pomyślnie dodana.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Zwracamy widok z formularzem edycji, przekazując do niego edytowaną kategorię
        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Walidacja danych
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
        ]);

        // Aktualizacja danych kategorii
        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategoria została pomyślnie zaktualizowana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Usunięcie kategorii
        // Zgodnie z wymaganiami, można by tu zaimplementować "miękkie usuwanie" (dezaktywację)
        // ale na razie robimy twarde usuwanie.
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategoria została usunięta.');
    }
}
