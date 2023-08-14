<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;


class ExamResult extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function examDateFormate($examDate)
    {
        $date = new DateTime($examDate);
        return $date->format('Y-m-d H:i');
    }

}
