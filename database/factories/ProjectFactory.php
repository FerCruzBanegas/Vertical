<?php

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->sentence,
        'comments' => $faker->text,
        'star_date' => $faker->date,
        'project_types_id' => function () {
            return factory(App\ProjectType::class)->create()->id;
        }
    ];
});
