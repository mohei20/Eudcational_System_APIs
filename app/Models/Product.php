<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function order(){
        return $this->belongsToMany(Order::class,'order_products')->withPivot('quantity')->withTimestamps();
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

}
