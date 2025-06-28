<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Wyświetla listę użytkowników z wyszukiwarką.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = User::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        // Paginacja, aby lista była czytelna
        $users = $query->latest()->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Wyświetla formularz do tworzenia nowego użytkownika.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Zapisuje nowego użytkownika w bazie danych.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:user,admin,moderator'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Użytkownik został pomyślnie utworzony.');
    }

    /**
     * Wyświetla formularz do edycji użytkownika.
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Aktualizuje rolę użytkownika.
     */
    public function update(Request $request, User $user)
    {
        // Używamy Auth::id() zamiast auth()->id()
        if ($user->id === Auth::id() && $user->role === 'admin' && User::where('role', 'admin')->count() === 1) {
            return redirect()->route('users.index')->with('error', 'Nie możesz odebrać sobie uprawnień administratora, jeśli jesteś jedynym administratorem.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => 'required|string|in:user,admin,moderator',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }

    /**
     * "Usuwa" (dezaktywuje) użytkownika.
     */
    public function destroy(User $user)
    {
        // Używamy Auth::id() zamiast auth()->id()
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Nie możesz usunąć własnego konta z panelu administratora.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Użytkownik został pomyślnie zdezaktywowany.');
    }
}
