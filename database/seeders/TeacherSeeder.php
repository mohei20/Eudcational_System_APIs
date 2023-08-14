<?php

namespace Database\Seeders;

use App\Models\Branch;
use Faker\Factory;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $branchId = Branch::pluck('id');
        for ($i = 0; $i < 10; $i++) {
            $teacher = Teacher::create([
                'name' => $faker->name(),
                'nick_name' => $faker->unique()->lastName(),
                'phone_number' => '01' . $faker->numberBetween(111111111, 999999999),
                'avatar' => 'avatar.png'
            ]);
            $teacher->branch()->attach($branchId[rand(0, count($branchId) - 1)]);
        }
    }
}