<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Like;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'partner_id' => 2001,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
