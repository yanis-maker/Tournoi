@extends('layouts.base')

@section('content')

    <div class="text-center">
        <h1>{{$tournament->label}}</h1><br>
        <h2>Informations</h2>
        <p>Lieu du tournoi: {{$tournament->location}}</p>
        <p>Date début du tournoi: {{$date_start}}</p>
        <p>Date fin du tournoi: {{$date_end}}</p>
        <p>Nombre de tours: {{count($tour)+1}}</p>
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
    @if($nb_tournament_match==0 || $nb_tournament_match < $tournament->teams_nb /2)
        <div class="matche">
            @switch (count($teams_list))
                @case(2)
                    <h2>Premier Tour: Finale</h2><br><br>
                    @break
                @case(4)
                    <h2>Premier Tour: Demi-Finale</h2><br><br>
                    @break
                @case(8)
                    <h2>Premier Tour: Quart de Finale</h2><br><br>
                    @break
                @case(16)
                    <h2>Premier Tour: Huitième de Finale</h2><br><br>
                    @break
                @case(32)
                    <h2>Premier Tour: Seizième de Finale</h2><br><br>
                    @break
            @endswitch
            <form action="{{route('creation_matche',['id'=>$tournament->id, 'nb_matches'=>$nb_matches])}}" method="POST">
            @csrf
                @for ($i=1;$i<=$nb_matches;$i++)
                    <h3>Match {{$i}}</h3>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Equipe1" aria-label="Equipe1" name="first_team-{{$i}}">
                        <span class="input-group-text">VS</span>
                        <input type="text" class="form-control" placeholder="Equipe2" aria-label="Equipe2" name="second_team-{{$i}}">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3">Date du matche</span>
                        <input type="date" class="form-control" name="date-{{$i}}">
                    </div>
                @endfor
                <button type="submit" class="btn btn-primary" >Enregister</button>
            </form>
        </div> 
    @elseif($nb_tournament_match==($tournament->teams_nb - 1))
        <div class="launch">
            <h3>Tournoi paramétré</h3>
            <p>Prêt pour être lancer le jour prévu.</p>
            <form action="{{route('start_tournament',['id'=>$tournament->id])}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success" >Lancer le tournoi</button>
            </form>
        </div>
    @else
        <div class="wrapper">
            <h2>Les rencontres du premier tour ont été saisies</h2>
            <p>Vous pouvez maintenant saisir la date des rencontres des prochains tours</p>

            <div class="radio_tabs">
                @for($i=0;$i<(count($tour));$i++)
                    <label class="radio_wrap" data-radio="radio_{{$i+1}}" >
                        <input type="radio"  name="tours" class="input" checked>
                        <span class="radio_mark">{{$tour[$i]}}</span>
                    </label>
                @endfor
            </div>
            <div class="content">
                <form action="{{route('fix_date',['id'=>$tournament->id])}}" method="POST">
                    @csrf
                    @for($j=(count($nb_match_tour))-1;$j>0;$j--)
                        @for($i=1;$i<=$nb_match_tour[$j];$i++)
                            <div class="radio_content radio_{{$nb_match_tour[$j]}}">
                                <h3>Match {{$i}}</h3>
                                <input type="date" class="form-control" name="Match-{{$nb_match_tour[$j]}}-{{$i}}" >
                            </div>
                        @endfor
                    @endfor
                    <br><button type="submit" class="btn btn-primary" >Enregister</button>
                </form>
            </div>
        </div>
    @endif
<script src="{{ asset('js/gestion.js') }}"></script>

@stop
