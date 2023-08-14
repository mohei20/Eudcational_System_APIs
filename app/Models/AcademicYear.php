<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicYear extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'year',
        'branch_id'
    ];

    public function yearNameFormat($year, $Name)
    {
        switch ($Name) {
            case 1:
                return $year . " - الصف الاول الثانوى";
            case 2:
                return  $year . " - الصف الثانى الثانوى";
            case 3:
                return  $year . " - الصف الثالث الثانوى";
            default:
                break;
        }
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}