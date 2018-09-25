<?php

use Illuminate\Database\Seeder;

/**
 * Class TasksTableSeeder
 */
class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $todos = App\Todo::all();
        if (isset($todos)) {
            foreach ($todos as $todo) {
                factory(App\Task::class, rand(4, 8))->create([
                    'todo_id' => $todo->id
                ]);
            }
        } else {
            factory(App\Task::class, 50)->create();
        }
    }
}
