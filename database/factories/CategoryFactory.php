<?php

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->text
    ];
});
//https://serverfault.com/questions/611732/email-sent-from-my-server-shows-up-as-spam