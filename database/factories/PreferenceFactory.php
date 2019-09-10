<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Preference;
use Faker\Generator as Faker;

$factory->define(Preference::class, function (Faker $faker) {

    $lowerAge = $faker->numberBetween(18, 50);

    return [
        'lowerAge' => $lowerAge,
        'upperAge' => $faker->numberBetween($lowerAge + 3, 53),
        'distance' => $faker->numberBetween(3, 100),
        'sex' => $faker->randomElement($array = array ('male', 'female', '%ale')),
    ];
});
