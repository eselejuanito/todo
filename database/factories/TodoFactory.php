<?php

use Faker\Generator as Faker;

$factory->define(App\Todo::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text,
        'created_at' => now(),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
