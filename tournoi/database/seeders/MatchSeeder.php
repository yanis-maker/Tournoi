<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('match')->insert([
            'numMatch' => 1,
            'team_1' => 1,
            'team_2' => 2,
            'score_1' => 1,
            'score_2' => 3,
            'date' => '2020-11-02',
            'tournament_id' => 1,
        ]);

        DB::table('match')->insert([
            'numMatch' => 2,
            'team_1' => 3,
            'team_2' => 4,
            'score_1' => 1,
            'score_2' => 3,
            'date' => '2020-11-02',
            'tournament_id' => 1,
         ]);
         
         DB::table('match')->insert([
             'numMatch' => 3,
             'team_1' => 1,
             'team_2' => 3,
             'score_1' => 1,
             'score_2' => 3,
             'date' => '2020-11-02',
             'tournament_id' => 1,
          ]);
    }
}
