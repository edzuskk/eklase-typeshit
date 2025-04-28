<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            'Mathematics',
            'English',
            'Science',
            'History',
            'Physics',
            'Chemistry',
            'Biology'
        ];

        foreach ($subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}