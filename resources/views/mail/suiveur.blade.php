@component('mail::message')
<div align="center">
<a href="https://www.atre.ci">
<img src="{{ asset('web/img/logo.png') }}" width="200">
</a>
</div>
<h1 style="text-align: center">
Vous avez un nouveau suiveur
</h1>

<div style="border: 1px solid #ccc; margin-top: 20px; padding: 20px; text-align: center; border-radius: 20px;">
@php ($avatar = photo_user_connect(Auth::user()->id))
@if(!empty($avatar))
@if ($avatar->type_fichier_id == 22 or filter_var($avatar->libelle, FILTER_VALIDATE_URL))
<div style="overflow: hidden; width: 200px; height:200px; margin: auto;" align="center">
<img src="{{ $avatar->libelle }}" width="230" style="border-radius: 100%;">
</div>
@elseif ($avatar->type_fichier_id == 4)
<div style="overflow: hidden; width: 200px; height:200px; margin: auto;" align="center">
<img src="{{ url('storage/'.$avatar->libelle) }}" width="230" style="border-radius: 100%;">
</div>
@else
<div style="overflow: hidden; width: 200px; height:200px; margin: auto;" align="center">
<img src="https://secure.gravatar.com/avatar/84f5d9d1ef46ef10f843920f0bd779b1?s=150&#038;d=mm&#038;r=g" width="230" style="border-radius: 100%;">
</div>
@endif
@else
<div style="overflow: hidden; width: 200px; height:200px; margin: auto;" align="center">
<img src="https://secure.gravatar.com/avatar/84f5d9d1ef46ef10f843920f0bd779b1?s=150&#038;d=mm&#038;r=g" width="230" style="border-radius: 100%;">
</div>
@endif
<h2 style="text-align: center">{{ $suiveur->prenom }} {{ $suiveur->name }}</h2><br>

<a href="{{ url('author/'.$suiveur->slug) }}" class="button button-primary" target="_blank" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #fff; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #46b349; border-top: 10px solid #46b349; border-right: 18px solid #46b349; border-bottom: 10px solid #46b349; border-left: 18px solid #46b349;">Voir le profil</a>
</div>
</div>
@endcomponent
