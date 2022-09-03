@extends('layouts.base')
@section('content')
   <h1 class="text-center">{{$label_tournament}}</h1>
   <div class="team_display">
      @if($teamlist)
         <h3>Equipes inscrites</h3>
         @if($tournament->statut==2)
            <p>{{$tournament->teams_nb-$nb_teams }} place disponible</p>
         @endif
         <div id="team"><br>
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col"> Nom de l'équipe</th>
                     @if($tournament->statut==2)
                        <th scope="col"></th>
                     @endif
                     <th scope="col"></th>
                  </tr>
               </thead>
               <tbody>
               @foreach($teamlist as $team)
                  <tr>
                     <td>{{$team->label}}</td>
                     @if($tournament->statut==2)
                        <td>
                           <form action="{{route('delete_team' , ['label_tournament'=>$label_tournament,'nom_team'=>$team->label])}}" method="GET">
                              @csrf
                              <button type="submit" class="close">
                                 <span>&times;</span>
                              </button>
                           </form>
                        </td>
                     @endif
                     <td><a href="{{route('info_teams', ['label_tournament'=>$label_tournament,'nom_team'=>$team->label])}}">Information équipes</a></td>
                  </tr>
               @endforeach
            </table>
         </div>
      @else
         <h3>Aucune équipe inscrite dans ce tournoi</h3><br>
      @endif

      @if($tournament->teams_nb-$nb_teams !=0)
         <h3>Ajouter des équipes</h3>
         @if($teams_pending)
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">Équipes pré-inscrites</th>
                     <th scope="col"></th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($teams_pending as $team)
                     <tr>
                        <td>{{$team->label}}</td>
                        <td>
                           <form action="{{route('inscription',['label_tournament'=>$label_tournament,'nom_team'=>$team->label])}}" method="POST">
                              @csrf
                              <input type="submit" class="btn btn-outline-success" name="outlined" value="Confirm">
                              <input type="submit" class="btn btn-outline-danger" name="outlined" value="Reject">
                           </form>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         @else
            <p>Aucune équipe ne s'est pré-inscrite à ce tournoi</p>
         @endif
      @endif
   </div>
   

@stop
