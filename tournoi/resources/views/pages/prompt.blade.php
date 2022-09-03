@extends('layouts.base')
@section('content')
<?php setlocale(LC_ALL, 'fr_fr'); ?>
   <h1>{{$tournament->label}}
   @if($tournament->statut == 2)
      @if(Auth::check())
         <?php
            $team = DB::table('teams')->where('captain', Auth::id())->first();
         ?>
         @if($team == null)
            <a type="button" class="btn btn-success" href="/captain" style="float: right;">Inscrire mon équipe</a>
         @else
            @if(in_array($team->id, json_decode($tournament->teams_list, true)) or in_array($team->id, json_decode($tournament->teams_pending, true)))
               <!-- UNSUBSCRIBE TEAM -->
               <form action="{{url('unsub')}}" method="post" style="float: right;">
                  @csrf
                  <input name="teamId" type="hidden" value="{{$team->id}}"></input>
                  <input name="tournamentId" type="hidden" value="{{$tournament->id}}"></input>
                  <button type="submit" class="btn btn-danger">Désinscrire mon équipe</button>
               </form>
            @else
               <!-- REQUEST TEAM PENDING -->
               <form action="{{url('sub')}}" method="post" style="float: right;">
                  @csrf
                  <input name="teamId" type="hidden" value="{{$team->id}}"></input>
                  <input name="tournamentId" type="hidden" value="{{$tournament->id}}"></input>
                  <button type="submit" class="btn btn-success">Inscrire mon équipe</button>
               </form>
            @endif
         @endif
      @else
         <a type="button" class="btn btn-success" href="/login" style="float: right;">Inscrire mon équipe</a>
      @endif
   @else
   <span style="float: right;" disabled>{{$tournament->extra}}</span>
   @endif
   </h1>
   <h3>
   {{$tournament->location}}, <?=utf8_encode(strftime('du %d %B %Y', strtotime($tournament->date_start))) . utf8_encode(strftime(' au %d %B %Y', strtotime($tournament->date_end)));?>
   </h3>

   <!-- BRACKET -->
   @if($tournament->statut != 2)
      <div id="match_gen">
         @foreach($tournament->matches as $match)
            <ul class="list-group match">
               <?php
                  $match->team_1_label = DB::table('teams')->where('id', $match->team_1)->value('label');
                  $match->team_2_label = DB::table('teams')->where('id', $match->team_2)->value('label');
               ?>
               <!-- <li class="list-group-item active">{{$match->numMatch}}</li> -->
               @if($match->score_1 < $match->score_2)
                  <li class="list-group-item match-winner">{{substr($match->team_1_label, 0, 10)}}<span style="float:right;margin-left:10px;">{{$match->score_1}}s</span></li>
                  <li class="list-group-item">{{substr($match->team_2_label, 0, 10)}}<span style="float:right;margin-left:10px;">{{$match->score_2}}s</span></li>
               @elseif($match->score_1 > $match->score_2)
                  <li class="list-group-item">{{substr($match->team_1_label, 0, 10)}}<span style="float:right;margin-left:10px;">{{$match->score_1}}s</span></li>
                  <li class="list-group-item match-winner">{{substr($match->team_2_label, 0, 10)}}<span style="float:right;margin-left:10px;">{{$match->score_2}}s</span></li>
               @else
                  <li class="list-group-item">{{substr($match->team_1_label, 0, 10)}}<span style="float:right;margin-left:10px;">--</span></li>
                  <li class="list-group-item">{{substr($match->team_2_label, 0, 10)}}<span style="float:right;margin-left:10px;">--</span></li>
               @endif
            </ul>
         @endforeach
         @for($i=1; $i <= ceil(log(count($tournament->matches),2)); $i++)
            <div class="rounds" id="bracket_round_{{$i}}"></div>
         @endfor
      </div>
   @endif
   <ul class="list-group">
      <li class="list-group-item active"><strong>Equipes inscrites</strong> <span style="float: right;">{{count(json_decode($tournament->teams_list, true))}}/{{$tournament->teams_nb}}</span></li>
      @foreach(json_decode($tournament->teams_list, true) as $elt)
         <li class="list-group-item"><?=DB::table('teams')->where('id', $elt)->value('label');?></li>
      @endforeach
   </ul>

   <script src="{{ asset('js/bracket.js') }}"></script>
@stop
