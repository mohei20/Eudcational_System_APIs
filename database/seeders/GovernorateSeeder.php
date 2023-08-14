<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $multipleGovernorate = [
            ['name' => 'الغربية'],
            ['name' => 'الإسكندرية'],
            ['name' => 'الإسماعيلية'],
            ['name' => 'كفر الشيخ'],
            ['name' => 'أسوان'],
            ['name' => 'أسيوط'],
            ['name' => 'الأقصر'],
            ['name' => 'الوادي الجديد'],
            ['name' => 'شمال سيناء'],
            ['name' => 'البحيرة'],
            ['name' => 'بني سويف'],
            ['name' => 'بورسعيد'],
            ['name' => 'البحر الأحمر'],
            ['name' => 'الجيزة'],
            ['name' => 'الدقهلية'],
            ['name' => 'جنوب سيناء'],
            ['name' => 'دمياط'],
            ['name' => 'سوهاج'],
            ['name' => 'السويس'],
            ['name' => 'الشرقية'],
            ['name' => 'الفيوم'],
            ['name' => 'القاهرة'],
            ['name' => 'القليوبية'],
            ['name' => 'قنا'],
            ['name' => 'مطروح'],
            ['name' => 'المنوفية'],
            ['name' => 'المنيا'],
        ];

        Governorate::insert($multipleGovernorate);
    }
}
