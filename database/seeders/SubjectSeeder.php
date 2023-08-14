<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Semester;
use App\Models\AcademicYear;
use App\Models\Branch;
use App\Models\Subject;
use App\Models\Teacher;

use function PHPSTORM_META\map;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $academicYearsIds = AcademicYear::pluck('id');
        $semestersIds = Semester::pluck('id');
        $BranchId = Branch::pluck('id');

        for ($i = 0; $i < 20; $i++) {
            Subject::create([
                'name' => $faker->sentence(2),
                'status' => '1',
                'image' => '1.jpg',
                'branch_id' => $BranchId->random(),
                'academic_year_id' => $academicYearsIds[rand(0, count($academicYearsIds) - 1)],
                'semester_id' => $semestersIds[rand(0, count($semestersIds) - 1)],
            ]);
        }
    }
}
