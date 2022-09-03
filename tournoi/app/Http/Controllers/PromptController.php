<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\Match;

class PromptController extends Controller
{
    public function show($id) {

        $tournament = Tournament::where('id', $id)->first();

        if($tournament->statut == 1) {
            $tours = [
                0 => "Finale",
                1 => "Demi-Finale",
                2 => "Quart de finale",
                3 => "8ème de finale",
                4 => "16ème de finale"
            ];
            $lowestNonPlayedMatch = Match::where('tournament_id', $id)->where('score_1', 0)->where('score_2', 0)->min('numMatch');
            $nbTeams = count(json_decode($tournament->teams_list, true));

            //$tournament->extra = $tours[ceil(log($nbTeams,2)) - max(1,ceil(log($lowestNonPlayedMatch,2)))];

            $matchNum = 1;
            $t = ceil(log($nbTeams,2))-1;
            while($nbTeams>1){
                $nbTeams /= 2;
                for($i=0; $i<$nbTeams; $i++) {
                    if($lowestNonPlayedMatch == $matchNum) {
                        $tournament->extra = $tours[$t];
                    }
                    $matchNum++;
                }
                $t--;
            }

            $tournament->matches = Match::where('tournament_id', $id)->get();
        }else if($tournament->statut == 0) {
            $finNumMatch = Match::where('tournament_id', $id)->max('numMatch');
            $finalMatch = Match::where('tournament_id', $id)->where('numMatch', $finNumMatch)->first();
            if($finalMatch->score_1 < $finalMatch->score_2) {
                $tournament->extra = Team::where('id', $finalMatch->team_1)->value('label');
            }else {
                $tournament->extra = Team::where('id', $finalMatch->team_2)->value('label');
            }
            $tournament->matches = Match::where('tournament_id', $id)->get();
        }
        return view('pages.prompt', ['tournament'=>$tournament]);
    }

    public function sub(Request $request){
        $tournament = Tournament::where('id', $request->tournamentId)->first();
        $json = json_decode($tournament->teams_pending, true);
        $json[] = intval($request->teamId);
        $tournament->teams_pending = json_encode($json);

        $tournament->save();
        return view('pages.prompt', ['tournament'=>$tournament]);
    }

    public function unsub(Request $request){
        $tournament = Tournament::where('id', $request->tournamentId)->first();
        $teamsPend = json_decode($tournament->teams_pending, true);
        $teamsList = json_decode($tournament->teams_list, true);
        if(in_array($request->teamId, $teamsPend)) {
            unset($teamsPend[array_search($request->teamId, $teamsPend)]);
            $tournament->teams_pending = json_encode(array_values($teamsPend));
        }else{
            unset($teamsList[array_search($request->teamId, $teamsList)]);
            $tournament->teams_list = json_encode(array_values($teamsList));
        }
        $tournament->save();
        
        return view('pages.prompt', ['tournament'=>$tournament]);
    }
}
