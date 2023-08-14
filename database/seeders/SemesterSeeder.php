<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\AcademicYear;
use App\Models\Semester;



class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $academicYearIds = AcademicYear::pluck('id');

        for ($i = 0; $i < 10; $i++) {
            Semester::create([
                'name' => rand(1, 2),
                'academic_year_id' => $academicYearIds[rand(0, count($academicYearIds) - 1)]
            ]);
        }
    }
}