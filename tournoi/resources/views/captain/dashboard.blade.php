@extends('layouts.base')

@section('content')
<div class="captain">
    <div class="gestion-btn">
        @if(Auth::user()->permission == 0 && Auth::user()->perm_request == false)
            <form action="{{ route('gestion.request') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger" >Devenir Gestionnaire</button>
            </form>
        @endif

        @if($team)
        <a class="btn btn-secondary" href="{{ route('registration.tournament') }}" >Pré-inscrire mon équipe à un tournoi</a>
        @endif
    </div>


    @if ($team)

    <h2>{{ $team->label }}</h2><br>

        <h3>Informations</h3>
        Adresse : {{ $team->address}}<br>
        Téléphone : {{$team->phone}}<br>
        Email capitaine : {{ Auth::user()->email }} <br><br>

        <button type="button" class="btn btn-success" onclick="VoirModif()" >Modifier mes Informations</button> <br><br>
        <div class="update-info" id="info" >
            <form action="{{ route('captain.update') }}" method="POST" >
                @csrf
                <div class="input-group mb-3">
                  <span class="input-group-text" id="phone-input">Téléphone</span>
                  <input type="text" class="form-control" name="phone" placeholder="{{ $team->phone }}" aria-describedby="phone-input">
                </div>

                <div class="input-group mb-3">
                  <span class="input-group-text" id="adress-input">Adresse</span>
                  <input type="text" class="form-control" name="address" placeholder="{{ $team->address }}" aria-describedby="adress-input">
                </div>

                <button type="submit" class="btn btn-danger">Modifier</button>
            </form>
        </div>
        <br><br><br>

        @if($players)
        <h3>Les joueurs de mon équipe</h3>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Prénom</th>
              <th scope="col">Nom</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
              @if( $count <= 1 )
                 {{ $count }} place disponible <br>
              @else
                {{ $count }} places disponibles<br>
              @endif



              @foreach ($players as $player)
                  <tr>
                    <td>{{ $player->firstName }}</td>
                    <td>{{ $player->lastName }}</td>
                    <td>
                        <form action="{{ route('player.delete', $player->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="close">
                                  <span>&times;</span>
                            </button>
                        </form>
                    </td>
                  </tr>
              @endforeach
          </tbody>
        </table><br><br>
        @else
            <h3>Pas de Joueurs dans mon équipe</h3>
        @endif

        @if($count != 0 )
        <h3>Ajouter des joueurs dans mon équipe : </h3>
          <form action="{{ route('player.add', $count) }}" method="POST" >
            @csrf
            @for ($i = 1; $i <= $count; $i++)
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Prénom" aria-label="Prenom" name="prenom-{{$i}}">
                    <span class="input-group-text">&</span>
                    <input type="text" class="form-control" placeholder="Nom" aria-label="Nom" name="nom-{{$i}}">
                </div>
            @endfor
            <button type="submit" class="btn btn-primary" >Ajouter</button>
        </form>
        @endif

    @else
        <h3>Créer mon équipe</h3><br>
        <form action="{{ route('team.creation') }}" method="post">
            @csrf
            <div class="input-group mb-3">
              <span class="input-group-text" id="name-team-input">Nom</span>
              <input type="text" class="form-control" name="name" aria-describedby="name-team-input">
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text" id="phone-input">Téléphone</span>
              <input type="text" class="form-control" name="phone" aria-describedby="phone-input">
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text" id="adress-input">Adresse</span>
              <input type="text" class="form-control" name="address" aria-describedby="adress-input">
            </div>

            <button type="submit" class="btn btn-primary">Créer</button>

        </form>

    @endif

    <br>
</div>
<script src="{{ asset('js/captain.js') }}"></script>
@stop
