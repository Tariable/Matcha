<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    $gender = $faker->randomElement($array = array ('male', 'female'));
    return [
        'name' => $gender === 'male' ? $faker->firstNameMale : $faker->firstNameFemale,
        'date_of_birth' => $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-18 years'),
        'description' => $faker->sentence($nbSentences = 5, $variableNBSentences = true),
        'gender' => $gender,
        'current_latitude' => $faker->latitude(55.89, 55.6),
        'current_longitude' => $faker->longitude(37.14, 37.89),
        'rating' => $faker->numberBetween(40, 75),
        'notification' => true
    ];
});
