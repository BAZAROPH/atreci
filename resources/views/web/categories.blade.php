@php($categorieEcommerce = categorieEcommerce(2))
@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'categories',
])
@section('content')
<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item">
                        <a class="text-nowrap" href="{{ url('/') }}">
                            <i class="czi-home"></i>Accueil
                        </a>
                    </li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">
                        {{ $infosPage['title'] }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 text-light mb-0">{{ $infosPage['title'] }}</h1>
        </div>
    </div>
</div>


        <div class="container pb-4 pb-sm-5">
            <!-- Categories grid-->
            <div class="row pt-5">
                <!-- Catogory-->
                 <!-- boucle qui affiches toutes les categories et les sous categories de produits-->
                @foreach ($categorieEcommerce->first()->childrens as $item)
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card border-0">
                            <div class="produit-img">
                                <a class="d-block overflow-hidden rounded-lg" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                    @if($item->getMedia('image')->first())
                                        <img class="d-block img-fluid"  src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="atrê marché">
                                    @endif
                                </a>
                            </div>
                            <div class="card-body">
                                <h2 class="h5">{{ $item->libelle }}</h2>
                                <ul class="list-unstyled font-size-sm mb-0">
                                    @php($i = 0)
                                    @foreach ($item->childrens as $valeur)
                                        @php($i++)
                                        <li class="d-flex align-items-center justify-content-between">
                                            <a class="nav-link-style" href="{{ urlMode(url('category/'.$valeur->slug), $parametre->type_id) }}">
                                                <i class="czi-arrow-right-circle mr-2"></i>
                                                {{ $valeur->libelle }}
                                            </a>
                                            <span class="font-size-ms text-muted">
                                                {{ count($valeur->posts) }}
                                            </span>
                                        </li>
                                    @endforeach
                                    <li>
                                        <hr>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <a class="nav-link-style" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                            <i class="czi-arrow-right-circle mr-2"></i>Voir tous
                                        </a>
                                        <span class="font-size-ms text-muted">{{ count($item->posts) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
@endsection














