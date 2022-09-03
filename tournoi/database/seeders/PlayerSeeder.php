<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('players')->insert([
        'firstName' => 'Sergio',
        'lastName' => 'Ramos',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Lionel',
        'lastName' => 'Messi',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Lebron',
        'lastName' => 'James',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Rafael',
        'lastName' => 'Nadal',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Neymar',
        'lastName' => 'Junior',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Fernando',
        'lastName' => 'Alonzo',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Lewis',
        'lastName' => 'Hamilton',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Roger',
        'lastName' => 'Federer',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Angel',
        'lastName' => 'Di Maria',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Paul',
        'lastName' => 'Pogba',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Luis',
        'lastName' => 'Sarez',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Andres',
        'lastName' => 'Iniesta',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Iker',
        'lastName' => 'Casilas',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Cristiano',
        'lastName' => 'Ronaldo',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Zinedine',
        'lastName' => 'Zidane',
    ]);
    DB::table('players')->insert([
        'firstName' => 'Kylian',
        'lastName' => 'Mbappe',
    ]);
    }
}
