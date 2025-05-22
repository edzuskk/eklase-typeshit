<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Subject;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegister()
    {
        $roles = ['student', 'teacher'];
        $subjects = Subject::orderBy('name')->pluck('name'); // You can fetch this from database
        
        return view('auth.register', compact('roles', 'subjects'));
    }

public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => [
            'required',
            'string',
            'max:255',
            'regex:/^[\p{L}\s]+$/u'  // Updated regex to use Unicode property
        ],
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:student,teacher',
        'class' => 'required_if:role,student',
        'subject' => 'required_if:role,teacher'
    ], [
        'name.regex' => 'Name can only contain letters (including Latvian) and spaces',
        'class.required_if' => 'Class field is required for students',
        'subject.required_if' => 'Subject field is required for teachers'
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput();
    }

    DB::beginTransaction();
    
    try {
        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        // Create role-specific records
        if ($validated['role'] === 'student') {
            $user->student()->create([
                'class' => $validated['class']
            ]);
        } elseif ($validated['role'] === 'teacher') {
            $user->teacher()->create([
                'subject' => $validated['subject']
            ]);
        }

        DB::commit();
        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Registration successful!');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->withErrors(['error' => 'Registration failed. Please try again.']);
    }
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
