<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [


        'gender' => 'female', //   FIRST TIME
        'name' => $faker->firstNameFemale, //   FIRST TIME



//        'gender' => 'male', //       SECOND TIME
//        'name' => $faker->firstNameMale, //       SECOND TIME

        'date_of_birth' => $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-18 years'),
        'description' => $faker->sentence($nbSentences = 5, $variableNBSentences = true),
        'latitude' => $faker->latitude(55.89, 55.6),
        'longitude' => $faker->longitude(37.14, 37.89),
    ];
});
