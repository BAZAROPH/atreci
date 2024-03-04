@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')

    <div class="modal fade" id="clean-cart" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Vider panier</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="font-size-sm alert alert-danger text-center">
                        Voulez-vous vraiment vider le panier
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Fermer</button>
                    <a href="{{ url('panier?clean=1') }}" class="btn btn-danger btn-shadow btn-sm">
                        <i class="icofont-trash"></i> Vider
                    </a>
                </div>
            </div>
        </div>
    </div>

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
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Panier</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                <h1 class="h3 text-light mb-0">Votre panier ({{ Cart::instance('shopping')->count() }})</h1>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <!-- List of items-->
            <section class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center pt-3 pb-2 pb-sm-5 mt-1">
                    @if (count(Cart::instance('shopping')->content()))
                        <h2 class="h6 text-light mb-0">
                            <a class="btn btn-danger btn-sm pl-2" href="#clean-cart" data-toggle="modal">
                                <i class="icofont-trash mr-2"></i>Vider le panier
                            </a>
                        </h2>
                    @endif
                    <a class="btn btn-success btn-sm pl-2" href="{{ url('/') }}">
                        <i class="czi-arrow-left mr-2"></i>Poursuivre vos achats
                    </a>
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

                <form name="form1" method="get" action="">
                    @csrf
                    @foreach (Cart::instance('shopping')->content() as $item)
                        @php($post = detailPanier($item->id))
                        @php($capacite = traitementCategory($post, 'capacite'))
                        @php($subdivision = traitementCategory($post, 'subdivision'))
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
                                    {{--  <div class="font-size-sm"><span class="text-muted mr-2">Size:</span>8.5</div>
                                    <div class="font-size-sm"><span class="text-muted mr-2">Color:</span>White &amp; Blue</div>  --}}
                                    <div>
                                        <a class="btn btn-link px-0 text-danger" href="{{ url('panier?rowId='.$item->rowId) }}">
                                            <i class="icofont-trash mr-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 7.5rem;">
                                <div class="form-group mb-0">
                                    {{-- <input class="form-control" type="number" id="quantity1" value="{{ $item->qty }}"> --}}
                                    <select name="{{ $item->id }}" class="form-control" onChange="this.form.submit()">
                                        @php($n = 0)
                                        @for ($j = $subdivision->sous_titre; $j <= 50; ($j += $subdivision->sous_titre))
                                            <option value="{{ $j }}" @if($item->qty == $j) selected @endif>
                                                {{ ((int)$j > 0) ? (int)$j : '' }}

                                                @if ($subdivision->libelle == 'Quart')
                                                    @php($indice = 4)
                                                @else
                                                    @php($indice = 2)
                                                @endif
                                                @if (!isInteger($j))
                                                    @if ($subdivision->libelle == 'Quart' or $subdivision->libelle == 'Demi')
                                                        @php($n++)
                                                        {{ ((int)$j > 0) ? '+' : '' }}
                                                        @if ($subdivision->libelle == 'Quart')
                                                            @if($n == $indice)
                                                                {{ $n/$indice.'/'.$indice }}
                                                            @else
                                                                @if ($n == 2)
                                                                    {{ ($n/2).'/'.($indice/2) }}
                                                                @else
                                                                    {{ $n.'/'.$indice }}
                                                                @endif
                                                            @endif
                                                            @php($indice = 3)
                                                        @else
                                                            @if($n == $indice)
                                                                {{ $n/$indice.'/'.$indice }}
                                                            @else
                                                                {{ $n.'/'.$indice }}
                                                            @endif
                                                        @endif
                                                        @if($n == $indice)
                                                            @php($n = 0)
                                                        @endif
                                                    @endif
                                                @endif
                                            </option>
                                        @endfor
                                    </select>
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
                </form>
                {{--  <button class="btn btn-outline-accent btn-block" type="button">
                    <i class="czi-loading font-size-base mr-2"></i>Update cart
                </button>  --}}
            </section>
            @include('web.cart.recapitulatif')
        </div>
    </div>
@endsection
