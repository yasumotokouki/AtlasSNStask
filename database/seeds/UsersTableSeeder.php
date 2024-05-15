<<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        \DB::table('users')->insert([

        'username' => 'kouki',
            'mail' => 'kouki@example.com',
            'password' => 'kouki0630'
        ]);
    }
}
