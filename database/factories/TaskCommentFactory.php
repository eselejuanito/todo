<?php

use Faker\Generator as Faker;

$factory->define(App\TaskComment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'task_id' => function () {
            return factory(App\Task::class)->create()->id;
        },
        'comment' => $faker->text,
        'created_at' => now(),
    ];
});
