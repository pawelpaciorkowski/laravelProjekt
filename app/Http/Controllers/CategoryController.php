<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Category::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->paginate(10);

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
        // ROZBUDOWANA WALIDACJA
        $validated = $request->validate([
            'name' => [
                'required',                // Pole jest wymagane
                'string',                  // Musi być ciągiem znaków
                'unique:categories,name',  // Nazwa musi być unikalna w tabeli categories
                'min:3',                   // Minimalna długość to 3 znaki
                'max:100',                 // Maksymalna długość to 100 znaków
                'not_regex:/[#@!$%^&*()]/' // Nie może zawierać niektórych znaków specjalnych
            ],
            'description' => 'nullable|string|max:255',
        ]);

        Category::create($validated);

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
        // ROZBUDOWANA WALIDACJA PRZY AKTUALIZACJI
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'not_regex:/[#@!$%^&*()]/',
                'unique:categories,name,' . $category->id,
            ],
            'description' => 'nullable|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategoria została pomyślnie zaktualizowana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategoria została usunięta.');
    }
}
