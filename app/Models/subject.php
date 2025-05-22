<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Subject extends Model
{
    protected $fillable = ['name'];

    /**
     * Get list of subjects as array
     */
    public static function getList(): array
    {
        return [
            'Mathematics',
            'English',
            'Science',
            'History',
            'Physics',
            'Chemistry',
            'Biology'
        ];
    }

    /**
     * Get subjects for dropdown/select
     */
    public static function pluck(string $value = 'name', string $key = 'id'): Collection
    {
        return collect(self::getList())->map(function($subject, $index) {
            return [
                'id' => $index + 1,
                'name' => $subject
            ];
        })->pluck($value, $key);
    }
}
