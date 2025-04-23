<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::where('role', 'student')
            ->with('student')
            ->latest()
            ->paginate(10);

        return view('teachers.students', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teachers.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'class' => 'required|string|in:10A,10B,10C'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student'
        ]);

        $user->student()->create([
            'class' => $validated['class']
        ]);

        return redirect()
            ->route('teacher.students.index')
            ->with('success', 'Student created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student)
    {
        return view('teachers.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($student->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'class' => 'required|string|in:10A,10B,10C'
        ]);

        $student->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        if ($validated['password']) {
            $student->update(['password' => Hash::make($validated['password'])]);
        }

        $student->student->update(['class' => $validated['class']]);

        return redirect()
            ->route('teacher.students.index')
            ->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Update the profile of the authenticated user.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        if (isset($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        return back()->with('success', 'Profile updated successfully');
    }

    public function profile()
    {
        return view('students.profile', [
            'student' => auth()->user()->load('student')
        ]);
    }
}
