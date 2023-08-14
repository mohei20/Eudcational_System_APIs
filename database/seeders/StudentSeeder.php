<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Student;
use App\Models\Governorate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $govId = Governorate::pluck('id');
        $acedemicYear = [1,2,3];
        $division = ['1','2','3','4','5'];




        for ($i=0; $i < 300; $i++) {
            $sudents[] = [
                'f_name' => $faker->firstName(),
                'm_name' => $faker->lastName(),
                'l_name' => $faker->lastName(),
                'phone_number' => $faker->phoneNumber(),
                'guardian_number' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('123456'),
                'year' => $faker->year(),
                'month' => $faker->month(),
                'day' => $faker->dayOfMonth(),
                'acedemic_year' => $acedemicYear[array_rand($acedemicYear)],
                'division' => $division[array_rand($division)],
                'national_id_card' => 'national_id_card.jpg',
                'governorate_id' => $govId->random()
            ];
        }

        $chuncks = array_chunk($sudents, 100);
        foreach ($chuncks as $chunck) {
            Student::insert($chunck);
        }
    }
}