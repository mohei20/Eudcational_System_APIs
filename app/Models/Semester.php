<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'academic_year_id'
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }


    public function semesterNameFormat($semesterName)
    {
        switch ($semesterName) {
            case 1:
                return "الفصل الدراسى الاول";
            case 2:
                return "الفصل الدراسى الثانى";
            default:
                break;
        }
    }
}