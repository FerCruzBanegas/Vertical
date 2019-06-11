<?php

use App\Material;
use Faker\Generator as Faker;

$factory->define(Material::class, function (Faker $faker) {
    return [
        'name' => (string)$faker->sentence(),
        'unity' => $faker->randomElement(['amarro', 'barra', 'bolsa', 'caja', 'cajón', 'carga', 'dm³', 'fajo', 'fardo', 'g', 'galón', 'glb', 'ha', 'juego', 'kg', 'l', 'lata', 'lb', 'm', 'm²', 'm³', 'mm', 'perfil', 'pie', 'pie²', 'placa', 'plomo', 'pqte', 'pto', 'pza', 'resma', 'rollo', 't', 'tubo', 'turril', 'unds']),
        'description' => (string)$faker->text(),
        'price' => $faker->randomElement([1203.34, 3450.50, 2690.67]),
        'category_id' => rand(1, 60),
    ];
});
