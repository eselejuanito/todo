<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->text,
        'status' => $faker->randomElement(App\Task::STATUS),
        'created_at' => now(),
        'todo_id' => function () {
            return factory(App\Todo::class)->create()->id;
        }
    ];
});
