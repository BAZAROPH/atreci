@php($categorieEcommerce = categorieEcommerce(2))
@php($parametre = parametre_web())
@extends('web.layouts.app', [
    'title' => 'Page Introuvable - Erreur 404',
    'page' => 'error',
])
@section('content')
    <div class="container py-5 mb-lg-3">
        <div class="row justify-content-center pt-lg-4 text-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <img class="d-block mx-auto mb-5" src="{{ asset('web/img/pages/404.png') }}" width="340" alt="Erreur 404">
                <h1 class="h3">Erreur 404</h1>
                <h3 class="h5 font-weight-normal mb-4">
                    Nous n'arrivons pas à trouver la page que vous recherchez.
                </h3>
                <p class="font-size-md mb-4">
                    <u>Voici plutôt quelques liens utiles :</u>
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <a class="card h-100 border-0 box-shadow-sm" href="{{ url('/') }}">
                            <div class="card-body">
                                <div class="media align-items-center"><i class="czi-home text-primary h4 mb-0"></i>
                                    <div class="media-body pl-3">
                                        <h5 class="font-size-sm mb-0">Accueil</h5>
                                        <span class="text-muted font-size-ms">Retourner à la page d'accueil</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <a class="card h-100 border-0 box-shadow-sm" href="{{ url('advanced-search') }}">
                            <div class="card-body">
                                <div class="media align-items-center">
                                    <i class="czi-search text-success h4 mb-0"></i>
                                    <div class="media-body pl-3">
                                        <h5 class="font-size-sm mb-0">Rechercher</h5><span class="text-muted font-size-ms">Trouver facilement vos produits avec la recherche avancée</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <a class="card h-100 border-0 box-shadow-sm" href="{{ url('categories') }}">
                            <div class="card-body">
                                <div class="media align-items-center">
                                    <i class="czi-help text-info h4 mb-0"></i>
                                    <div class="media-body pl-3">
                                        <h5 class="font-size-sm mb-0">Catalogues de produits</h5>
                                        <span class="text-muted font-size-ms">Découvrez nos catalogues de produits</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
