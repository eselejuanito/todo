<?php

use Faker\Generator as Faker;

$factory->define(App\TodoComment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'todo_id' => function () {
            return factory(App\Todo::class)->create()->id;
        },
        'comment' => $faker->text,
        'created_at' => now(),
    ];
});
