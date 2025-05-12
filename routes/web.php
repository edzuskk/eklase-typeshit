<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherGradeController;
use App\Http\Controllers\TeacherStudentController; // Add this line

// Home and Auth routes
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Teacher routes
    Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        // Student management
        Route::controller(TeacherStudentController::class)->group(function () {
            Route::get('/students', 'index')->name('students.index');
            Route::get('/students/create', 'create')->name('students.create');
            Route::post('/students', 'store')->name('students.store');
            Route::get('/students/{student}/edit', 'edit')->name('students.edit');
            Route::put('/students/{student}', 'update')->name('students.update');
            Route::delete('/students/{student}', 'destroy')->name('students.destroy');
        });
        
        // Grades management
        Route::controller(GradeController::class)->group(function () {
            Route::get('/grades', 'index')->name('grades.index');
            Route::get('/grades/create', 'create')->name('grades.create');
            Route::post('/grades', 'store')->name('grades.store');
            Route::get('/grades/{grade}/edit', 'edit')->name('grades.edit');
            Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
            Route::delete('/grades/{grade}', [TeacherStudentController::class, 'deleteGrade'])
                ->name('grades.delete');
        });

        Route::get('/students/{student}/grades/create', [TeacherGradeController::class, 'create'])
            ->name('teacher.students.grades.create');
        Route::post('/students/{student}/grades', [TeacherGradeController::class, 'store'])
            ->name('teacher.students.grades.store');

        // Teacher profile routes
        Route::controller(TeacherController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::put('/profile', 'updateProfile')->name('profile.update');
            Route::post('/profile/picture', 'updateProfilePicture')->name('profile.picture.update');
        });
    });

    // Student routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        // Profile
        Route::controller(StudentController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::put('/profile', 'updateProfile')->name('profile.update');
        });
        
        // Grades
        Route::get('/grades', [GradeController::class, 'studentGrades'])->name('grades');
    });
});
