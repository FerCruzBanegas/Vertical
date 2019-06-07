<?php

use App\ProjectType;
use Faker\Generator as Faker;

$factory->define(ProjectType::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->text
    ];
});
