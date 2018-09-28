<?php

use Illuminate\Database\Seeder;

/**
 * Class TodoCommentsTableSeeder
 */
class TodoCommentsTableSeeder extends Seeder
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
                $todos = App\Todo::inRandomOrder()
                    ->limit(rand(5, 10))
                    ->get();

                if (isset($todos)) {
                    foreach ($todos as $todo) {
                        factory(App\TodoComment::class)->create([
                            'user_id' => $user->id,
                            'todo_id' => $todo->id
                        ]);
                    }
                } else {
                    factory(App\TodoComment::class)->create([
                        'user_id' => $user->id,
                    ]);
                }
            }
        } else {
            factory(App\TodoComment::class, 50)->create();
        }
    }
}
