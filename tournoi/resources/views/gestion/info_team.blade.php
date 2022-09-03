@extends('layouts.base')
@section('content')

    <div class="team">
        <h1>{{$nom}}</h1><br>
        <div class="capitaine">
            <h3>Informations</h3>
            Adresse : {{$team->adress}} <br>
            Téléphone : {{$team->phone}} <br>
            Email capitaine: {{$captain->email}} <br>
        </div>

        <div class="players">
            <h3>Joueurs</h3>
            <table class="table">
                <thread>
                    <tr>
                        <th scope="col">Prénom</th>
                        <th scope="col">Nom</th>
                    </tr>
                </thread>
                <tbody>    
                    @foreach($players as $player)
                        <tr>
                            <td>{{$player->firstName}}</td>
                            <td>{{$player->lastName}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop