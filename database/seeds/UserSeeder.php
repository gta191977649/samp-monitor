<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Episodes',
            'admin' => '1',
            'email' => 'episodes27@gmail.com',
            'password' => bcrypt('1234'),
        ]);
    }
}
