<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $ids=Shop::pluck('id');

        for ($i=0; $i < 3 ; $i++) {

           
            Category::create([
                'name'=>Str::random(10),
                'status' => 1,
                'shop_id'=>$ids[rand(0,count($ids)-1)]
            ]);

        }
    }
}
