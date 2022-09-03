<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Match;
use App\Models\Team;

class HomeController extends Controller
{
    public function index()
    {
        $runningTournaments = Tournament::where('statut', 1)->get();
        $waitingTournaments = Tournament::where('statut', 2)->get();
        $passedTournaments = Tournament::where('statut', 0)->get();

        $tours = [
            0 => "Finale",
            1 => "Demi-Finale",
            2 => "Quart de finale",
            3 => "8ème de finale",
            4 => "16ème de finale"
        ];
        //Calculating current tours
        foreach($runningTournaments as $rT) {
            $lowestNonPlayedMatch = Match::where('tournament_id', $rT->id)->where('score_1', 0)->where('score_2', 0)->min('numMatch');
            $nbTeams = count(json_decode($rT->teams_list, true));

            // $rT->currentTour = $tours[ceil(log($nbTeams,2)) - max(1,floor(log($lowestNonPlayedMatch-1,2)))];

            $matchNum = 1;
            $t = ceil(log($nbTeams,2))-1;
            while($nbTeams>1){
                $nbTeams /= 2;
                for($i=0; $i<$nbTeams; $i++) {
                    if($lowestNonPlayedMatch == $matchNum) {
                        $rT->currentTour = $tours[$t];
                    }
                    $matchNum++;
                }
                $t--;
            }
        }
        

        //Calculating winners
        foreach($passedTournaments as $pT) {
            $finNumMatch = Match::where('tournament_id', $pT->id)->max('numMatch');
            $finalMatch = Match::where('tournament_id', $pT->id)->where('numMatch', $finNumMatch)->first();
            if($finalMatch->score_1 < $finalMatch->score_2) {
                $pT->winner = Team::where('id', $finalMatch->team_1)->value('label');
            }else {
                $pT->winner = Team::where('id', $finalMatch->team_2)->value('label');
            }
        }

        //Calculating the numbers of free slots
        foreach($waitingTournaments as $wT) {
            $wT->freeSlots = $wT->teams_nb-count(json_decode($wT->teams_list, true));
        }

        return view('pages.welcome', [
            'runningTournaments'=>$runningTournaments,
            'waitingTournaments'=>$waitingTournaments,
            'passedTournaments'=>$passedTournaments
            ]);
    }

    public function loi()
    {
        return view('pages.loi');
    }
}
