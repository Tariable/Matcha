<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $numberOfUsers = 2000;

        for ($i = 1; $i <= $numberOfUsers; $i++) {
            if ($i <= $numberOfUsers / 2) {
                factory(\App\Profile::class)->create(['name' => $faker->firstNameMale,
                    'gender' => 'male']);
                } else {
                factory(\App\Profile::class)->create(['name' => $faker->firstNameFemale,
                    'gender' => 'female']);
                }
        }
    }
}
