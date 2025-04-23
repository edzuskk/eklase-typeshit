<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject',
        'grade'
    ];

    /**
     * Get the student that owns the grade.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}