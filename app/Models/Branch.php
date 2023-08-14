<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'assistant_branches');
    }

    public function teacher()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_branch');
    }


    public function scopeStatus($query)
    {
        $query->where('status', 1);
    }

    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }
}
