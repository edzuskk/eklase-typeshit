<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('name')->get();
        return view('teachers.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('teachers.subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects'
        ]);

        Subject::create($validated);
        return redirect()->route('teacher.subjects.index')
            ->with('success', 'Subject created successfully');
    }

    public function edit(Subject $subject)
    {
        return view('teachers.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id
        ]);

        $subject->update($validated);
        return redirect()->route('teacher.subjects.index')
            ->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('teacher.subjects.index')
            ->with('success', 'Subject deleted successfully');
    }
}