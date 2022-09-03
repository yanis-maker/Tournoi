@extends('layouts.base')

@section('content')

    <h1 class="text-center">Bienvenue Gestionnaire </h1>
    <div id="in-run">
        <h2>Tournois en cours</h2>
        <ul class="list-unstyled">
            @foreach($runningTournaments as $elt)
                <a href="{{ route('prompt_gestio', ['label_tournament' => $elt->label]) }}" style="color: black; text-decoration: none;"><li class="border border-primary w-auto m-3 p-3">
                    {{$elt->label}}<span style="float:right;"><p>Tour actuel =>{{$elt->currentTour}}</p></span>
                    </br>{{$elt->location}},
                    <?=utf8_encode(strftime('le %d %B %Y', strtotime($elt->date_start)));?>
                </li></a>
            @endforeach
        </ul>
    </div>

    <div id="to-come">
        <h2>Tournois à venir</h2>
        <ul class="list-unstyled">
            @foreach($waitingTournaments as $elt)
                <a href="{{ route('prompt_gestio', ['label_tournament' => $elt->label]) }}" style="color: black; text-decoration: none;"><li class="border border-primary w-auto m-3 p-3">
                {{$elt->label}}<span style="float:right;">{{$elt->freeSlots}} places disponibles</span>
                    </br>{{$elt->location}},
                    <?=utf8_encode(strftime('le %d %B %Y', strtotime($elt->date_start)));?>
                    <span style="float:right;">{{$elt->teams_nb}} équipes</span>
                </li></a>
            @endforeach
        </ul>
    </div>

    <div id="finished">
        <h2>Tournois terminés</h2>
        <ul class="list-unstyled">
            @foreach($passedTournaments as $elt)
                <a href="{{ route('prompt_gestio', ['label_tournament' => $elt->label]) }}" style="color: black; text-decoration: none;"><li class="border border-primary w-auto m-3 p-3">
                    {{$elt->label}}<span class="text-end" style="float:right;">Gagnant<br>{{$elt->winner}}</span>
                    </br>{{$elt->location}},
                    <?=utf8_encode(strftime('le %d %B %Y', strtotime($elt->date_start)));?>
                </li></a>
            @endforeach
        </ul>
    </div>
@stop
