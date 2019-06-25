<?php

use App\ExpenseType;
use Faker\Generator as Faker;

$factory->define(ExpenseType::class, function (Faker $faker) {
    return [
        'name' => (string)$faker->sentence(),
        'description' => (string)$faker->text()
    ];
});
