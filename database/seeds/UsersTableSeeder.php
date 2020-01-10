<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => '',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'api_token' => str_random(60),
            'role_id'   => 1,
        ]);
    }
}
