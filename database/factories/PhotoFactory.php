<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Photo;
use Faker\Generator as Faker;

$factory->define(Photo::class, function (Faker $faker) {

    return [
        'path' => $faker->image('public/storage/photos', 480, 640, 'people'),
    ];
});
