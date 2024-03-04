@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    @include('web.user.entete', [
        'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">'.$infosPage['title'].'</li>',
    ])
    <div class="container pb-5 mb-sm-4">
        <div class="pt-5">
            <div class="card py-3 mt-sm-3">
                <div class="card-body text-center">
                    <h2 class="h4 pb-3">Nous vous remercions de votre commande!</h2>
                    <p class="font-size-sm mb-2">Votre commande a été passée et sera traitée dans les plus brefs délais.</p>
                    <p class="font-size-sm mb-2">
                        Assurez-vous de noter votre numéro de commande, qui est
                        <span class='font-weight-medium'>{{ $commande->reference }}</span>
                    </p>
                    <p class="font-size-sm">
                        Vous recevrez sous peu un e-mail avec la confirmation de votre commande.
                    </p>
                    <a class="btn btn-secondary mt-3 mr-3" href="{{ url('/') }}">Revenir aux achats</a>
                    <a class="btn btn-primary mt-3" href="{{ url('profil/commande?ref='.$commande->reference) }}">
                        <i class="czi-location"></i>&nbsp;Suivre la commande
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
