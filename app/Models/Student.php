<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nisn',
        'name',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'phone',
        'address',
        'parent_name',
        'parent_phone',
        'class_id',
        'status',
        'photo',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function major()
    {
        return $this->hasOneThrough(Major::class, SchoolClass::class, 'id', 'id', 'class_id', 'major_id');
    }
}

