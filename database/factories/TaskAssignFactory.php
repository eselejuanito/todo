<?php

use Faker\Generator as Faker;

$factory->define(App\TaskAssigned::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'task_id' => function () {
            return factory(App\Task::class)->create()->id;
        },
        'created_at' => now(),
    ];
});
