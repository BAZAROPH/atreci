<!-- Sidebar-->
<aside class="col-lg-4 pt-4 pt-lg-0">
    <div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 pb-0 mb-5 mb-lg-0">
        <div class="px-4 mb-4">
            <div class="media align-items-center">
                <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
                    {{--  <span class="badge badge-warning" data-toggle="tooltip" title="Reward points">
                        384
                    </span>  --}}
                    @if(!empty(auth()->user()->getMedia('image')->first()))
                        <img class="rounded-circle" width="80" src="{{ url(auth()->user()->getMedia('image')->first()->getUrl('thumb')) }}">
                    @else
                        <img class="rounded-circle" width="80" src="{{ asset('admin/image/user.png') }}">
                    @endif
                </div>
                <div class="media-body pl-3">
                    <h3 class="font-size-base mb-0">
                        {!! auth()->user()->prenom.' '.auth()->user()->name !!}
                    </h3>
                    <span class="text-accent font-size-sm">
                        {!! auth()->user()->email !!}
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-secondary px-4 py-3">
            <h3 class="font-size-sm mb-0 text-muted">Tableau de bord</h3>
        </div>
        <ul class="list-unstyled mb-0">
            <li class="border-bottom mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3 @if(url()->current() == url('profil/commande')) active @endif" href="{{ url('profil/commande') }}">
                    <i class="czi-bag opacity-60 mr-2"></i>Commandes
                    <span class="font-size-sm text-muted ml-auto">
                        @isset ($user->commandes)
                            {{ count($user->commandes) }}
                        @endisset
                    </span>
                </a>
            </li>
            <li class="border-bottom mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3 @if(url()->current() == url('wishlist')) active @endif" href="{{ url('wishlist') }}">
                    <i class="czi-heart opacity-60 mr-2"></i>Liste d'envies
                    <span class="font-size-sm text-muted ml-auto">
                        {{ Cart::instance('wishlist')->count() }}
                    </span>
                </a>
            </li>
            {{--  <li class="mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3" href="#">
                    <i class="czi-help opacity-60 mr-2"></i>Vu récemment
                    <span class="font-size-sm text-muted ml-auto">1</span>
                </a>
            </li>  --}}
        </ul>
        <div class="bg-secondary px-4 py-3">
            <h3 class="font-size-sm mb-0 text-muted">Paramètres</h3>
        </div>
        <ul class="list-unstyled mb-0">
            <li class="border-bottom mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3 @if(url()->current() == url('profil/edit')) active @endif" href="{{ url('profil/edit') }}">
                    <i class="czi-user opacity-60 mr-2"></i>Profil infos
                </a>
            </li>
            <li class="border-bottom mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3 @if(url()->current() == url('profil/adresse')) active @endif" href="{{ url('profil/adresse') }}">
                    <i class="czi-location opacity-60 mr-2"></i>
                    Adresses de livraison
                    <span class="font-size-sm text-muted ml-auto">
                        @isset ($user->adresses)
                            {{ count($user->adresses) }}
                        @endisset
                    </span>
                </a>
            </li>
            {{--  <li class="mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3" href="#">
                    <i class="czi-card opacity-60 mr-2"></i>Moyen de paiement
                </a>
            </li>  --}}
            <li class="d-lg-none border-top mb-0">
                <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="czi-sign-out opacity-60 mr-2"></i>Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</aside>
