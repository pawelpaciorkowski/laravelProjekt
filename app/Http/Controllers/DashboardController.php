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
    /**
     * Display the application dashboard.
     */
    public function index(): View
    {
        $userCount = User::count();
        $courseCount = Course::count();
        $categoryCount = Category::count();
        $tagCount = Tag::count();

        $recentCourses = Course::with('category')->latest()->take(5)->get();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $myCourses = $user->enrollments()->with('category')->latest()->get();


        return view('dashboard', compact(
            'userCount',
            'courseCount',
            'categoryCount',
            'tagCount',
            'recentCourses',
            'myCourses'
        ));
    }
}
