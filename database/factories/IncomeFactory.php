<?php

use App\Income;
use Faker\Generator as Faker;

$factory->define(Income::class, function (Faker $faker) {
    return [
        'title' => (string)$faker->sentence(),
        'date' => $faker->date(),
        'note' => (string)$faker->text(),
        'amount' => $faker->randomElement([1203.34, 3450.50, 2690.67]),
        'income_type_id' => rand(1, 60),
        'project_id' => rand(1, 60),
    ];
});
