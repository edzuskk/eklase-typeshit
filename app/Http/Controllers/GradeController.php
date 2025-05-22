<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::query()
            ->with(['student'])
            ->when($request->filled('student_name'), function($q) use ($request) {
                $q->whereHas('student', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->student_name . '%');
                });
            })
            ->when($request->filled('subject'), function($q) use ($request) {
                $q->where('subject', $request->subject);
            })
            ->orderBy('created_at', $request->input('sort', 'desc'));

        $grades = $query->paginate(10)->withQueryString();
        $subjects = Subject::getAll();
        dd($subjects);
 
        return view('students.grades', [
            'grades' => $grades,
            'subjects' => $subjects,
        ]);
    }

    public function create()
    {
        $students = Student::all();
        return view('teachers.grades.create', compact('students'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|exists:users,id',
                'subject' => 'required|string',
                'grade' => 'required|integer|between:1,10'
            ]);

            // Get or create subject
            $subject = Subject::firstOrCreate(['name' => $validated['subject']]);
            
            // Check if grade already exists for this student/subject
            $existingGrade = Grade::where('student_id', $validated['student_id'])
                ->where('subject_id', $subject->id)
                ->first();

            if ($existingGrade) {
                throw new \Exception('Grade already exists for this subject');
            }

            $grade = Grade::create([
                'student_id' => $validated['student_id'],
                'subject_id' => $subject->id,
                'grade' => $validated['grade']
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Grade added successfully',
                    'grade' => $grade->load(['subject', 'student'])
                ]);
            }

            return back()->with('success', 'Grade added successfully');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, Grade $grade)
    {
        try {
            $validated = $request->validate([
                'grade' => 'required|integer|between:1,10'
            ]);

            $grade->update($validated);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Grade updated successfully'
                ]);
            }

            return back()->with('success', 'Grade updated successfully');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => 'Failed to update grade']);
        }
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
