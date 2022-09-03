<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Player;
use App\Models\User;

use Illuminate\Http\Request;

class CaptainController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $count = 0;
        $players = [];
        if($team = Team::where('captain', $user->id)->first()){
            $player_array = json_decode($team->player_list, true);
            if(!empty($player_array)){
                $i = 0;
                foreach ($player_array as $id) {
                    $players[$i] = Player::where('id', $id)->first();
                    $i++;
                }
            }
            $count = 4 - count($players);
        }

        return view('captain.dashboard', ['team'=>$team, 'players'=>$players, 'count'=>$count]);
    }

    public function player_delete($id){
        Player::destroy($id);
        $user = Auth::user();

        $team = Team::where('captain', $user->id)->first();
        $player_array = json_decode($team->player_list, true);

        unset($player_array[array_search($id, $player_array)]);
        sort($player_array); // Trie un tableau

        $player_json = json_encode($player_array, JSON_FORCE_OBJECT );
        $team->player_list = $player_json;
        $team->save();

        return redirect()->route('dashboard-captain')->with('success','Joueur bien supprimé');
    }

    public function player_add(Request $request, $count){

        $user = Auth::user();
        $team = Team::where('captain', $user->id)->first();

        for($i = 1; $i<=$count; $i++){
            $data = $request->validate([
                "prenom-{$i}" => 'required',
                "nom-{$i}" => 'required',
            ]);

            $players[$i] = Player::create([
                'firstName' => $data["prenom-{$i}"],
                'lastName' => $data["nom-{$i}"],
            ]);

        }

        $player_array = json_decode($team->player_list, true);

        $p = 1;
        $j = count($player_array);
        while($p <= $count){
            $player_array[$j] = $players[$p]->id;
            $j++;
            $p++;
        }
        $player_json = json_encode($player_array, JSON_FORCE_OBJECT );
        $team->player_list = $player_json;
        $team->save();

        return redirect()->route('dashboard-captain')->with('success','Joueur(s) bien ajouté');
    }

    public function captain_update(Request $request){

        $data = $request->validate([
            "address" => 'required',
            "phone" => 'required|numeric',
        ]);
        $user = Auth::user();
        $team = Team::where('captain', $user->id)->first();
        $team->address = $data["address"];
        $team->phone = $data["phone"];
        $team->save();

        return redirect()->route('dashboard-captain')->with('success','Informations modifiés');
    }

    public function gestion_request(){
        $user = User::where('id', Auth::user()->id)->first();
        $user->perm_request = true;
        $user->save();
        return redirect()->route('dashboard-captain')->with('success','Requête pour devenir gestionnaire envoyée.');
    }

    public function team_creation(Request $request){
        $data = $request->validate([
            "name" => 'required',
            "address" => 'required',
            "phone" => 'required|numeric',
        ]);

        $user = Auth::user();
        $team = Team::create([
            'label' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'captain' => $user->id,

        ]);


        return redirect()->route('dashboard-captain')->with('success','Votre équipe est désormais créée');

    }
    public function registration_tournament(){

        $waitingTournaments = Tournament::where('statut', 2)->get();

        foreach($waitingTournaments as $wT) {
            $wT->freeSlots = $wT->teams_nb-count(json_decode($wT->teams_list, true));
        }

        return view('captain.registration', ['waitingTournaments'=>$waitingTournaments]);
    }
}
