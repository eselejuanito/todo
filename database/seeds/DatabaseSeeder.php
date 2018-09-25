<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() === 'production') {
            exit('I just stopped you getting fired.');
        }

        // Disable mass-assignment protection with Laravel
        Eloquent::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        $tables = [
            'users',
            'todos'
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $this->call(UsersTableSeeder::class);
        $this->call(TodosTableSeeder::class);
        $this->call(TasksTableSeeder::class);
    }
}
