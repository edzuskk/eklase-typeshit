<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create subjects
        $subjects = ['Mathematics', 'English', 'Science', 'History', 'Physical Education'];
        foreach ($subjects as $subject) {
            Subject::firstOrCreate(['name' => $subject]);
        }

        // Create teachers
        $teachers = [
            [
                'name' => 'John Smith',
                'email' => 'john@school.com',
                'subject' => 'Mathematics'
            ],
            [
                'name' => 'Mary Johnson',
                'email' => 'mary@school.com',
                'subject' => 'English'
            ]
        ];

        foreach ($teachers as $teacher) {
            $user = User::create([
                'name' => $teacher['name'],
                'email' => $teacher['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher'
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'subject' => $teacher['subject']
            ]);
        }

        // Create test account if needed
        if (!User::where('email', 'test@test.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@test.com',
                'password' => Hash::make('password'),
                'role' => 'teacher'
            ]);
        }
    }
}
