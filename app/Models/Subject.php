<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'status',
    'image',
    'academic_year_id',
    'semester_id',
    'branch_id'
];
    protected $table = 'subjects';

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
