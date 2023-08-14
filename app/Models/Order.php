<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function student()
    {

        return $this->belongsTo(Student::class);
       
    }
    
    public function product(){
        return $this->belongsToMany(Product::class,'order_products')->withPivot('quantity')->withTimestamps();
    }
}
