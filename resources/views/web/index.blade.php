@php($categorieEcommerce = categorieEcommerce(2))
@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    {{-- <div class="modal-quick-view modal fade" id="quick-view-electro" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title product-title">
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Go to product page">
                            Smartwatch Youth Edition
                            <i class="czi-arrow-right font-size-lg ml-2"></i>
                        </a>
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Product gallery-->
                        <div class="col-lg-7 pr-lg-0">
                            <div class="cz-product-gallery">
                                <div class="cz-preview order-sm-2">
                                    <div class="cz-preview-item active" id="first">
                                        <img class="cz-image-zoom" src="{{ asset('web/img/shop/single/gallery/05.jpg') }}" data-zoom="{{ asset('web/img/shop/single/gallery/05.jpg') }}" alt="Product image">
                                        <div class="cz-image-zoom-pane"></div>
                                    </div>
                                    <div class="cz-preview-item" id="second">
                                        <img class="cz-image-zoom" src="{{ asset('web/img/shop/single/gallery/06.jpg') }}" data-zoom="{{ asset('web/img/shop/single/gallery/06.jpg') }}" alt="Product image">
                                        <div class="cz-image-zoom-pane"></div>
                                    </div>
                                    <div class="cz-preview-item" id="third"><img class="cz-image-zoom" src="{{ asset('web/img/shop/single/gallery/07.jpg') }}" data-zoom="{{ asset('web/img/shop/single/gallery/07.jpg') }}" alt="Product image">
                                        <div class="cz-image-zoom-pane"></div>
                                    </div>
                                    <div class="cz-preview-item" id="fourth">
                                        <img class="cz-image-zoom" src="{{ asset('web/img/shop/single/gallery/08.jpg') }}" data-zoom="{{ asset('web/img/shop/single/gallery/08.jpg') }}" alt="Product image">
                                        <div class="cz-image-zoom-pane"></div>
                                    </div>
                                </div>
                                <div class="cz-thumblist order-sm-1">
                                    <a class="cz-thumblist-item active" href="#first">
                                        <img src="{{ asset('web/img/shop/single/gallery/th05.jpg') }}" alt="Product thumb">
                                    </a>
                                    <a class="cz-thumblist-item" href="#second">
                                        <img src="{{ asset('web/img/shop/single/gallery/th06.jpg') }}" alt="Product thumb">
                                    </a>
                                    <a class="cz-thumblist-item" href="#third">
                                        <img src="{{ asset('web/img/shop/single/gallery/th07.jpg') }}" alt="Product thumb">
                                    </a>
                                    <a class="cz-thumblist-item" href="#fourth">
                                        <img src="{{ asset('web/img/shop/single/gallery/th08.jpg') }}" alt="Product thumb">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Product details-->
                        <div class="col-lg-5 pt-4 pt-lg-0 cz-image-zoom-pane">
                            <div class="product-details ml-auto pb-3">
                                <div class="mb-2">
                                    <div class="star-rating">
                                        <i class="sr-star czi-star-filled active"></i>
                                        <i class="sr-star czi-star-filled active"></i>
                                        <i class="sr-star czi-star-filled active"></i>
                                        <i class="sr-star czi-star-filled active"></i>
                                        <i class="sr-star czi-star"></i>
                                    </div>
                                    <span class="d-inline-block font-size-sm text-body align-middle mt-1 ml-1">
                                        74 Reviews
                                    </span>
                                </div>
                                <div class="h3 font-weight-normal text-accent mb-3 mr-1">
                                    $124.<small>99</small>
                                </div>
                                <div class="font-size-sm mb-4">
                                    <span class="text-heading font-weight-medium mr-1">Color:</span>
                                    <span class="text-muted">Dark blue/Orange</span>
                                </div>
                                <div class="position-relative mr-n4 mb-3">
                                    <div class="custom-control custom-option custom-control-inline mb-2">
                                        <input class="custom-control-input" type="radio" name="color" id="color1" checked>
                                        <label class="custom-option-label rounded-circle" for="color1">
                                            <span class="custom-option-color rounded-circle" style="background-color: #f25540;"></span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-option custom-control-inline mb-2">
                                        <input class="custom-control-input" type="radio" name="color" id="color2">
                                        <label class="custom-option-label rounded-circle" for="color2">
                                            <span class="custom-option-color rounded-circle" style="background-color: #65805b;"></span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-option custom-control-inline mb-2">
                                        <input class="custom-control-input" type="radio" name="color" id="color3">
                                        <label class="custom-option-label rounded-circle" for="color3">
                                            <span class="custom-option-color rounded-circle" style="background-color: #f5f5f5;"></span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-option custom-control-inline mb-2">
                                        <input class="custom-control-input" type="radio" name="color" id="color4">
                                        <label class="custom-option-label rounded-circle" for="color4">
                                            <span class="custom-option-color rounded-circle" style="background-color: #333;"></span>
                                        </label>
                                    </div>
                                    <div class="product-badge product-available mt-n1">
                                        <i class="czi-security-check"></i>Product available
                                    </div>
                                </div>
                                <div class="d-flex align-items-center pt-2 pb-4">
                                    <select class="custom-select mr-3" style="width: 5rem;">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <button class="btn btn-primary btn-shadow btn-block" type="button">
                                        <i class="czi-cart font-size-lg mr-2"></i>Add to Cart
                                    </button>
                                </div>
                                <div class="d-flex mb-4">
                                    <div class="w-100 mr-3">
                                        <button class="btn btn-secondary btn-block" type="button">
                                            <i class="czi-heart font-size-lg mr-2"></i>
                                            <span class='d-none d-sm-inline'>Add to </span>Wishlist
                                        </button>
                                    </div>
                                    <div class="w-100">
                                        <button class="btn btn-secondary btn-block" type="button">
                                            <i class="czi-compare font-size-lg mr-2"></i>Compare
                                        </button>
                                    </div>
                                </div>
                                <h5 class="h6 mb-3 py-2 border-bottom">
                                    <i class="czi-announcement text-muted font-size-lg align-middle mt-n1 mr-2"></i>
                                    Product info
                                </h5>
                                <h6 class="font-size-sm mb-2">General</h6>
                                <ul class="font-size-sm pb-2">
                                    <li><span class="text-muted">Model: </span>Amazfit Smartwatch</li>
                                    <li><span class="text-muted">Gender: </span>Unisex</li>
                                    <li><span class="text-muted">OS campitibility: </span>Android / iOS</li>
                                </ul>
                                <h6 class="font-size-sm mb-2">Physical specs</h6>
                                <ul class="font-size-sm pb-2">
                                    <li><span class="text-muted">Shape: </span>Rectangular</li>
                                    <li><span class="text-muted">Body material: </span>Plastics / Ceramics</li>
                                    <li><span class="text-muted">Band material: </span>Silicone</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <section class="bg-secondary py-4 pt-md-3">
        <div class="container py-xl-2">
            <div class="row">
                <div class="col-xl-9 order-xl-2">
                    {!! listing_post($parametre->type_id, $categorie_id = 196, $apparence_id = 5, $limit = null, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = '', $page = null, $additif = null, $restriction = []) !!}
                    {{-- <div class="cz-carousel cz-controls-static cz-dots-enabled cz-dots-light cz-dots-inside">
                        <div class="cz-carousel-inner" data-carousel-options='{"items": 1, "controls": true, "loop": true, "autoplayTimeout": 10000, "autoplay": true}'>
                            <div>
                                <div class="row align-items-center">
                                    <div class="col-md-12 order-md-2">
                                        <img class="d-block mx-auto" src="{{ asset('web/img/slider/1.jpg') }}" alt="atrê marché">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row align-items-center">
                                    <div class="col-md-12 order-md-2">
                                        <img class="d-block mx-auto" src="{{ asset('web/img/slider/2.jpg') }}" alt="atrê marché">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row align-items-center">
                                    <div class="col-md-12 order-md-2">
                                        <img class="d-block mx-auto" src="{{ asset('web/img/slider/3.jpg') }}" alt="atrê marché">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                @desktop
                <!-- Banner group-->
                <div class="col-xl-3 order-xl-2 pt-4 mt-3 mt-xl-0 pt-xl-0">
                    <div class="table-responsive" data-simplebar>
                        <div class="d-flex d-xl-block">
                            {{--  <a class="media w-100 align-items-center bg-faded-info rounded-lg pt-1 pl-2 mb-4 mr-4 mr-xl-0" href="#" style="min-width: 16rem;">
                                <img src="{{ asset('web/img/livraison.png') }}" width="100" alt="Banner">
                                <div class="media-body py-4 px-2">
                                    <h6 class="mb-2">
                                        <span class="font-weight-light">
                                            Livraison partout
                                        </span>
                                    </h6>
                                    <div class="text-danger font-size-sm">
                                        en Côte d'Ivoire dès le lendemain de 08h à 19h
                                        <i class="czi-arrow-right font-size-xs ml-1"></i>
                                    </div>
                                </div>
                            </a>
                            <a class="media w-100 align-items-center bg-faded-warning rounded-lg pt-1 pl-2 mb-4 mr-4 mr-xl-0" href="#" style="min-width: 16rem;">
                                <img src="{{ asset('web/img/paiement.png') }}" width="100" alt="Banner">
                                <div class="media-body py-4 px-2">
                                    <h6 class="mb-2">
                                        <span class="font-weight-light">
                                            Paiement
                                        </span>
                                    </h6>
                                    <div class="text-danger font-size-sm">
                                        <div><i class="icofont-check-circled"></i>
                                            Cash à la livraison
                                        </div>
                                        <div>
                                            <i class="icofont-check-circled"></i> Mobile money & carte
                                        </div>
                                    </div>
                                </div>
                            </a>  --}}
                            <!-- Vertical carousel + Loop + No dots -->
                            <div class="text-center text-white bg-danger p-1">
                                Offres fournisseurs
                            </div>
                            {!! listing_post($parametre->type_id, $categorie_id = 629, $apparence_id = 10, $limit = null, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = null, $additif = null, $restriction = []) !!}
                            {{-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a href="#">
                                            <img src="{{ url('web/img/marketplace/products/01.jpg') }}" alt="Marché de gros">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="#">
                                            <img src="{{ url('web/img/marketplace/products/02.jpg') }}" alt="Marché de gros">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="#">
                                            <img src="{{ url('web/img/marketplace/products/03.jpg') }}" alt="Marché de gros">
                                        </a>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div> --}}
                            {{-- <div class="cz-carousel">
                                <div class="cz-carousel-inner" data-carousel-options='{"axis": "vertical", "nav": false, "autoplayTimeout": 5000, "autoplay": true}'>
                                    <a href="#">
                                        <img src="{{ url('web/img/marketplace/products/01.jpg') }}" alt="Marché de gros">
                                    </a>
                                    <a href="#">
                                        <img src="{{ url('web/img/marketplace/products/02.jpg') }}" alt="Marché de gros">
                                    </a>
                                    <a href="#">
                                        <img src="{{ url('web/img/marketplace/products/03.jpg') }}" alt="Marché de gros">
                                    </a>
                                </div>
                            </div> --}}

                            <div class="text-center text-white bg-success mt-1 p-1">
                                Demandes clients
                            </div>
                            {!! listing_post($parametre->type_id, $categorie_id = 631, $apparence_id = 10, $limit = null, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = null, $additif = null, $restriction = []) !!}
                            {{-- <div id="carouselExampleControls2" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a href="#">
                                            <img src="{{ url('web/img/marketplace/products/04.jpg') }}" alt="Marché de gros">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="#">
                                            <img src="{{ url('web/img/marketplace/products/05.jpg') }}" alt="Marché de gros">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="#">
                                            <img src="{{ url('web/img/marketplace/products/06.jpg') }}" alt="Marché de gros">
                                        </a>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div> --}}
                            {{-- <div class="cz-carousel">
                                <div class="cz-carousel-inner" data-carousel-options='{"axis": "vertical", "nav": false, "autoplayTimeout": 4500, "autoplay": true}'>
                                    <a href="#">
                                        <img src="{{ url('web/img/marketplace/products/04.jpg') }}" alt="Marché de gros">
                                    </a>
                                    <a href="#">
                                        <img src="{{ url('web/img/marketplace/products/05.jpg') }}" alt="Marché de gros">
                                    </a>
                                    <a href="#">
                                        <img src="{{ url('web/img/marketplace/products/06.jpg') }}" alt="Marché de gros">
                                    </a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                @enddesktop
            </div>
        </div>
    </section>
    <!-- Discounted products (Carousel)-->
    <section class="container pt-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
            <h2 class="h3 mb-0 pt-3 mr-3">Produits à prix réduit</h2>
            {{-- <div class="pt-3">
                <a class="btn btn-outline-danger btn-sm" href="#">
                    Voir plus
                    <i class="czi-arrow-right ml-1 mr-n1"></i>
                </a>
            </div> --}}
        </div>

        {!! listing_post($parametre->type_id, $categorie_id = 229, $apparence_id = 7, $limit = 10, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'prix_nouveau asc', $typeImage = 'thumb', $page = null) !!}
    </section>


    {{-- @php(dd($categorieEcommerce->first()->toArray())) --}}
    {{-- @php($i = 0)
    @foreach ($categorieEcommerce->first()->childrens as $item)
        @if (count($item->posts))
            <section class="container pt-5">
                <!-- Heading-->
                <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
                    <h2 class="h3 mb-0 pt-3 mr-2">
                        {{ $item->libelle }}
                    </h2>
                    <div class="pt-3">
                        <a class="btn btn-outline-danger btn-sm" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                            Voir plus
                            <i class="czi-arrow-right ml-1 mr-n1"></i>
                        </a>
                    </div>
                </div>
                {!! listing_post($parametre->type_id, $categorie_id = $item->id, $apparence_id = 28, $limit = 8, $column = 'col-lg-3 col-md-4 col-sm-6 col-6', $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = null) !!}
            </section>
        @endif
    @endforeach --}}

    @php($i = 0)
    @php($k = 0)
    @foreach ($categorieEcommerce->first()->childrens as $item)
        @php($i++)
        @php($k++)
        @if ($k == 7)
            @break
        @endif
        @if ($i == 1)
            @php($coteImage = 'order-md-1')
            @php($coteProduit = 'order-md-1')
        @else
            @php($coteImage = 'order-md-1')
            @php($coteProduit = 'order-md-1')
        @endif
        @if ($i == 2)
            @php($i = 0)
        @endif
        @if (count($item->posts))
            <section class="container pt-lg-3 mb-4 mt-5 mb-sm-5">
                <div class="row">
                    <div class="col-md-5 border border-success {{ $coteImage }}">
                        <div class="d-flex flex-column h-100 overflow-hidden rounded-lg" style="background-color: #f6f8fb;">
                            <div class="d-flex justify-content-between px-grid-gutter py-grid-gutter">
                                <div>
                                    <h1 class="mb-1 font-weight-bolder" style="color: #58b130; font-size:">
                                        {{ $item->libelle }}
                                    </h1>
                                    <a class="font-size-md" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                        Voir plus
                                        <i class="czi-arrow-right font-size-xs align-middle ml-1"></i>
                                    </a>
                                </div>
                                <div class="cz-custom-controls" id="{{ $item->slug }}">
                                    <button type="button"><i class="czi-arrow-left"></i></button>
                                    <button type="button"><i class="czi-arrow-right"></i></button>
                                </div>
                            </div>
                            <a class="d-none d-md-block mt-auto" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                <img class="d-block w-100" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="Atrê marché">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7 pt-4 pt-md-0 {{ $coteProduit }}">
                        {!! listing_post($parametre->type_id, $categorie_id = $item->id, $apparence_id = 8, $limit = 12, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = null, $additif = array('identify' => $item->slug, 'visibleMobile' => 1)) !!}
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    <!-- Products grid (Trending products)-->
    <section class="container pt-5">
        <!-- Heading-->
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
            <h2 class="h3 mb-0 pt-3 mr-2">Recommandé pour vous</h2>
            {{-- <div class="pt-3">
                <a class="btn btn-outline-danger btn-sm" href="{{ urlMode(url('recommander'), $parametre->type_id) }}">
                    Voir plus
                    <i class="czi-arrow-right ml-1 mr-n1"></i>
                </a>
            </div> --}}
        </div>

        <div class="row pt-2 mx-n2">
            {!! listing_post($parametre->type_id, $categorie_id = 229, $apparence_id = 6, $limit = 8, $column = 'col-lg-3 col-md-4 col-sm-6 col-6', $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = null) !!}
        </div>
    </section>

    <!-- Promo banner-->
    {{-- <section class="container mt-4 mb-grid-gutter">
        <div class="bg-faded-warning rounded-lg py-4">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="px-4 pr-sm-0 pl-sm-5">
                        <span class="badge badge-danger">Offres spéciales</span>
                        <h3 class="mt-4 mb-1 text-body font-weight-light">Vente Flash</h3>
                        <h2 class="mb-1">Panier déjà prêt</h2>
                        <p class="h5 text-body font-weight-light">
                            Faites votre marché en un clic
                        </p>
                        <div class="cz-countdown py-2 h4" data-countdown="08/02/2021 07:00:00 PM">
                            <div class="cz-countdown-days">
                                <span class="cz-countdown-value"></span>
                                <span class="cz-countdown-label text-muted">j</span>
                            </div>
                            <div class="cz-countdown-hours">
                                <span class="cz-countdown-value"></span>
                                <span class="cz-countdown-label text-muted">h</span>
                            </div>
                            <div class="cz-countdown-minutes">
                                <span class="cz-countdown-value"></span>
                                <span class="cz-countdown-label text-muted">m</span>
                            </div>
                            <div class="cz-countdown-seconds">
                                <span class="cz-countdown-value"></span>
                                <span class="cz-countdown-label text-muted">s</span>
                            </div>
                        </div>
                        <a class="btn btn-success" href="#">
                            Voir plus
                            <i class="czi-arrow-right font-size-ms ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <img src="{{ asset('web/img/package.png') }}" alt="atrê marché">
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Blog + Instagram info cards-->
    {{-- <section class="container-fluid px-0">
        <div class="row no-gutters">
            <div class="col-md-6">
                <a class="card border-0 rounded-0 text-decoration-none py-md-4 bg-faded-primary" href="#">
                    <div class="card-body text-center">
                        <i class="czi-edit h3 mt-2 mb-4 text-primary"></i>
                        <h3 class="h5 mb-1">
                            Recette du jour
                        </h3>
                        <p class="text-muted font-size-sm">
                            Faites vous plaisir avec nos recettes
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a class="card border-0 rounded-0 text-decoration-none py-md-4 bg-faded-accent" href="#">
                    <div class="card-body text-center">
                        <i class="czi-instagram h3 mt-2 mb-4 text-accent"></i>
                        <h3 class="h5 mb-1">Suivez nous Instagram</h3>
                        <p class="text-muted font-size-sm">atrê marché</p>
                    </div>
                </a>
            </div>
        </div>
    </section> --}}
    <!-- Toast: Added to Cart-->
    {{-- <div class="toast-container toast-bottom-center">
        <div class="toast mb-3" id="cart-toast" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="czi-check-circle mr-2"></i>
                <h6 class="font-size-sm text-white mb-0 mr-auto">
                    Ajouté au panier!
                </h6>
                <button class="close text-white ml-2 mb-1" type="button" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">Cet article a été ajouté à votre panier.</div>
        </div>
    </div> --}}
@endsection
