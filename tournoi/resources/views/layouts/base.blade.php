<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>La coupe de bob</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/login.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
          <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}"><img  class="logo" src="{{ asset('img/logo.png') }}" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNav">
              <ul class="navbar-nav justify-content-start">
                <li class="nav-item">
                  <a class="nav-link " href="{{ route('home') }}">Accueil</a>
                </li>
              </ul>
            <ul class="navbar-nav justify-content-end w-100 ">
                @if (Auth::check())
                    @switch(Auth::user()->permission)
                      @case(2)
                        <li class="nav-item">
                          <a class="nav-link " href="{{ route('dashboard-admin') }}">Admin</a>
                        </li>
                      @case(1)
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Gestionnaire</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{ route('dashboard-gestion') }}">Espace Gestionnaire</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href=" {{ route('registration_index') }} ">Saisir les rencontres</a></li>
                          <li><a class="dropdown-item" href="{{ route('register_score_index') }}">Saisir les scores</a></li>
                        </ul>
                      </li>
                      @endswitch
                      <li class="nav-item">
                        <a class="nav-link " href="{{ route('dashboard-captain') }}">Capitaine</a>
                      </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ route('logout') }}">Deconnexion</a>
                    </li>
                @else
                    <li class="nav-item">
                      <a class="nav-link " href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ route('registration') }}">Inscription</a>
                    </li>
                @endif
              </ul>
            </div>
          </div>
        </nav>

        <div class="container contenu">
            <br>
            @include('layouts.flash-message')
            <br/>
            @yield('content')
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    </body>
</html>
