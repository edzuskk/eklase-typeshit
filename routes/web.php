<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/', function () {
    return view('index');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Teacher only routes
    Route::middleware(['role:teacher'])->group(function () {
        // Students management
        Route::resource('students', StudentController::class);
        
        // Grades management
        Route::resource('grades', GradeController::class);
        
        // Teacher profile
        Route::get('/teacher/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
        Route::put('/teacher/profile', [TeacherController::class, 'updateProfile'])->name('teacher.profile.update');
    });

    // Student only routes
    Route::middleware(['role:student'])->group(function () {
        // View grades
        Route::get('/my-grades', [GradeController::class, 'myGrades'])->name('grades.my');
        
        // Student profile
        Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');
        Route::put('/student/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    });
});
