<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;

class TeacherGradeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')
            ->with(['student', 'grades']);

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by class
        if ($request->filled('class')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('class', $request->class);
            });
        }

        // Filter by subject grades
        if ($request->filled('subject')) {
            $query->whereHas('grades', function($q) use ($request) {
                $q->where('subject', $request->subject);
            });
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        return view('teachers.students', compact('students'));
    }
}