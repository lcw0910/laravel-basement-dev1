<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    return [
        'order_no'      => $faker->unique()->randomNumber(4),
        'product_no'    => $faker->randomNumber(5)
    ];
});
