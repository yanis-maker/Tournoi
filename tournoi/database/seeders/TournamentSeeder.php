<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tournaments')->insert([
            'label' => 'Tournoi de Vancouver',
            'manager_id' => 5,
            'date_start' => '2020-11-01',
            'date_end' => '2020-11-14',
            'location' => 'Stadium de Vancouver',
            'teams_nb' => 4,
            'teams_list' => '[1,2,3,4]',
            'teams_pending' => '[]',
            'statut' => 0,
        ]);

        DB::table('tournaments')->insert([
            'label'=>'Tournoi d\'Oslo',
            'manager_id'=>5,
            'date_start' => '2021-06-01',
            'date_end'=>'2021-06-15',
            'location' => 'Bislett Stadium',
            'teams_nb' => 4,
            'teams_list' => '[1,2]',
            'teams_pending' => '[]',
            'statut' => 2,
        ]);

        DB::table('tournaments')->insert([
            'label'=>'Tournoi de Zurich',
            'manager_id'=>5,
            'date_start' => '2021-06-01',
            'date_end'=>'2021-06-30',
            'location' => 'Zurich Stadium',
            'teams_nb' => 8,
            'teams_list' => '[1,2,3,4,5,6,7]',
            'teams_pending' => '[8,9]',
            'statut' => 2,
        ]);
    }
}
