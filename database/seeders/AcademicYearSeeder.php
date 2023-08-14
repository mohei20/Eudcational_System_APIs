<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Branch;
use App\Models\AcademicYear;


class AcademicYearSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        $BranchesIds = Branch::pluck('id');

        for ($i = 0; $i < 10; $i++) {
            AcademicYear::create([
                'name' => rand(1, 3),
                'year' => $faker->year(),
                'branch_id' => $BranchesIds[rand(0, count($BranchesIds)-1)]
            ]);
        }
    }
}