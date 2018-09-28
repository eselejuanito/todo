<?php

use Illuminate\Database\Seeder;

/**
 * Class TaskAssignTableSeeder
 */
class TaskAssignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();
        if (isset($users)) {
            foreach ($users as $user) {
                $tasks = App\Task::inRandomOrder()
                    ->limit(rand(5, 10))
                    ->get();

                if (isset($tasks)) {
                    foreach ($tasks as $task) {
                        factory(App\TaskAssigned::class)->create([
                            'user_id' => $user->id,
                            'task_id' => $task->id
                        ]);
                    }
                } else {
                    factory(App\TaskAssigned::class)->create([
                        'user_id' => $user->id,
                    ]);
                }
            }
        } else {
            factory(App\TaskAssigned::class, 50)->create();
        }
    }
}
