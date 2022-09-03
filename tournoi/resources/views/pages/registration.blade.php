@extends('layouts.base')
@section('content')
<div class="content-2">
    <header>Rejoignez la place</header>
    <form action="{{ url('register') }}" method="POST" >
        @csrf
        <div class="field-2">
            <span class="fa fa-user"></span>
            <input type="text" required placeholder="Nom d'utilisateur" name="username">
        </div>
        <div class="field-2 space">
            <span class="fa fa-envelope"></span>
            <input type="text" required placeholder="Adresse Email" name="email">
        </div>
        <div class="field-2 space">
            <span class="fa fa-lock"></span>
            <input type="password" class="password" required placeholder="Mot de Passe" name="password">
            <span class="show-btn">SHOW</span>
        </div>
        <div class="field-2 space">
            <span class="fa fa-lock"></span>
            <input type="password" class="password" required placeholder="Confirmation du mot de Passe" name="password_confirmation">
        </div>
        <div class="checkbox-field">
        <input class="form-check-input" type="checkbox" value="true" id="checkbox" name="CGU"><label for="checkbox">  J'accepte les CGU</label>
        </div>

        <div class="field-2 space">
            <input class="submit-btn"  type="submit" value="S'INSCRIRE">
        </div>
        <div class="voir">
          <a href="{{ route('loi') }}"> ıllıllı Voir les CGU ıllıllı</a>
        </div>
        <div class="signup">
        Vous avez déjà un compte ?
            <a href="{{ route('login') }}">Connectez-vous!</a>
        </div>

    </form>

</div>
</div>

<script>
    show_off();
</script>
@stop
