@extends('layouts.base')
@section('content')


<h2>Espace Administrateur</h2>
<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Gestion des permissions
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">

          <div id="Perm">
            <form action="{{ url('admin')}}" method='POST'>
              @csrf
              <h4>Modifier la permission d'un utilisateur</h4>
              <div class='input-group'>
                <input type="email" class="form-control email-perm" requied placeholder="Saisir son adresse email" id="email" name="email">
                <input type="submit" class="btn btn-secondary btn-perm-captain" value="Capitaine" name="permission">
                <input type="submit"  class="btn btn-primary btn-perm-gestionnaire" value="Gestionnaire" name="permission">
              </div>
            </form>

            <br>
            <div id="captain_gestio">
              @if(count($user_permRequest)>0)
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h4>Les demandes de changement de permission</h4>
                        </div>
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Username</th>
                              <th scope="col">Email</th>
                            </tr>
                          </thead>
                          <body>
                            @foreach($user_permRequest as $user)
                              <tr>
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                              </tr>
                            @endforeach
                          </body>
                        </table>
                    </div>

                </div>

              @endif
            </div>
          </div>

      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Liste des Gestionnaires Disponibles
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
          <div id="Gestionnaire">

            <div id="gestDispo">
                @if(count($managerDispo)===0)
                    <h4>Pas de gestionnaire disponible</h4>
                @else
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            @if(count($managerDispo)===1)
                              <h4>Seulement 1 gestionnaire de disponible</h4>
                            @else
                             <h4>{{count($managerDispo)}} gestionnaires de disponibles</h4>
                            @endif
                        </div>



                    <table class="table">

                        <thead>
                              <tr>
                                <th scope="col">Nom d'utilisateur</th>
                                <th scope="col">Email</th>
                              </tr>
                        </thead>

                        <tbody>
                          @foreach($managerDispo as $dispo)
                          <tr>
                            <td>{{$dispo->username}}</td>
                            <td>{{$dispo->email}}</td>
                          </tr>
                          @endforeach
                          </tbody>

                    </table>

                    </div>
                </div>
                @endif
            </br>

            </div>

            <div id="GestAll">
                <div class="card">
                    <div class="card-body">
                        <div class="div-title">
                            <h4>Liste de tous les gestionnaires</h4>
                        </div>

                        <table class="table">

                            <thead>
                                  <tr>
                                    <th scope="col">Nom d'utilisateur</th>
                                    <th scope="col">Email</th>
                                  </tr>
                            </thead>

                            <tbody>
                            @foreach($Manager as $dispo)
                            <tr>
                              <td>{{$dispo->username}}</td>
                              <td>{{$dispo->email}}</td>
                           </tr>
                            @endforeach
                          </tbody>

                        </table>

                    </div>

                </div>



            </div>
          </div>

      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Créer un Tournoi
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
          <div id="CreaTournoi">
            <form action="{{url('create')}}" method="post">
              @csrf

              <div class="mb-3">
                <label for="InputNom" class="form-label">Nom du Tournoi</label>
                <input type="text" class="form-control" id="InputNom" name="nom">
              </div>

              <div class="mb-3">
                <label for="InputEmail" class="form-label">Adresse Email Gestionnaire</label>
                <input type="email" class="form-control" id="InputEmail" name="email">
              </div>

              <div class="mb-3">
                <label for="date_start" class="form-label">Debut</label>
                <input type="date" class="form-control" id="date_start"  name="date_start">
              </div>

              <div class="mb-3">
                <label for="date_end" class="form-label">Fin</label>
                <input type="date" class="form-control" id="date_end" name="date_end">
              </div>

              <div class="mb-3">
                <label for="InputEmplacement" class="form-label">Emplacement</label>
                <input type="text" class="form-control" id="InputEmplacement" name="location">
              </div>

              <div class="mb-3">
                  <select id="inte" class="form-select" name="team_nb">
                    <option type="number" value="">--Choisissez le nombre d'équipes--</option>
                    <option value="4">4</option>
                    <option value="8">8</option>
                    <option value="16">16</option>
                    <option value="32">32</option>
                  </select>
              </div>

                <input type="submit" class="btn btn-primary" value="Créer">
            </form>

          </div>
      </div>
    </div>
  </div>
</div>



<script src="{{ asset('js/admin.js') }}"></script>
@stop
