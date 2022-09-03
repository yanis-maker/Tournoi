@extends('layouts.base')
@section('content')
<div class="content-2">
    <header>Bienvenue Bobeur</header>
    <form action="{{ url('login') }}" method="POST" >
        @csrf
        <div class="field-2">
            <span class="fa fa-user"></span>
            <input type="text" required placeholder="Adresse Email" name="email">
        </div>
        <div class="field-2 space">
            <span class="fa fa-lock"></span>
            <input type="password" class="password" required placeholder="Mot de Passe" name="password">
            <span class="show-btn">SHOW</span>
        </div>

       <div class="checkbox-field">
        <input class="form-check-input" type="checkbox" value="true" id="checkbox" name="remember"><label for="checkbox">  Se souvenir de  moi</label>
        </div>
        <div class="field-2">
            <input class="submit-btn"  type="submit" value="CONNEXION">
        </div>
        <div class="signup">
        Vous n’avez pas de compte ?
            <a href="{{ route('registration') }}">Inscrivez-vous!</a>
        </div>

    </form>
</div>

<script>
show_off();
</script>

@stop
