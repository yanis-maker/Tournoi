@extends('layouts.base')
@section('content')
<?php setlocale(LC_ALL, 'fr_fr'); ?>
   <div id="carrousel">
      <button id="prevBtn"><strong><</strong></button>
      <a href="#" id="info_0">
         <span>
            <h1>La Coupe de Bob</h1>
            <h3>Bienvenue sur le site de gestion de tournoi Bobsleigh</h3>
         </span>
      </a>
      <a href="#" id="info_1" style="display: none;">
         <span>
             <h1>La Coupe de Bob</h1>
             <h3>Bienvenue sur le site de gestion de tournoi Bobsleigh</h3>
         </span>
      </a>
      <a href="#" id="info_2" style="display: none;">
         <span>
             <h1>La Coupe de Bob</h1>
             <h3>Bienvenue sur le site de gestion de tournoi Bobsleigh</h3>
         </span>
      </a>
      <button id="nextBtn" style="float: right;"><strong>></strong></button>
   </div>

   <h2>Tournois en cours</h2>
   <ul class="list-unstyled">
      @foreach($runningTournaments as $elt)
         <a href="{{ route('prompt', ['id' => $elt->id]) }}" style="color: black; text-decoration: none;"><li class="border border-primary w-auto m-3 p-3">
            {{$elt->label}}<span class="text-end" style="float:right;">Tour actuel <br>{{$elt->currentTour}}</span>
            <br>{{$elt->location}},
            <?=utf8_encode(strftime('le %d %B %Y', strtotime($elt->date_start)));?>
         </li></a>
      @endforeach
   </ul>

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

   <h2>Tournois terminés</h2>
   <ul class="list-unstyled">
      @foreach($passedTournaments as $elt)
         <a href="{{ route('prompt', ['id' => $elt->id]) }}" style="color: black; text-decoration: none;"><li class="border border-primary w-auto m-3 p-3">
            {{$elt->label}}<span class="text-end" style="float:right;">Gagnant<br>{{$elt->winner}}</span>
            <br>{{$elt->location}},
            <?=utf8_encode(strftime('le %d %B %Y', strtotime($elt->date_start)));?>
         </li></a>
      @endforeach
   </ul>
   <script src="{{ asset('js/carrousel.js') }}"></script>
@stop
