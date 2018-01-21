<?php

//use Faker\Generator as Faker;

$factory->define(App\City::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city
    ];
});
