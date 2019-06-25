<?php

use App\Expense;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'title' => (string)$faker->sentence(),
        'payment' => $faker->randomElement(['Tarjeta', 'Efectivo', 'Cheque', 'Credito', 'Transferencia']),
        'date' => $faker->date(),
        'note' => (string)$faker->text(),
        'amount' => $faker->randomElement([1203.34, 3450.50, 2690.67]),
        'expense_type_id' => rand(1, 60),
        'project_id' => rand(1, 60),
    ];
});
