<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            'Mathematics',
            'English',
            'Science',
            'History',
            'Physics',
        ];

        foreach ($subjects as $subject) {
            Subject::updateOrCreate(
                ['name' => $subject],
                ['name' => $subject]
            );
        }
    }
}