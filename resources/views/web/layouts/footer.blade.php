<!-- Footer-->
<footer class="bg-success pt-5">
    @desktop
    <div class="container">
        <div class="row pb-2">
            <div class="col-md-4 col-sm-6">
                <div class="widget widget-links widget-light pb-2 mb-4">
                    <h3 class="widget-title text-light">Nos catégories</h3>
                    <ul class="widget-list">
                        @foreach ($categorieEcommerce->first()->childrens as $item)
                            <li class="widget-list-item">
                                <a class="widget-list-link" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                    {{ $item->libelle }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="widget widget-links widget-light pb-2 mb-4">
                    <h3 class="widget-title text-light">Compte &amp; Livraison</h3>
                    <ul class="widget-list">
                        <li class="widget-list-item">
                            <a class="widget-list-link" href="{{ url('profil') }}">
                                Votre compte
                            </a>
                        </li>
                        <li class="widget-list-item">
                            {!! lienPost($id = 69, $model = 'post', $class = 'widget-list-link') !!}
                        </li>
                        <li class="widget-list-item">
                            <a class="widget-list-link" href="{{ url('profil/commande') }}">
                                Mes commandes
                            </a>
                        </li>
                        <li class="widget-list-item">
                            <a class="widget-list-link" href="{{ url('wishlist') }}">
                                Liste d'envie
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="widget widget-links widget-light pb-2 mb-4">
                    <h3 class="widget-title text-light">A propos nous</h3>
                    <ul class="widget-list">
                        <li class="widget-list-item">
                            {!! lienPost($id = 62, $model = 'post', $class = 'widget-list-link') !!}
                        </li>
                        {{-- <li class="widget-list-item">
                            <a class="widget-list-link" href="#">
                                Notre équipe
                            </a>
                        </li>
                        <li class="widget-list-item">
                            <a class="widget-list-link" href="#">
                                Carrières
                            </a>
                        </li>
                        <li class="widget-list-item">
                            <a class="widget-list-link" href="#">
                                Actualités
                            </a> --}}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget pb-2 mb-4">
                    <h3 class="widget-title text-light pb-1">Rester informé</h3>
                    <form class="cz-subscribe-form validate" action="https://studio.us12.list-manage.com/subscribe/post?u=c7103e2c981361a6639545bd5&amp;amp;id=29ca296126" method="post" name="mc-embedded-subscribe-form" target="_blank" novalidate>
                        <div class="input-group input-group-overlay flex-nowrap">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text text-muted font-size-base">
                                    <i class="czi-mail"></i>
                                </span>
                            </div>
                            <input class="form-control prepended-form-control" type="email" name="email" placeholder="Email" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" name="subscribe">Souscrire*</button>
                            </div>
                        </div>
                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        {{-- <div style="position: absolute; left: -5000px;" aria-hidden="true">
                            <input class="cz-subscribe-form-antispam" type="text" name="b_c7103e2c981361a6639545bd5_29ca296126" tabindex="-1">
                        </div> --}}
                        <small class="form-text text-light opacity-50">
                            *Abonnez-vous à notre newsletter pour recevoir des offres de réduction anticipée, des mises à jour et des informations sur les nouveaux produits.
                        </small>
                        <div class="subscribe-status"></div>
                    </form>
                </div>
                <div class="widget pb-2 mb-4">
                    <h3 class="widget-title text-light pb-1">Téléchargez notre appli</h3>
                    <div class="d-flex flex-wrap">
                        {{-- <div class="mr-2 mb-2">
                            <a class="btn-market btn-apple" href="#" role="button">
                                <span class="btn-market-subtitle">
                                    Téléchargez sur le
                                </span>
                                <span class="btn-market-title">App Store</span>
                            </a>
                        </div> --}}
                        <div class="mb-2">
                            <a class="btn-market btn-google" href="https://play.google.com/store/apps/details?id=com.watremarche_8359541" target="_blank" role="button">
                                <span class="btn-market-subtitle">
                                    Téléchargez sur le
                                </span>
                                <span class="btn-market-title">Google Play</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @enddesktop
    <div class="pt-5" style="background: #010101;">
        <div class="container">
            {{-- <div class="row pb-3">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="media">
                        <i class="czi-rocket text-primary" style="font-size: 2.25rem;"></i>
                        <div class="media-body pl-3">
                            <h6 class="font-size-base text-light mb-1">
                                Livraison rapide et gratuite
                            </h6>
                            <p class="mb-0 font-size-ms text-light opacity-50">
                                Livraison gratuite pour toutes les commandes de plus de 25 000 Fcfa
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="media">
                        <i class="czi-currency-exchange text-primary" style="font-size: 2.25rem;"></i>
                        <div class="media-body pl-3">
                            <h6 class="font-size-base text-light mb-1">
                                Commandez maintenant
                            </h6>
                            <p class="mb-0 font-size-ms text-light opacity-50">
                                et payez cash à la livraison ou par mobile money
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="media">
                        <i class="czi-support text-primary" style="font-size: 2.25rem;"></i>
                        <div class="media-body pl-3">
                            <h6 class="font-size-base text-light mb-1">
                                Assistance client 24/7
                            </h6>
                            <p class="mb-0 font-size-ms text-light opacity-50">
                                Support client amical 24/7
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="media">
                        <i class="czi-card text-primary" style="font-size: 2.25rem;"></i>
                        <div class="media-body pl-3">
                            <h6 class="font-size-base text-light mb-1">
                                Paiement en ligne sécurisé
                            </h6>
                            <p class="mb-0 font-size-ms text-light opacity-50">
                                Nous possédons un certificat SSL
                            </p>
                        </div>
                    </div>
                </div>
            </div> --}}
            {!! listing_post($parametre->type_id, $categorie_id = 634, $apparence_id = 18, $limit = 4, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id asc', $typeImage = 'thumb', $page = null, $additif = null, $restriction = []) !!}
            <hr class="hr-light pb-4 mb-3">
            <div class="row pb-2">
                <div class="col-md-6 text-center text-md-left mb-4">
                    <div class="text-nowrap mb-4 text-center">
                        {{-- <div class="btn-group dropdown disable-autohide">
                            <button class="btn btn-outline-light border-light btn-sm dropdown-toggle px-2" type="button" data-toggle="dropdown">
                                <img class="mr-2" width="20" src="{{ asset('web/img/flags/en.png') }}" alt="English"/>
                                Eng / $
                            </button>
                            <ul class="dropdown-menu">
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
                                        <img class="mr-2" width="20" src="{{ asset('web/img/flags/fr.png') }}" alt="Français" />
                                        Français
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item pb-1" href="#">
                                        <img class="mr-2" width="20" src="{{ asset('web/img/flags/de.png') }}" alt="Deutsch" />
                                        Deutsch
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <img class="mr-2" width="20" src="{{ asset('web/img/flags/it.png') }}" alt="Italiano" />
                                        Italiano
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                    <div class="widget widget-links widget-light">
                        <ul class="widget-list d-flex flex-wrap justify-content-center justify-content-md-start">
                            <li class="widget-list-item mr-4">
                                {!! lienPost($id = 50, $model = 'post', $class = 'widget-list-link') !!}
                            </li>
                            {{-- <li class="widget-list-item mr-4">
                                <a class="widget-list-link" href="#">
                                    Vos informations personnelles
                                </a>
                            </li>
                            <li class="widget-list-item mr-4">
                                <a class="widget-list-link" href="#">
                                    Assistance
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                @desktop
                <div class="col-md-6 text-center text-md-right mb-4">
                    <div class="mb-3">
                        <a class="d-inline-block align-middle mt-n1 mr-3" href="#">
                            <img class="d-block" width="90" src="{{ asset('web/img/atre.jpg') }}" alt="atrê marché" />
                        </a>
                        {!! listing_post($parametre->type_id, $categorie_id = 204, $apparence_id = 4, $limit = null, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = null, $additif = null, $restriction = []) !!}
                        {{-- <a class="social-btn sb-light sb-twitter ml-2 mb-2" href="#">
                            <i class="czi-twitter"></i>
                        </a>
                        <a class="social-btn sb-light sb-facebook ml-2 mb-2" href="#">
                            <i class="czi-facebook"></i>
                        </a>
                        <a class="social-btn sb-light sb-instagram ml-2 mb-2" href="#">
                            <i class="czi-instagram"></i>
                        </a>
                        <a class="social-btn sb-light sb-youtube ml-2 mb-2" href="#">
                            <i class="czi-youtube"></i>
                        </a>
                        <a class="social-btn sb-light sb-linkedin ml-2 mb-2" href="#">
                            <i class="czi-linkedin"></i>
                        </a> --}}
                    </div>
                    {{-- <img class="d-inline-block" width="187" src="{{ asset('web/img/cards-alt.png') }}" alt="Methode de paiement" /> --}}
                </div>
                @enddesktop
            </div>
            @desktop
                <div class="pb-4 font-size-xs text-light opacity-50 text-center">
                    © atrê marché Tous droits réservés.
                    By
                    <a class="text-light" href="https://www.qenium.com/" target="_blank" rel="noopener">
                        Qenium
                    </a>
                </div>
            @enddesktop
        </div>
    </div>
</footer>
@include('web.layouts.menu-mobile')
<!-- Back To Top Button-->
<a class="btn-scroll-top" href="#top" data-scroll>
    <span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2">Top</span>
    <i class="btn-scroll-top-icon czi-arrow-up"></i>
</a>
