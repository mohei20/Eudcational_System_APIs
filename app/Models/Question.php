<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'type',
        'point',
        'image',
        'explanation',
        'exam_id'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function formateQuestionType($type)
    {
        switch ($type) {
            case 0:
                return 'Single Choice';
            case 1:
                return 'Multiple Choice';
            case 2:
                return 'T/F';
            default:
                break;
        }
    }
}
