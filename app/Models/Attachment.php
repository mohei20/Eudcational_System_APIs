<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'class_room_id'
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }
}
