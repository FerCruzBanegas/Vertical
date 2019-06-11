<?php

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => (string)$faker->sentence(),
        'comments' => (string)$faker->text(),
        'start_date' => $faker->date(),
        'project_types_id' => rand(1, 60),
    ];
});
