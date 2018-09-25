<?php

use Illuminate\Database\Seeder;

/**
 * Class TodosTableSeeder
 */
class TodosTableSeeder extends Seeder
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
                factory(App\Todo::class, rand(3, 6))->create([
                    'user_id' => $user->id
                ]);
            }
        } else {
            factory(App\Todo::class, 20)->create();
        }
    }
}
