<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateProfilePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->hasFile('profile_picture')) {
        // Delete old image if exists
        if (auth()->user()->profile_picture) {
            Storage::disk('public')->delete(auth()->user()->profile_picture);
        }

        // Store new image
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        
        auth()->user()->update([
            'profile_picture' => $path
        ]);

        return back()->with('success', 'Profile picture updated successfully');
    }

    return back()->with('error', 'No image uploaded');
}
}