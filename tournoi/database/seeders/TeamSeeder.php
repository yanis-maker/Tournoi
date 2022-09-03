<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            'label' => 'Ecosse',
            'address' => '420 Somewhere Street',
            'phone' => '0607080910',
            'captain' => 1,
            'player_list' => '[1,2,3,4]'
         ]);

        DB::table('teams')->insert([
            'label' => 'Suède',
            'address' => '420 Somewhere Street',
            'phone' => '0607080910',
            'captain' => 2,
            'player_list' => '[5,6,7,8]'
        ]);

        DB::table('teams')->insert([
            'label' => 'Finlande',
            'address' => '420 Somewhere Street',
            'phone' => '0607080910',
            'captain' => 3,
            'player_list' => '[9,10,11,12]'
        ]);

        DB::table('teams')->insert([
            'label' => 'Lettonie',
            'address' => '420 Somewhere Street',
            'phone' => '0607080910',
            'captain' => 4,
            'player_list' => '[13,14,15,16]'
        ]);

        DB::table('teams')->insert([
            'label'=>'Autriche',
            'address'=>'420 Somewhere Street',
            'phone'=>'06759758458',
            'captain'=>6,
            'player_list'=>'[13,14,15,16]'
        ]);

        DB::table('teams')->insert([
            'label'=>'France',
            'address'=>'420 Somewhere Street',
            'phone'=>'06759758458',
            'captain'=>6,
            'player_list'=>'[13,14,15,16]'
        ]);

        DB::table('teams')->insert([
            'label'=>'Angleterre',
            'address'=>'420 Somewhere Street',
            'phone'=>'06759758458',
            'captain'=>6,
            'player_list'=>'[1,2,3,4]'
        ]);

        DB::table('teams')->insert([
            'label'=>'Allemagne',
            'address'=>'420 Somewhere Street',
            'phone'=>'06759758458',
            'captain'=>6,
            'player_list'=>'[5,6,7,8]'
        ]);

        DB::table('teams')->insert([
            'label'=>'Espagne',
            'address'=>'420 Somewhere Street',
            'phone'=>'06759758458',
            'captain'=>6,
            'player_list'=>'[9,10,11,12]'
        ]);
    }
}
