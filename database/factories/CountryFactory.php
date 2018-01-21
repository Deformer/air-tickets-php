<?php

//use Faker\Generator as Faker;

$factory->define(App\Country::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->country,
        'abbreviation' => $faker->countryCode
    ];
});
