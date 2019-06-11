<?php

use App\IncomeType;
use Faker\Generator as Faker;

$factory->define(IncomeType::class, function (Faker $faker) {
    return [
        'name' => (string)$faker->sentence(),
        'description' => (string)$faker->text()
    ];
});
