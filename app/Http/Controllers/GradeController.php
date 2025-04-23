<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::query()
            ->with(['student.user', 'subject']);

        // Filter by student name
        if ($request->has('student_name')) {
            $query->whereHas('student.user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student_name . '%');
            });
        }

        // Filter by subject
        if ($request->has('subject')) {
            $query->where('subject', $request->subject);
        }

        // Sort by date
        $query->orderBy('created_at', $request->sort ?? 'desc');

        $grades = $query->paginate(10)->withQueryString();

        return view('teachers.grades.index', [
            'grades' => $grades,
            'subjects' => Subject::pluck('name', 'id')
        ]);
    }

    public function create()
    {
        $students = Student::all();
        return view('teachers.grades.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'value' => 'required|numeric|min:0|max:100',
            'comments' => 'nullable|string|max:1000'
        ]);

        Grade::create($validated);

        return redirect()->route('teacher.grades.index')
            ->with('success', 'Grade added successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function studentGrades(Request $request)
    {
        $query = Grade::where('student_id', auth()->user()->student->id)
            ->with('subject');

        // Filter by subject
        if ($request->has('subject')) {
            $query->where('subject', $request->subject);
        }

        // Sort by date
        $query->orderBy('created_at', $request->sort ?? 'desc');

        $grades = $query->paginate(10)->withQueryString();

        return view('students.grades', [
            'grades' => $grades,
            'subjects' => Subject::pluck('name', 'id')
        ]);
    }
}
