<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade_level',
        'major_id',
        'homeroom_teacher_id',
        'academic_year',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'grade_level' => 'integer',
        'capacity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}

