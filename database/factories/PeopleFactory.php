<?php

use App\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'name' => (string)$faker->name(),
        'surnames' => $faker->lastName(),
        'phone' => (string)$faker->e164PhoneNumber(),
        'address' => $faker->address()
    ];
});
