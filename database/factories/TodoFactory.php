<?php

use Faker\Generator as Faker;

$factory->define(App\Todo::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->text,
        'created_at' => now(),
        'target_date' => $faker->dateTimeBetween('now', '30 days'),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
