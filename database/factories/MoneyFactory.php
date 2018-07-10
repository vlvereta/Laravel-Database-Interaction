<?php

use App\Entity\Money;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Money::class, function (Faker $faker) {
    return [
    	'currency_id' => $faker->numberBetween(1, 5),
    	'amount' => $faker->randomFloat(6, 0, 799076),
    	'wallet_id' => $faker->numberBetween(1, 10)
    ];
});
