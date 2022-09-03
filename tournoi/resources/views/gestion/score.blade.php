@extends('layouts.base')

@section('content')

    <?php use App\Models\Team;?>

    <div class="text-center">
        <h1>{{$tournament->label}}</h1><br>
        <h2>Informations</h2>
        <p>Lieu du tournoi: {{$tournament->location}}</p>
        <p>Date début du tournoi: {{$date_start}}</p>
        <p>Date fin du tournoi: {{$date_end}}</p>
    </div>
    <div class="team_display2">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Les Équipes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams_list as $team)
                    <tr>
                        <td>{{$team->label}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div><br><br><br>

    <h3 class="text-center">Tour actuel : {{$tournament->currentTour}}</h3>

    @if($reste_match)
        <p class="text-center">Saisir les scores des rencontres du tour actuel et passer au prochain tour</p>
        <p class="text-center">Vous ne pourrez saisir le score d'une rencontre que le jour du match</p>
    @endif

    @foreach ($match_jouer as $match)
        @if($match)
            <div class=score>
                @if ($tournament->teams_nb/2==count($match_list))
                     <h3>Match {{$match->numMatch}}</h3>
                @else
                    <h3>Match {{$match->numMatch-$nb_match_dernier_tour}}</h3>
                @endif
                <p>{{Team::where('id',$match->team_1)->first()->label}}  VS  {{Team::where('id',$match->team_2)->first()->label}}</p>
                <p>{{$match->score_1}}s - {{$match->score_2}}s</p>
                <p>Le vainqueur: {{Team::where('id',$match->winner)->first()->label}}</p>
            </div>
        @endif
    @endforeach
    
    @if ($reste_match)
        @foreach($match_list as $match)
            @if ($match)
                <div class="score">
                    @if ($tournament->teams_nb/2==count($match_list))
                        <h3>Match {{$match->numMatch}}</h3>
                    @else
                        <h3>Match {{$match->numMatch-$nb_match_dernier_tour}}</h3>
                    @endif
                    <p>{{Team::where('id',$match->team_1)->first()->label}}  VS  {{Team::where('id',$match->team_2)->first()->label}}</p>
                    <form action="{{route('score',['id'=>$tournament->id,'numMatch'=>$match->numMatch,'currentTour'=>$tournament->currentTour])}}", method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="number" step=any min="1" class="form-control" placeholder="{{Team::where('id',$match->team_1)->first()->label}}" aria-label="Equipe1" name="first_team-{{$match->numMatch}}">
                            <span class="input-group-text">VS</span>
                            <input type="number" step=any class="form-control" placeholder="{{Team::where('id',$match->team_2)->first()->label}}" aria-label="Equipe2" name="second_team-{{$match->numMatch}}">
                        </div>
                        @if($tournament->currentTour == "Finale")
                            <button type="submit" class="btn btn-success" >Enregistrer et fin du tournoi</button><br><br>
                        @else
                            <button type="submit" class="btn btn-success" >Enregister</button><br><br>
                        @endif
                    </form>
                </div>
            @endif
        @endforeach
    @endif


@stop