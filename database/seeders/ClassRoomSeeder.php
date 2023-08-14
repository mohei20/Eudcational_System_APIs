<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Branch;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $branchesIds = Branch::pluck('id');
        $subjectsIds = Subject::pluck('id');
        $teachersIds = Teacher::pluck('id');

        for ($i = 0; $i < 50; $i++) {
            ClassRoom::create([
                'name' => $faker->name(),
                'price' => $faker->numberBetween(10, 200),
                'registration_deadline' => $faker->dateTime(),
                'start_date' => $faker->dateTime(),
                'max_capacity' => $faker->numberBetween(20, 150),
                'min_grade' => $faker->numberBetween(50, 70),
                'min_selected' => $faker->numberBetween(70, 150),
                'branch_id' => $branchesIds[rand(0, count($branchesIds) - 1)],
                'subject_id' => $subjectsIds[rand(0, count($subjectsIds) - 1)],
                'teacher_id' => $teachersIds[rand(0, count($teachersIds) - 1)]
            ]);
        }
    }
}
