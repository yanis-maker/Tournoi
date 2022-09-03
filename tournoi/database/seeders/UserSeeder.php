<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
           'email' => 'ryan.bengoufa@aol.com',
           'username' => 'ryan',
           'password' => Hash::make('password'),
           'permission' => 2,
           'perm_request' => false
        ]);
        DB::table('users')->insert([
           'email' => 'ryan.bengoufa@gmail.com',
           'username' => 'ryan',
           'password' => Hash::make('password'),
           'permission' => 0,
           'perm_request' => false
        ]);
        DB::table('users')->insert([
           'email' => 'ryan.bengoufa@hotmail.com',
           'username' => 'captainryan',
           'password' => Hash::make('password'),
           'permission' => 0,
           'perm_request' => false
        ]);
        DB::table('users')->insert([
            'email' => 'yanis_admin@gmail.com',
            'username' => 'yanis-admin',
            'password' => Hash::make('password'),
            'permission' => 2,
            'perm_request' => false
        ]);

        DB::table('users')->insert([
            'email' => 'yanis_gestio@gmail.com',
            'username' => 'yanis-gestio',
            'password' => Hash::make('password'),
            'permission' => 1,
            'perm_request' => false
        ]);

        DB::table('users')->insert([
            'email' => 'yanis_captain@gmail.com',
            'username' => 'yanis-captain',
            'password' => Hash::make('password'),
            'permission' => 0,
            'perm_request' => true
        ]);

        DB::table('users')->insert([
           'email' => 'captaineryansansequipe@aol.com',
           'username' => 'captainryan2',
           'password' => Hash::make('password'),
           'permission' => 0,
           'perm_request' => true
        ]);

    }
}
