<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert([ 
                [ 
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password' => bcrypt('admin123!@#'),
                    'role_id' => 1,
                    'status' => 2
                ],
            ]);

    }
}
