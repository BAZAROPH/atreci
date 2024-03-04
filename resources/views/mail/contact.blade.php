@component('mail::message')
<div align="center">
<a href="https://www.atre.ci">
<img src="{{ asset('web/img/logo.png') }}" width="200">
</a>
</div>
<h1 style="text-align: center">Vous avez un avez un nouveau message</h1>
<div style="text-align: center">Un visiteur a posé une préocupation</div>
<div style="border: 1px solid #ccc; margin-top: 20px; padding: 20px; text-align: center; border-radius: 20px;">
<h1 style="text-align: center">{{ $suiveur->libelle }}</h1>
<div>{{ $suiveur->email }}</div>
<br><p>{{ $suiveur->description }}</p>
</div>
@endcomponent
