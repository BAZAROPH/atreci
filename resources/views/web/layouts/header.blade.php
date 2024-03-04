@include('web.layouts.auth')
@include('flash::message')
<header class="box-shadow-sm">
    @desktop
        {{-- <div class="text-center">
            <a href="#">
                <img src="{{ asset('web/img/btp.jpg') }}" alt="atrê BTP" width="40" class="grayscale">
            </a>
            <span class="principal">
                <img src="{{ asset('web/img/logo.png') }}" alt="atrê marché" width="50">
            </span>

            <a href="#">
                <img src="{{ asset('web/img/com.png') }}" alt="atrê Com" width="40" class="grayscale">
            </a>
        </div> --}}
        <!-- Topbar-->
        <div class="topbar topbar-danger bg-danger">
            @hasanyrole('superadmin|admin')
                <div class="float-left">
                    <a class="btn btn-sm btn-danger" href="{{ url('celestadmin') }}" target="_blank">Admin</a>
                </div>
            @endhasanyrole
            <div class="container">
                <div class="topbar-text dropdown d-md-none">
                    <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Contacts
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="tel:+225 0709096551">
                                <i class="czi-support text-muted mr-2"></i>(+225) 07 09 09 65 51
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="czi-mail text-muted mr-2"></i>
                                <a href="mailto:info@atre.ci">info@atre.ci</a>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topbar-text text-nowrap d-none d-md-inline-block">
                    {!! listing_post($parametre->type_id, $categorie_id = 632, $apparence_id = 15, $limit = null, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = null, $additif = null, $restriction = [54]) !!}
                </div>
                {!! listing_post($parametre->type_id, $categorie_id = 633, $apparence_id = 11, $limit = null, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = null) !!}
                {{-- <div class="cz-carousel cz-controls-static d-none d-md-block">
                    <div class="cz-carousel-inner" data-carousel-options="{&quot;mode&quot;: &quot;gallery&quot;, &quot;nav&quot;: false}">
                        <div class="topbar-text">Bannière d'annonce 1</div>
                        <div class="topbar-text">Bannière d'annonce 2</div>
                        <div class="topbar-text">Bannière d'annonce 3</div>
                    </div>
                </div> --}}
                {{-- <div class="ml-3 text-nowrap">
                    <a class="topbar-link mr-4 d-md-inline-block" href="#">
                        <i class="czi-location"></i>Suivi de commande
                    </a>
                    {{--  <div class="topbar-text dropdown disable-autohide">
                        <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <img class="mr-2" width="20" src="img/flags/en.png" alt="English"/>
                            Eng / $
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item">
                                <select class="custom-select custom-select-sm">
                                <option value="usd">$ USD</option>
                                <option value="eur">€ EUR</option>
                                <option value="ukp">£ UKP</option>
                                <option value="jpy">¥ JPY</option>
                                </select>
                            </li>
                            <li>
                                <a class="dropdown-item pb-1" href="#">
                                    <img class="mr-2" width="20" src="img/flags/fr.png" alt="Français"/>Français
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item pb-1" href="#">
                                    <img class="mr-2" width="20" src="img/flags/de.png" alt="Deutsch"/>
                                    Deutsch
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <img class="mr-2" width="20" src="img/flags/it.png" alt="Italiano"/>
                                    Italiano
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    @enddesktop
    <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
    <div class="navbar-sticky bg-light">
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                @desktop
                    <a class="navbar-brand d-none d-sm-block mr-3 flex-shrink-0" href="{{ url('/') }}" style="min-width: 7rem;">
                        @if(!empty($parametre->getMedia('logo')->first()))
                            <img src="{{ url($parametre->getMedia('logo')->first()->getUrl('thumb')) }}" alt="{{ config('app.name') }}" width="142">
                            {{--  <img width="142" src="{{ asset('web/img/logo.png') }}" alt="atrê marché" />  --}}
                        @endif
                    </a>
                    <a class="navbar-brand d-sm-none mr-2" href="{{ url('/') }}" style="min-width: 4.625rem;">
                        @if(!empty($parametre->getMedia('logo')->first()))
                            <img src="{{ url($parametre->getMedia('logo')->first()->getUrl('thumb')) }}" alt="{{ config('app.name') }}" width="74">
                            {{--  <img width="74" src="{{ asset('web/img/logo.png') }}" alt="atrê marché" />  --}}
                        @endif
                    </a>
                    <!-- Search-->
                    <form action="{{ route('search') }}" method="get" style="width: 50%;">
                        @csrf
                        <div class="input-group-overlay d-none d-lg-block mx-4">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text"><i class="czi-search"></i></span>
                            </div>
                            <input value="{{ old('term_search') }}" name="term_search" class="form-control prepended-form-control appended-form-control" type="text" placeholder="Recherchez un produit">
                            <div class="input-group-append-overlay">
                                <select class="custom-select" name="category_name">
                                    <option value="">Catégories</option>
                                    @foreach ($categorieEcommerce->first()->childrens as $item)
                                        <option {{ ($item->id == old('category_name')) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group-append-overlay">
                                <button type="submit" class="form-control">
                                    <i class="icofont-search-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                @enddesktop

                <!-- Toolbar-->
                <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sideNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-tool navbar-stuck-toggler" href="#">
                        <span class="navbar-tool-tooltip">Menu</span>
                        <div class="navbar-tool-icon-box">
                            <i class="navbar-tool-icon czi-menu"></i>
                        </div>
                    </a>
                    <!-- Search-->
                    <form action="{{ route('search') }}" method="get" style="width: 50%;">
                        @csrf
                        <div class="input-group-overlay d-lg-none my-3">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text"><i class="czi-search"></i></span>
                            </div>
                            <input value="{{ old('term_search') }}" name="term_search" class="form-control prepended-form-control" type="text" placeholder="Recherchez un produit">
                        </div>
                    </form>
                    <a class="navbar-tool d-none d-lg-flex" href="{{ url('wishlist') }}">
                        <span class="navbar-tool-tooltip">Liste d'envies</span>
                        <div class="navbar-tool-icon-box">
                            <i class="navbar-tool-icon czi-heart"></i>
                        </div>
                    </a>
                    @guest
                        @desktop
                        <a class="navbar-tool ml-1 ml-lg-0 mr-n1 mr-lg-2" href="#signin-modal" data-toggle="modal">
                            <div class="navbar-tool-icon-box">
                                <i class="navbar-tool-icon czi-user"></i>
                            </div>
                            <div class="navbar-tool-text ml-n3">
                                <small>Salut, inscrivez-vous</small>Mon compte
                            </div>
                        </a>
                        @enddesktop
                    @else
                        <div class="navbar-tool dropdown ml-3">
                            <a class="navbar-tool-text" href="#">
                                <i class="navbar-tool-icon czi-user"></i>
                                Salut {{ auth()->user()->prenom }}
                                {{ auth()->user()->name }}
                            </a>
                            <!-- Cart dropdown-->
                            <div class="dropdown-menu dropdown-menu-right font-size-sm" style="width: 12rem;">
                                <div class="d-flex flex-wrap justify-content-between align-items-center p-2">
                                    <a href="{{ url('profil') }}">
                                        <i class="icofont-user"></i> Votre compte
                                    </a>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between align-items-center p-2">
                                    <a href="{{ url('profil/commande') }}">
                                        <i class="icofont-shopping-cart"></i> Vos commandes
                                    </a>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between align-items-center p-2">
                                    <a class="btn btn-danger btn-sm btn-block" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="icofont-ui-power"></i> Déconnexion
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest

                    <div class="navbar-tool dropdown ml-3">
                        <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{ url('panier') }}">
                            <span class="navbar-tool-label">{{ Cart::instance('shopping')->count() }}</span>
                            <i class="navbar-tool-icon czi-cart"></i>
                        </a>
                        <a class="navbar-tool-text" href="{{ url('panier') }}">
                            <small>Panier</small>{{ devise(Cart::instance('shopping')->subtotal()) }}
                        </a>
                        <!-- Cart dropdown-->
                        <div class="dropdown-menu dropdown-menu-right" style="width: 20rem;">
                            <div class="widget widget-cart px-3 pt-2 pb-3">
                                <div style="height: 15rem;" data-simplebar data-simplebar-auto-hide="false">
                                    @foreach (Cart::instance('shopping')->content() as $item)
                                        @php($post = detailPanier($item->id))
                                        @if ($post)
                                            <div class="widget-cart-item pb-2 border-bottom">
                                                {{--  <button class="close text-danger" type="button" aria-label="Remove">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>  --}}
                                                <div class="media align-items-center">
                                                    <a class="d-block mr-2" href="{{ url($post->slug) }}">
                                                        @if(!empty($post->getMedia('image')->first()))
                                                            <img width="80" src="{{ url($post->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                                                        @endif
                                                    </a>
                                                    <div class="media-body">
                                                        <h6 class="widget-product-title">
                                                            <a href="{{ url($post->slug) }}">{{ $item->name }}</a>
                                                        </h6>
                                                        <div class="widget-product-meta">
                                                            <span class="text-accent mr-2">
                                                                @php($capacite = traitementCategory($post, 'capacite'))
                                                                {{ number_format($post->prix_nouveau, 0, '.', ' ').' Fcfa/'.$capacite->sous_titre }}
                                                            </span>
                                                            <span class="text-muted">{{ $item->qty }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    {{--  <div class="widget-cart-item py-2 border-bottom">
                                        <button class="close text-danger" type="button" aria-label="Remove">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="media align-items-center">
                                            <a class="d-block mr-2" href="#">
                                                <img width="64" src="{{ asset('web/img/product/concombre.jpg') }}" alt="atrê marché" />
                                            </a>
                                            <div class="media-body">
                                                <h6 class="widget-product-title">
                                                    <a href="#">Concombre</a>
                                                </h6>
                                                <div class="widget-product-meta">
                                                    <span class="text-accent mr-2">12 000 Fcfa
                                                    </span>
                                                    <span class="text-muted">x 1</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-cart-item py-2 border-bottom">
                                        <button class="close text-danger" type="button" aria-label="Remove">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="media align-items-center">
                                            <a class="d-block mr-2" href="#">
                                                <img width="64" src="{{ asset('web/img/product/cotelette-porc.jpg') }}" alt="atrê marché" />
                                            </a>
                                            <div class="media-body">
                                                <h6 class="widget-product-title">
                                                    <a href="#">Cotelette de porc sans os</a>
                                                </h6>
                                                <div class="widget-product-meta">
                                                    <span class="text-accent mr-2">2 000 Fcfa
                                                    </span>
                                                    <span class="text-muted">x 1</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-cart-item py-2 border-bottom">
                                        <button class="close text-danger" type="button" aria-label="Remove">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="media align-items-center">
                                            <a class="d-block mr-2" href="#">
                                                <img width="64" src="{{ asset('web/img/product/tomate-fraiche.jpg') }}" alt="atrê marché" />
                                            </a>
                                            <div class="media-body">
                                                <h6 class="widget-product-title">
                                                    <a href="#">Tomate fraiche</a>
                                                </h6>
                                                <div class="widget-product-meta">
                                                    <span class="text-accent mr-2">2 000 Fcfa
                                                    </span>
                                                    <span class="text-muted">x 1</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  --}}
                                </div>
                                <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                                    <div class="font-size-sm mr-2 py-2">
                                        <span class="text-muted">Sous total : </span>
                                        <span class="text-accent font-size-base ml-1">
                                            {{ Cart::instance('shopping')->subtotal() }} Fcfa
                                        </span>
                                    </div>
                                    {{--  <a class="btn btn-outline-secondary btn-sm" href="#">
                                        Expand cart<i class="czi-arrow-right ml-1 mr-n1"></i>
                                    </a>  --}}
                                </div>
                                <a class="btn btn-danger btn-sm btn-block" href="{{ url('panier') }}">
                                    <i class="czi-card mr-2 font-size-base align-middle"></i>
                                    Commander
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('web.layouts.navbar')
    </div>
</header>
@include('web.layouts.aside')
