<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function student()
    // {
    //     return $this->hasMany(Student::class);
    // }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }


    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }


    public function FormatStatusAttendance($val)
    {
        switch ($val) {
            case '0':
                return "غايب";
            case '1':
                return "حاضر";
            case '2':
                return "حضور ودفع المال";
            default:
                # code...
                break;
        }
    }






}
