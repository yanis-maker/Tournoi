@extends('layouts.base')

@section('content')
    <div id="in-run">
        <h2>Tournois en cours</h2>
        <ul class="list-unstyled">
            @foreach($runningTournaments as $elt)
                <a href="{{ route('register_score',['id'=>$elt->id]) }}" style="color: black; text-decoration: none;"><li class="border border-primary w-auto m-3 p-3">
                    {{$elt->label}}<span style="float:right;"><p>Tour actuel =>{{$elt->currentTour}}</p></span>
                    </br>{{$elt->location}},
                    <?=utf8_encode(strftime('le %d %B %Y', strtotime($elt->date_start)));?>
                </li></a>
            @endforeach
        </ul>
    </div>
    

@stop