<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;

class TeacherGradeController extends Controller
{
    public function create(User $student)
    {
        return view('teachers.grades.create', compact('student'));
    }

    public function store(Request $request, User $student)
    {
        try {
            $validated = $request->validate([
                'subject' => 'required|string',
                'grade' => 'required|integer|between:1,10',
            ]);

            $grade = new Grade([
                'subject' => $validated['subject'],
                'grade' => $validated['grade']
            ]);

            $student->grades()->save($grade);

            return response()->json([
                'success' => true,
                'message' => 'Grade added successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Grade creation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the grade'
            ], 500);
        }
    }
}