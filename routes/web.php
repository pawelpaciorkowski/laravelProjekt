<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController; // Dodaj ten import!

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Trasa do własnego profilu
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Trasy zasobów dla poszczególnych modułów
    Route::resource('categories', CategoryController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('users', UserController::class)->only(['index', 'show']);
    Route::resource('tags', TagController::class); // Dodaj tę linię!

    // Trasy zapisu/wypisu na kurs
    Route::post('courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('courses/{course}/unenroll', [CourseController::class, 'unenroll'])->name('courses.unenroll');
});

require __DIR__ . '/auth.php';
