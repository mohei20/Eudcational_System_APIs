<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'day',
        'from',
        'to',
        'class_room_id'
    ];


    public function formatHoursAndMinutes($dateString)
    {
        $date = new DateTime($dateString);
        return $date->format('H:i');
    }

    public function dayNameFormate($day)
    {
        switch ($day) {
            case 1:
                return 'السبت';
            case 2:
                return 'الأحد';
            case 3:
                return 'الأثنين';
            case 4:
                return 'الثلاثاء';
            case 5:
                return 'الأربعاء';
            case 6:
                return 'الخميس';
            case 7:
                return 'الجمعه';
            default:
                break;
        }
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'appointment_id');
    }
}
