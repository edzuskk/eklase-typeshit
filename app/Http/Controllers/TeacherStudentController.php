<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;

class TeacherGradeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->where('role', 'student')
            ->with(['student', 'grades']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply class filter
        if ($request->filled('class')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('class', $request->class);
            });
        }

        // Apply subject filter
        if ($request->filled('subject')) {
            $query->whereHas('grades', function($q) use ($request) {
                $q->where('subject', $request->subject);
            });
        }

        $students = $query->latest()->paginate(10)
            ->withQueryString(); // This preserves the filter parameters in pagination links

        return view('teachers.students', compact('students'));
    }
}