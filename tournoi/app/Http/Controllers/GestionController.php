<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use App\Rules\DateMatch;
use App\Rules\FixDate;
use App\Models\Tournament;
use App\Models\Match;
use App\Models\Team;


class GestionController extends Controller
{
    public function index()
    {
        $runningTournaments = Tournament::where('statut', 1)->where('manager_id', Auth::user()->id)->get();
        $waitingTournaments = Tournament::where('statut', 2)->where('manager_id', Auth::user()->id)->get();
        $passedTournaments = Tournament::where('statut', 0)->where('manager_id',Auth::user()->id)->get();

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

            //$rT->currentTour = $tours[ceil(log($nbTeams,2)) - max(1,ceil(log($lowestNonPlayedMatch,2)))];
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

        return view('gestion.dashboard', [
            'runningTournaments'=>$runningTournaments,
            'waitingTournaments'=>$waitingTournaments,
            'passedTournaments'=>$passedTournaments
        ]);
    }

    public function registration_index(){

        $user=Auth::user();

        $waitingTournaments = Tournament::where('statut', 2)->where('manager_id',$user->id)->get();
        foreach($waitingTournaments as $wT) {
            $wT->freeSlots = $wT->teams_nb-count(json_decode($wT->teams_list, true));
        }
        $tours = [
            0 => "Finale",
            1 => "Demi-Finale",
            2 => "Quart de finale",
            3 => "8ème de finale",
            4 => "16ème de finale"
        ];


        return view('gestion.registration',[
            'waitingTournaments'=> $waitingTournaments,
            ]);
    }

    public function register_matches($id){

        $tournament=Tournament::where('id',$id)->first();
        //Nombre de matchs au premier tour
        $nb_matches=$tournament->teams_nb /2;
        $teams_list_id=json_decode(Tournament::where('id',$id)->first()->teams_list,true);
        $i=0;
        foreach($teams_list_id as $id_t){
            $teams_list[$i]=Team::where('id',$id_t)->first();
            $i++;
        }

        $j=0;
        //Nombre de match dans chaque tours 
        for($m=$nb_matches;$m>=1;$m=$m/2){
            $nb_match_tour[$j]=$m;
            $j++;
        }

        //Les tours en fonction du nombre d'équipes inscrites en enlevant le premier tour
        switch($tournament->teams_nb){
            case(2):
                $tour=[];
            break;
            case(4):
                $tour=[
                    0=>"Final"
                ];
            break;
            case(8):
                $tour=[
                    0=>"Finale",
                    1=>"Demi-Finale"
                ];
            break;
            case(16):
                $tour=[
                    0=>"Finale",
                    1=>"Demi-Finale",
                    2=>"Quart de Finale",
                ];
            break;

            case(32):
                $tour=[
                    0=>"Finale",
                    1=>"Demi-Finale",
                    2=>"Quart de Finale",
                    3=>"Huitième de Finale",
                ];
            break;
        }

        //Nombre de match dans la base de données 
        $nb_tournament_match=Match::where('tournament_id',$id)->get()->count();
        $date_start=Carbon::createFromFormat('Y-m-d', $tournament->date_start)->format('d-m-Y');
        $date_end=Carbon::createFromFormat('Y-m-d', $tournament->date_end)->format('d-m-Y');

        
        return view('gestion.register_matches',[
            'tournament'=>$tournament,
            'date_start'=>$date_start,
            'date_end'=>$date_end,
            'nb_matches'=>$nb_matches,
            'nb_match_tour'=>$nb_match_tour,
            'teams_list'=>$teams_list ,
            'tour'=>$tour,
            'nb_tournament_match'=>$nb_tournament_match,
            ]);
    }

    public function creation_matche(Request $request,$id,$nb_matches){

        $tournoi=Tournament::where('id',$id)->first();
        if((Match::where('tournament_id',$id)->get()->count())<$nb_matches){
            $match_list=Match::where('tournament_id',$id)->delete();
            /*foreach($match_list as $match){
                $match->delete();
            }*/
        }
        for( $i=1 ; $i<=$nb_matches ; $i++){
            $data= $request->validate([
                "first_team-$i"=>'required|exists:App\Models\Team,label',
                "second_team-$i"=>'required|exists:App\Models\Team,label',
                "date-$i"=>[
                    'required',
                    'date',
                    new DateMatch($id),
                ],
            ]);

            $match[$i]=Match::create([
                'numMatch'=> $i,
                'team_1'=> Team::where('label', $data["first_team-$i"])->first()->id,
                'team_2'=>Team::where('label',$data["second_team-$i"])->first()->id,
                'score_1'=>0,
                'score_2'=>0,
                'date'=> $data["date-$i"],
                'tournament_id'=>$id,
            ]);
        }
        return back()->with('success','Matchs créés');
    }

    public function fix_date(Request $request,$id){

        $tournament=Tournament::where('id',$id)->first();

        $delete=Match::where('tournament_id',$id)->where('team_1',NULL)->delete();
        
        $match_list=Match::where('tournament_id',$id)->where('team_1',NULL)->delete();
        $nb_matches=$tournament->teams_nb /2;

        $k=0;
        //Nombre de match dans chaque tours 
        for($m=$nb_matches;$m>=1;$m=$m/2){
            $nb_match_tour[$k]=$m;
            $k++;
        }
        
        $total_match=0;
        for($j=1;$j<count($nb_match_tour);$j++){
            $total_match=$nb_match_tour[$j]+ $total_match;
        }
        //dd(Match::where('tournament_id',$id)->where('team_1',null)->get()->count());
        $m=0;
        for($j=1;$j<count($nb_match_tour);$j++){
            $total_match=$nb_match_tour[$j]+ $total_match;
            for($i=1;$i<=$nb_match_tour[$j];$i++){
                $nb=$nb_match_tour[$j];
                $data=$request->validate([
                    "Match-$nb-$i"=>[
                        'required',
                        'date',
                        new DateMatch($id),
                        new FixDate($id,$request),
                    ]
                ]);
    
                $match[$m]=Match::create([
                    'numMatch'=> $nb_match_tour[0]+$m+1,
                    'team_1'=> null,
                    'team_2'=>null,
                    'score_1'=>0,
                    'score_2'=>0,
                    'date'=> $data["Match-$nb-$i"],
                    'tournament_id'=>$id,
                ]);
                $m++;
            }
        }

    
        

        return back()->with('success','Dates fixées');
    }

    public function start_tournament($id){
        
        
        $date=Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->format('d-m-Y');
        $date_start=Carbon::createFromFormat('Y-m-d', Tournament::where('id',$id)->first()->date_start)->format('d-m-Y');
        if($date_start==$date){
            Tournament::where('id',$id)->get()->toQuery()->update(['statut'=>1]);
            return redirect()->route('registration_index')->with('success','Le '.Tournament::where('id',$id)->first()->label.' est maintenant ouvert');
        }
        else{
            return back()->with(['error'=>'Ce tournoi commence le '.$date_start.'. Veuillez attendre le '.$date_start.' pour le lancer']);
        }

    }

    public function register_score_index(){

        $runningTournaments = Tournament::where('statut', 1)->where('manager_id', Auth::user()->id)->get();
        
        $tours = [
            0 => "Finale",
            1 => "Demi-Finale",
            2 => "Quart de finale",
            3 => "8ème de finale",
            4 => "16ème de finale"
        ];
        
        foreach($runningTournaments as $rT) {
            $lowestNonPlayedMatch = Match::where('tournament_id', $rT->id)->where('score_1', 0)->where('score_2', 0)->min('numMatch');
            $matchWithoutTeam=Match::where('tournament_id',$rT->id)->where('team_1',null)->get('numMatch');
            $matchWithTeam=Match::where('tournament_id',$rT->id)->whereNotIn('numMatch',$matchWithoutTeam)->get()->count();
            $nbTeams = count(json_decode($rT->teams_list, true));
            //$rT->currentTour = $tours[ceil(log($nbTeams,2)) - ((ceil($matchWithTeam/($nbTeams/4)))-1)];
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
        
        

        return view('gestion.registration_score',['runningTournaments'=>$runningTournaments]);
    }

    public function register_score($id){

        $tournament=Tournament::where('id',$id)->first();

        $tours = [
            0 => "Finale",
            1 => "Demi-Finale",
            2 => "Quart de finale",
            3 => "8ème de finale",
            4 => "16ème de finale"
        ];

        //Nombre de matchs au premier tour
        $nb_matches=$tournament->teams_nb /2;
        $teams_list_id=json_decode(Tournament::where('id',$id)->first()->teams_list,true);
        $i=0;
        foreach($teams_list_id as $id_t){
            $teams_list[$i]=Team::where('id',$id_t)->first();
            $i++;
        }

        $date_start=Carbon::createFromFormat('Y-m-d', $tournament->date_start)->format('d-m-Y');
        $date_end=Carbon::createFromFormat('Y-m-d', $tournament->date_end)->format('d-m-Y');

        $j=0;
        //Nombre de match dans chaque tours 
        for($m=1;$m<=$nb_matches;$m=$m*2){
            $nb_match_tour[$j]=$m;
            $j++;
        }

        

        $lowestNonPlayedMatch = Match::where('tournament_id', $id)->where('score_1', 0)->where('score_2', 0)->min('numMatch');
        $matchWithoutTeam=Match::where('tournament_id',$id)->where('team_2',null)->get('numMatch');
        $matchWithTeam=Match::where('tournament_id',$id)->whereNotIn('numMatch',$matchWithoutTeam)->get()->count();
        $nbTeams = count(json_decode($tournament->teams_list, true));
        if($nbTeams==4 || $nbTeams==2){
            $tournament->currentTour = $tours[ceil(log($nbTeams,2)) - ((ceil($matchWithTeam/($nbTeams/4)))-1)];
        }
        else{
            if($matchWithTeam==$nbTeams-1){
                $tournament->currentTour = $tours[ceil(log($nbTeams,2)) - ((ceil($matchWithTeam/($nbTeams/4)))-1)];
            }
            else{
                $n=ceil(log($nbTeams,2))-1;
                for($m=count($nb_match_tour)-1;$m>=0;$m--){
                    if($n==ceil(log($nbTeams,2))-1){
                        $match_must_team[$n]=$nb_match_tour[$m];;
                        $n--; 
                    }
                    else{
                        $match_must_team[$n]=$nb_match_tour[$m]+$match_must_team[$n+1];
                        $n--;
                    }
                }
                arsort($match_must_team);
                //dd(array_search($matchWithTeam,$match_must_team)==0);
                if(array_search($matchWithTeam,$match_must_team)){
                    $tournament->currentTour = $tours[array_search($matchWithTeam,$match_must_team)];
                }
                else{
                    $i=count($match_must_team)-1;
                    $trouve=false;
                    while($i>=0 && !($trouve)){
                        if($match_must_team[$i]<$matchWithTeam && $match_must_team[$i-1]>$matchWithTeam){
                            $tournament->currentTour=$tours[$i];
                            $trouve=true;
                        }
                        $i--;
                    }
                }
            }
        }
        

        //$tournament->currentTour=$tours[ceil(log($matchWithTeam,2))];

        $k=array_search($tournament->currentTour,$tours);
        if($k==count($nb_match_tour)-1){
            $i=1;
            $l=1;
        }
        else{
            $i=array_sum(array_slice($nb_match_tour,$k+1))+1;
            $l=array_sum(array_slice($nb_match_tour,$k+1))+1;
        }
        $nb_match_dernier_tour=$i-1;
        for($j=0;$j<$nb_match_tour[$k];$j++){
            $match[$j]=Match::where('tournament_id',$id)->where('numMatch',$i)->where('score_1',0.00)->where('score_2',0.00)->first();
            $i++;
        }

        for($j=0;$j<$nb_match_tour[$k];$j++){
            $match_jouer[$j]=Match::where('tournament_id',$id)->where('numMatch',$l)->where('score_1','>',0)->first();
            if($match_jouer[$j]){
                if($match_jouer[$j]->score_1 > $match_jouer[$j]->score_2){
                    $match_jouer[$j]->winner = $match_jouer[$j]->team_2;
                }
                else{
                    $match_jouer[$j]->winner=$match_jouer[$j]->team_1;
                }
            }
            $l++;
        }

        $bool=false;
        for($a=0;$a<count($match);$a++){
            if($match[$a]!=null){$bool=true;}
        }
        
        
        return view('gestion.score',[
            'tournament'=>$tournament,
            'date_start'=>$date_start,
            'date_end'=>$date_end,
            'teams_list'=>$teams_list,
            'match_list'=>$match,
            'reste_match'=>$bool,
            'nb_match_dernier_tour'=>$nb_match_dernier_tour,
            'match_jouer'=>$match_jouer
        ]);

    }

    public function score(Request $request,$id,$numMatch,$currentTour){

        

        $tours = [
            0 => "Finale",
            1 => "Demi-Finale",
            2 => "Quart de finale",
            3 => "8ème de finale",
            4 => "16ème de finale"
        ];

        $tournament=Tournament::where('id',$id)->first();
        $match=Match::where('numMatch',$numMatch)->where('tournament_id',$id)->get();

        $data=$request->validate([
            "first_team-$numMatch"=> 'required',
            "second_team-$numMatch"=> 'required',
        ]);

        $match->toQuery()->update(['score_1'=>$data["first_team-$numMatch"]]);
        $match->toQuery()->update(['score_2'=>$data["second_team-$numMatch"]]);


        $match=Match::where('numMatch',$numMatch)->where('tournament_id',$id)->first();
        if($match->score_1 > $match->score_2){
            $match->winner = $match->team_2;
        }
        else{
            $match->winner=$match->team_1;
        }


        //Toute cette partie est pour trouver le num du prochain match de l'équipe gagnante
        $j=0;
        //Nombre de match dans chaque tours 
        for($m=1;$m<=$tournament->teams_nb/2;$m=$m*2){
            $nb_match_tour[$j]=$m;
            $j++;
        }

        $k=array_search($currentTour,$tours);
        $nb_start=1;
        if($nb_match_tour[$k]==$tournament->teams_nb/2){
            $nb_start=1;
        }
        else{
            for($i=count($nb_match_tour)-1;$i>$k;$i--){
                $nb_start=$nb_match_tour[$i]+$nb_start;
            }
        }
        $j=0;
        $cpt=$nb_match_tour[$k];
        $num_next_match=0;
        for($i=$nb_start;$i<=$numMatch;$i++){
            if(fmod($i,2)==0){
                $num_next_match=($i+$cpt)-1;
                $cpt--;
            }
            else{
                $num_next_match=$i+$cpt;
            }
            $j++;
        }

        //dd($num_next_match);

        if($currentTour=="Finale"){
            
            Tournament::where('id',$id)->get()->toQuery()->update(['statut'=>0]);
            return view('gestion.fin_tournoi',[
                'tournament'=>$tournament,
                'match'=>$match,
            ])->with(['success'=>'Le score du Match '.$numMatch.' est enregistré']);
        }
        else{
            if(fmod($numMatch,2)==0){
                Match::where('numMatch',$num_next_match)->where('tournament_id',$id)->get()->toQuery()->update(['team_2'=>$match->winner]);
            }
            else{
                Match::where('numMatch',$num_next_match)->where('tournament_id',$id)->get()->toQuery()->update(['team_1'=>$match->winner]);
            }
            
            
            return back()->with(['success'=>'Le score du Match '.$numMatch.' est enregistré']);
        }
    }
}
