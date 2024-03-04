@if (Cart::instance('shopping')->count() > 0)
    <aside class="col-lg-4 pt-4 pt-lg-0">
        <div class="cz-sidebar-static rounded-lg box-shadow-lg ml-lg-auto">
            @if (url()->current() != url('panier') and url()->current() != url('confirmation'))
                <div class="widget mb-3">
                    <h2 class="widget-title text-center">Récapitulatif de la commande</h2>
                    @foreach (Cart::instance('shopping')->content() as $item)
                        @php($post = detailPanier($item->id))
                        @php($capacite = traitementCategory($post, 'capacite'))
                        @php($subdivision = traitementCategory($post, 'subdivision'))
                        <div class="media align-items-center pb-2 border-bottom">
                            <a class="d-block mr-2" href="#">
                                @if(!empty($post->getMedia('image')->first()))
                                    <img width="64" src="{{ url($post->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                                @endif
                            </a>
                            <div class="media-body">
                                <h6 class="widget-product-title">
                                    <a href="#">{{ $item->name }}</a>
                                </h6>
                                <div class="widget-product-meta">
                                    <span class="text-accent mr-1">
                                        {{ number_format($post->prix_nouveau, 0, '.', ' ').' Fcfa' }}
                                    </span>
                                    <span class="text-muted">x {{ $item->qty }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <ul class="list-unstyled font-size-sm pb-2 border-bottom">
                <li class="d-flex justify-content-between align-items-center">
                    <span class="mr-2">Sous total:</span>
                    <span class="text-right">
                        @php(Cart::instance('shopping')->setGlobalTax(0))
                        {{ Cart::instance('shopping')->subtotal(0, ',', ' ') }} Fcfa
                        @php($livraison = coutLivraison(Cart::instance('shopping')->subtotal()))
                    </span>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span class="mr-2">Livraison:</span>
                    <span class="text-right">
                        {{ number_format($livraison, 0, '.', ' ') }} Fcfa
                    </span>
                </li>
                @isset($fraisPaiement)
                    <li class="d-flex justify-content-between align-items-center">
                        <div class="Myfrais" style="width: 100%; display: none;">
                            <span class="mr-2">Frais mobile money:</span>
                            <div class="text-right float-right">
                                {{ number_format($fraisPaiement, 0, '.', ' ') }} Fcfa
                            </div>
                        </div>
                    </li>
                @endisset
            </ul>
            @isset ($commandeAvecFraisPaiement)
                <h3 class="font-weight-normal text-center my-4 totalAmount" style="display: none;">
                    {{ number_format($commandeAvecFraisPaiement, 0, '.', ' ') }} Fcfa
                </h3>
            @endisset
            <h3 class="font-weight-normal text-center my-4 totalCommande">
                {{ number_format(Cart::instance('shopping')->total() + $livraison, 0, '.', ' ') }} Fcfa
            </h3>
            {{--  <form class="needs-validation" method="post" novalidate>
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Promo code" required>
                    <div class="invalid-feedback">Please provide promo code.</div>
                </div>
                <button class="btn btn-outline-primary btn-block" type="submit">Apply promo code</button>
            </form>  --}}
            @if (url()->current() == url('panier'))
                @if (Cart::instance('shopping')->total() >= 3000)
                    <div class="text-center border-top">
                        @auth
                            <a class="btn btn-success btn-shadow btn-block mt-4" href="{{ url('panier?commercial=1') }}">
                                <i class="czi-card font-size-lg mr-2"></i> Commander
                            </a>
                            @hasanyrole('superadmin|admin')
                                <a class="btn btn-success btn-shadow btn-block mt-4" href="{{ url('panier?commercial=atre') }}">
                                    <i class="icofont-badge font-size-lg mr-2"></i> Commande commercial
                                </a>
                            @endhasanyrole
                        @else
                            <a class="btn btn-success btn-shadow btn-block mt-4" href="#signin-modal" data-toggle="modal">
                                <i class="czi-card font-size-lg mr-2"></i> Commander
                            </a>
                        @endauth
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        Votre commande doit être au moins 3000 avant de la validée
                    </div>
                @endif
            @else
                @if (url()->current() != url('confirmation'))
                    <a href="{{ url('panier') }}" class="btn btn-outline-primary btn-block">
                        <i class="fa fa-reply" aria-hidden="true"></i>
                        Retour au panier
                    </a>
                @endif
            @endif
        </div>
    </aside>
@endif
