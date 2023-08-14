<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function branch()
    {
        return $this->belongsToMany(Branch::class, 'teacher_branch');
    }

}
