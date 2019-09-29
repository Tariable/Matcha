<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {

    $desc = [
        'On our first date i`ll cut out our names on a tree. It`s the most romantic way to show you i`ve got a knife.',
        'My mom says i`m handsome',
        'Rich, attractive and perspective - not a full list of properties that i have no connection with',
        'If you have 2 kidneys swipe right',
        'Kak tebe takoe, Elon Musk?',
        'There are not enough alcohol in whole Universe to get me drunk',
        'If you believe that the Earth is flat i will drop you from the very edge of it',
        'The only dream i have is to become a Hokage',
        'Just a simple bushman with no future',
        'I have come here to f**k you and chew bubblegum. And i`m out of bubblegum',
        'I`ve written my own malloc and still have no job',
        'Let`s just fly away from here together?',
        'Why don`t you get a job finally?',
        'I can open a bottle of beer with my own teeth',
        'Graduated from Institute of Autism',
        'Is there anything better than a B. U. Alexandrov glazed curd???',
        'My ancestors are smiling at me, imperial... Can you say the same?',
        'I`ve read "War and Peace" in original',
        'It`s a trap!',
        'While u`re waiting for your boyfriend to get from work, I`m waiting for him to get from shower',
    ];

    return [
        'date_of_birth' => $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-18 years'),
        'description' => $desc[$faker->numberBetween(0, 19)],
        'latitude' => $faker->latitude(55.89, 55.6),
        'longitude' => $faker->longitude(37.14, 37.89),
    ];
});
