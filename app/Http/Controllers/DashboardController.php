<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Dane wspólne lub dla admina/moderatora
        $userCount = User::count();
        $courseCount = Course::count();
        $categoryCount = Category::count();
        $tagCount = Tag::count();
        $myCourses = $user->enrollments()->with('category')->latest()->get();

        // Dane specyficzne dla roli 'user'
        $discoverCourses = collect();
        if ($user->role === 'user') {
            // Pobierz ID kursów, na które użytkownik jest już zapisany
            $enrolledCourseIds = $myCourses->pluck('id');

            // Pobierz najnowsze kursy, na które użytkownik NIE jest zapisany
            $discoverCourses = Course::whereNotIn('id', $enrolledCourseIds)
                ->with('category')
                ->latest()
                ->take(5)
                ->get();
        }

        // Zawsze pobieramy ostatnio dodane kursy dla panelu admina/moderatora
        $recentCourses = Course::with('category')->latest()->take(5)->get();

        return view('dashboard', compact(
            'user',
            'userCount',
            'courseCount',
            'categoryCount',
            'tagCount',
            'recentCourses',
            'myCourses',
            'discoverCourses'
        ));
    }
}
