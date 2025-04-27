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

    public function update(Request $request, Grade $grade)
    {
        \Log::info('Grade Update Request', [
            'expectsJson' => $request->expectsJson(),
            'headers' => $request->headers->all(),
            'content_type' => $request->header('Content-Type'),
            'accept' => $request->header('Accept')
        ]);

        try {
            $validated = $request->validate([
                'grade' => 'required|integer|between:1,10'
            ]);

            $grade->update([
                'grade' => $validated['grade']
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Grade updated successfully',
                    'success' => true
                ]);
            }

            return back()->with('success', 'Grade updated successfully');

        } catch (\Exception $e) {
            \Log::error('Grade update error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Failed to update grade',
                    'error' => $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['grade' => 'Failed to update grade']);
        }
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
            ], 200, [
                'Content-Type' => 'application/json'
            ]);
        } catch (\Exception $e) {
            \Log::error('Grade creation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the grade'
            ], 500, [
                'Content-Type' => 'application/json'
            ]);
        }
    }
}