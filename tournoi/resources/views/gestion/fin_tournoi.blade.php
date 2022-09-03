@extends('layouts.base')

@section('content')

    <?php use App\Models\Team;?>

    <div class="text-center">
        <h1>{{$tournament->label}}</h1>
        <p>Tournoi terminé</p>
        <p>Résultat de la finale: </p>
        <p>{{Team::where('id',$match->team_1)->first()->label}}  VS  {{Team::where('id',$match->team_2)->first()->label}}</p>
        <p>{{$match->score_1}}s - {{$match->score_2}}s</p>
        <p>Vainqueur du tournoi: {{Team::where('id',$match->winner)->first()->label}}</p>
    </div>
@stop