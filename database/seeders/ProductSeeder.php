<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids_t=Teacher::pluck('id');
        $ids_s=Subject::pluck('id');
        $ids_c=Category::pluck('id');
        for ($i=0; $i < 3 ; $i++) {
           
            Product::create([
                'name'=>Str::random(10),
                'image'=>Str::random(10),
                'description'=>Str::random(10),
                'price'=>rand(100,400),
                'quantity'=>rand(1,400),
                'status' => 1,
                'subject_id'=>$ids_s[rand(0,count($ids_s)-1)],
                'teacher_id'=>$ids_t[rand(0,count($ids_t)-1)],
                'category_id'=>$ids_c[rand(0,count($ids_c)-1)],

                
            ]);
            
            
        }
    }
}
