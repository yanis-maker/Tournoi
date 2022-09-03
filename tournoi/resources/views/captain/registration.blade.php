@extends('layouts.base')
@section('content')
<h2>Tournois à venir</h2>
<ul class="list-unstyled">
   @foreach($waitingTournaments as $elt)
      <a href="{{ route('prompt', ['id' => $elt->id]) }}" style="color: black; text-decoration: none;"><li class="border border-primary w-auto m-3 p-3">
         {{$elt->label}}<span class="text-end" style="float:right;">{{$elt->freeSlots}} places disponibles</span>
         <br>{{$elt->location}},
         <?=utf8_encode(strftime('le %d %B %Y', strtotime($elt->date_start)));?>
         <span style="float:right;">{{$elt->teams_nb}} équipes</span>
      </li></a>
   @endforeach
</ul>
@stop
