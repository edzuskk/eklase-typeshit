<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;

class TeacherStudentController extends Controller
{
    public function index(Request $request)
    {
        // Start with base query
        $query = User::where('role', User::ROLE_STUDENT);

        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
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

        // Get filtered results with relationships
        $students = $query->with(['student', 'grades'])
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        // Pass data to view
        return view('teachers.students', [
            'students' => $students,
            'search' => $request->search,
            'currentClass' => $request->class,
            'currentSubject' => $request->subject
        ]);
    }

    public function create()
    {
        return view('teachers.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'class' => 'required|string'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('password'), // Set default password
            'role' => User::ROLE_STUDENT
        ]);

        $user->student()->create([
            'class' => $validated['class']
        ]);

        return redirect()->route('teacher.students.index')
            ->with('success', 'Student created successfully');
    }

    public function edit(User $student)
    {
        return view('teachers.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'class' => 'required|string'
        ]);

        $student->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        $student->student()->update([
            'class' => $validated['class']
        ]);

        return redirect()->route('teacher.students.index')
            ->with('success', 'Student updated successfully');
    }

    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('teacher.students.index')
            ->with('success', 'Student deleted successfully');
    }

    public function deleteGrade(Grade $grade)
    {
        try {
            $grade->delete();
            
            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Grade deleted successfully'
                ]);
            }
            
            return back()->with('success', 'Grade deleted successfully');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Failed to delete grade'
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to delete grade']);
        }
    }
}