<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function scopeStatus($query)
    {
        $query->where('status', '1');
    }
}
