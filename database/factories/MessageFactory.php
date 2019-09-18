<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    $profileLimit = 1000;

    do {
        $from = rand(1, $profileLimit);
        $to = rand(1, $profileLimit);
    } while($to === $from);

    return [
        'from' => $from,
        'to' => $to,
        'content' => $faker->sentence
    ];
});
