<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View; // Dodaj ten import

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Tag::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $tags = $query->paginate(10);

        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ROZBUDOWANA WALIDACJA
        $validated = $request->validate([
            'name' => [
                'required',              // Pole jest wymagane
                'string',                // Musi być ciągiem znaków
                'unique:tags,name',      // Nazwa musi być unikalna
                'min:2',                 // Minimalna długość to 2 znaki
                'max:50',                // Maksymalna długość to 50 znaków
                'alpha_dash'             // Może zawierać tylko znaki alfanumeryczne, myślniki i podkreślenia
            ],
        ]);

        Tag::create($validated);

        return redirect()->route('tags.index')->with('success', 'Tag został pomyślnie dodany.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): View
    {
        // Ta metoda może być prosta, jeśli nie planujesz osobnych stron dla pojedynczych tagów.
        // Jeśli tak, możesz załadować powiązane kursy: $tag->load('courses');
        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag): View
    {
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        // ROZBUDOWANA WALIDACJA PRZY AKTUALIZACJI
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'alpha_dash',
                // Upewniamy się, że nazwa jest unikalna, ignorując obecny rekord
                'unique:tags,name,' . $tag->id,
            ],
        ]);

        $tag->update($validated);

        return redirect()->route('tags.index')->with('success', 'Tag został pomyślnie zaktualizowany.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Obecnie wykonuje twarde usuwanie.
        // Jeśli będziesz implementować miękkie usuwanie, będzie to wymagało zmian w modelu Tag
        // i odpowiedniego odświeżenia migracji (co już omówiliśmy).
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag został usunięty.');
    }
}
