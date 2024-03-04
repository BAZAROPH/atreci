@component('mail::message')
<div align="center">
<a href="https://www.atre.ci">
<img src="{{ asset('web/img/logo.png') }}" width="200">
</a>
</div><br>
<h1 style="text-align: center;">Bonjour {{ $suiveur['name'] }}</h1>
<div style="text-align: center;">{{ $suiveur['email'] }}</div>
<div style="border: 1px solid #ccc; margin-top: 20px; padding: 20px; text-align: center; border-radius: 20px;">
<h1 style="text-align: center">Merci pour votre inscription !</h1>
<a href="{{ url('profil') }}" class="button button-primary" target="_blank" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #fff; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #58b130; border-top: 10px solid #58b130; border-right: 18px solid #58b130; border-bottom: 10px solid #58b130; border-left: 18px solid #58b130;">Connectez-vous</a>
</div>
@endcomponent
