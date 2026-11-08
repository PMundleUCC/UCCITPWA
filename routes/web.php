<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Public page addresses and their views.
Route::view('/', 'home')->name('home');
Route::view('/directory', 'directory')->name('directory');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::view('/admissions', 'admissions')->name('admissions');
Route::view('/contact', 'contact')->name('contact');
