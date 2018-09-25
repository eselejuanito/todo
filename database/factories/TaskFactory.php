<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text,
        'created_at' => now(),
        'todo_id' => function () {
            return factory(App\Todo::class)->create()->id;
        }
    ];
});
