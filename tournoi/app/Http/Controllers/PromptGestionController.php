<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use App\Models\Player;
use App\Models\Match;

class PromptGestionController extends Controller
{
    public function show_gestio($label) {

        $tournament=Tournament::where('label',$label)->first();
        $teamlist_id=json_decode($tournament->teams_list,true);
        $nb_teams=count($teamlist_id);

        $teamspending_id=json_decode($tournament->teams_pending,true);

        $j=0;
        if(!empty($teamspending_id)){
            foreach($teamspending_id as $id_t){
                $teams_pending[$j]=Team::where('id',$id_t)->first();
                $j++;
            }
        }
        else{
            $teams_pending=[];
        }

        $i=0;
        if(!empty($teamlist_id)){
            foreach($teamlist_id as $id_t){
                $teamlist[$i]=Team::where('id',$id_t)->first();
                $i++;
            }
        }
        else{
            $teamlist=[];
        }

        //dd($nb_teams);

        return view('gestion.prompt_gestio', [
            'label_tournament'=>$label,
            'teamlist'=>$teamlist,
            'teams_pending'=>$teams_pending,
            'tournament'=>$tournament,
            'nb_teams'=>$nb_teams,
        ]);
    }



    public function info_teams($label_tournament,$nom){

        $team=Team::where('label',$nom)->first();
        $captain=User::where('id',$team->captain)->first();
        $list_player=json_decode(Team::where('label',$nom)->first()->player_list,true);

        $i=0;
        foreach($list_player as $id){
            $players[$i]=Player::where('id',$id)->first();
            $i++;
        }


        return view('gestion.info_team', [
            'nom'=>$nom,
            'team'=>$team,
            'captain'=>$captain,
            'players'=>$players,
        ]);
    }

    public function delete_team($label_tournament,$nom_team){

        $team_delete=Team::where('label',$nom_team)->first()->id;
        $tournament=Tournament::where('label',$label_tournament)->first();

        $teams_list=json_decode($tournament->teams_list, true);
        unset($teams_list[array_search($team_delete, $teams_list)]);
        sort($teams_list); // Trie un tableau

        $team_json = json_encode($teams_list,  );
        $tournament->teams_list=$team_json;
        $tournament->save();

        //dd($label);
        return redirect()->route('prompt_gestio', ['label_tournament'=>$label_tournament])->with('success','Équipe bien supprimée');

    }

    public function inscription(Request $request,$label_tournament,$nom_team){

        $team=Team::where('label',$nom_team)->first();
        $tournament=Tournament::where('label',$label_tournament)->first();

        $teams_list=json_decode($tournament->teams_list,false);
        $teams_pending=json_decode($tournament->teams_pending,true);
        if($request['outlined']=='Confirm'){
            array_push($teams_list,$team->id);
            unset($teams_pending[array_search($team->id,$teams_pending)]);
            sort($teams_pending);

            $teams_pending_json=json_encode($teams_pending);
            $teams_list_json=json_encode($teams_list);
            $tournament->teams_list=$teams_list_json;
            $tournament->teams_pending=$teams_pending_json;
            $tournament->save();
            return redirect()->route('prompt_gestio', ['label_tournament'=>$label_tournament])->with('success','Demande d\'inscription acceptée');


        }
        else if($request['outlined']=='Reject'){
            unset($teams_pending[array_search($team->id,$teams_pending)]);
            sort($teams_pending);
            $teams_pending_json=json_encode($teams_pending);
            $tournament->teams_pending=$teams_pending_json;
            $tournament->save();
            return redirect()->route('prompt_gestio', ['label_tournament'=>$label_tournament])->with('error','Demande d\'inscription rejetée');
        }
        //array_push($teams_list,$team->id);
    }
}
