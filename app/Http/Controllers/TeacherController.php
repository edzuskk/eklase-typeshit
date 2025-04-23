<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function profile()
    {
        return view('teachers.profile', [
            'teacher' => auth()->user()->load('teacher')
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'subject' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = auth()->user();
        $teacher = $user->teacher;

        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($teacher->profile_picture) {
                Storage::delete($teacher->profile_picture);
            }
            // Store new picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $teacher->profile_picture = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $teacher->subject = $request->subject;

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $teacher->save();

        return redirect()->route('teacher.profile')->with('success', 'Profile updated successfully');
    }
}
