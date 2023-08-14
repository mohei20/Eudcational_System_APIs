<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'status',
        'type',
        'class_room_id'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function examResult()
    {
        return $this->hasMany(ExamResult::class);
    }
    public function examDateFormate($examDate)
    {
        $date = new DateTime($examDate);
        return $date->format('Y-m-d H:i');
    }

    public function scopeStatus($query)
    {
        $query->where('status', '1');
    }

    public function scopeType($query)
    {
        $query->where('status', '1');
    }

}
