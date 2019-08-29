<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Preference;
use Faker\Generator as Faker;

$factory->define(Preference::class, function (Faker $faker) {
    $tags = array();
    for ($i = 0; $i < $faker->numberBetween(2, 5); $i++) {
        $tags[] = $faker->numberBetween(1, 6);
    }
    return [
        'lowerAge' => $faker->numberBetween(18, 50),
        'upperAge' => $faker->numberBetween(21, 53),
        'distance' => $faker->numberBetween(3, 100),
        'pref_sex' => $faker->randomElement($array = array ('male', 'female', 'bi')),
        'tags' => serialize(array_unique($tags)),
    ];
});
