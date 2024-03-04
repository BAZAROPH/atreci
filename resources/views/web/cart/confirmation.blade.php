@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    @include('web.user.entete', [
        'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">'.$infosPage['title'].'</li>',
    ])
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <section class="col-lg-8">
                <!-- Steps-->
                <div class="steps steps-light pt-2 pb-3 mb-5">
                    <a class="step-item active" href="{{ url('/panier') }}">
                        <div class="step-progress">
                            <span class="step-count">1</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-cart"></i>Panier
                        </div>
                    </a>

                    <a class="step-item active" href="{{ url('adresse-de-livraison') }}">
                        <div class="step-progress">
                            <span class="step-count">2</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-google-map"></i>Adresse
                        </div>
                    </a>

                    <a class="step-item active" href="{{ url('date-de-livraison') }}">
                        <div class="step-progress">
                            <span class="step-count">3</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-ui-calendar"></i>Date & heure
                        </div>
                    </a>

                    <a class="step-item active" href="{{ url('mode-de-paiement') }}">
                        <div class="step-progress">
                            <span class="step-count">4</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-card"></i>Paiement
                        </div>
                    </a>
                    <span class="step-item active current" href="{{ url('') }}">
                        <div class="step-progress">
                            <span class="step-count">5</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-check-circle"></i>Résumé
                        </div>
                    </span>
                </div>
                @include('flash::message')
                @if (count(Cart::instance('shopping')->content()))
                    <div class="d-sm-flex justify-content-between align-items-center my-4 pb-3 border-bottom d-none">
                        <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="width: 25rem;">
                            Articles
                        </div>
                        <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 9rem;">
                            Quantité
                        </div>
                        <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 5rem;">
                            Prix unitaire
                        </div>
                        <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 9rem;">
                            Sous-total
                        </div>
                    </div>
                @else
                    <div>
                        <div class="text-center text-white bg-danger border m-auto p-2 pt-4" style="border-radius: 100%; border: solid 3px; width: 150px; height:140px;">
                            <i class="icofont-shopping-cart fa-5x"></i>
                        </div>
                        <h3 class="font-weight-bold text-center">Panier vide</h3>
                    </div>
                @endif

                @foreach (Cart::instance('shopping')->content() as $item)
                    @php($post = detailPanier($item->id))
                    @php($capacite = traitementCategory($post, 'capacite'))
                    @php($subdivision = traitementCategory($post, 'subdivision'))
                    @php($categorie = traitementCategory($post, 'categorie'))
                    <div class="d-sm-flex justify-content-between align-items-center my-4 pb-3 border-bottom">
                        <div class="media media-ie-fix d-block d-sm-flex align-items-center text-center text-sm-left" style="width: 25rem;">
                            <a class="d-inline-block mx-auto mr-sm-4" href="{{ url($post->slug) }}">
                                @if(!empty($post->getMedia('image')->first()))
                                    <img width="80" src="{{ url($post->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                                @endif
                            </a>
                            <div class="media-body pt-2">
                                <h3 class="product-title font-size-base mb-2">
                                    <a href="{{ url($post->slug) }}">
                                        {{ $item->name }}
                                    </a>
                                </h3>
                                {{--  <div class="font-size-sm"><span class="text-muted mr-2">Size:</span>8.5</div>  --}}
                                <div class="font-size-sm">
                                    <span class="text-muted mr-2">Catégorie:</span>
                                    {{ $categorie->libelle }}
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 7.5rem;">
                            <div class="form-group mb-0">
                                {{ $item->qty }}
                                {{ $capacite->sous_titre }}
                            </div>
                        </div>
                        <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 9rem;">
                            <div class="pt-2">
                                <span class="mr-1">
                                    {{ number_format($post->prix_nouveau, 0, '.', ' ').' Fcfa' }}
                                </span>
                            </div>
                        </div>
                        <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 9rem;">
                            <div class="text-accent pt-2">
                                <span class="text-danger mr-1">
                                    {{ number_format(($post->prix_nouveau * $item->qty), 0, '.', ' ').' Fcfa' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Navigation (desktop)-->
                <div class="d-none d-lg-flex pt-4">
                    <div class="w-50 pr-3">
                        <a class="btn btn-secondary btn-block" href="{{ url('mode-de-paiement') }}">
                            <i class="czi-arrow-left mt-sm-0 mr-1"></i>
                            <span class="d-none d-sm-inline">Retouner au paiement</span>
                            <span class="d-inline d-sm-none">Retour</span>
                        </a>
                    </div>
                    <div class="w-50 pl-2">
                        <form name="form1" method="post" action="{{ url('confirmation') }}">
                            @csrf
                            <button class="btn btn-primary btn-block">
                                <span class="d-none d-sm-inline">Confirmer la commande</span>
                                <span class="d-inline d-sm-none">Confirmer</span>
                                <i class="czi-arrow-right mt-sm-0 ml-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </section>
            @include('web.cart.recapitulatif')
        </div>
    </div>
    <!-- Navigation (mobile)-->
    <div class="row d-lg-none">
        <div class="col-lg-8">
            <div class="d-flex mb-3">
                <div class="w-50 pr-3">
                    <a class="btn btn-secondary btn-block" href="{{ url('mode-de-paiement') }}">
                        <i class="czi-arrow-left mt-sm-0 mr-1"></i>
                        <span class="d-none d-sm-inline">Retouner au paiement</span>
                        <span class="d-inline d-sm-none">Retour</span>
                    </a>
                </div>
                <div class="w-50 pl-2">
                    <form name="form1" method="post" action="{{ url('confirmation') }}">
                        @csrf
                        <button class="btn btn-primary btn-block">
                            <span class="d-none d-sm-inline">Confirmer la commande</span>
                            <span class="d-inline d-sm-none">Confirmer</span>
                            <i class="czi-arrow-right mt-sm-0 ml-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
