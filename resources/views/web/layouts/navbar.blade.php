@desktop
<div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu mt-n2 pt-0 pb-0 bg-success">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Departments menu-->
            <ul class="navbar-nav mega-nav pr-lg-2 mr-lg-2" style="margin-top: -10px;">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pl-0" href="#" data-toggle="dropdown">
                        <i class="czi-menu align-middle mt-n1 mr-2"></i>
                        Catégories
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($categorieEcommerce->first()->childrens as $item)
                            <li class="dropdown mega-dropdown">
                                <a class="dropdown-item dropdown-toggle" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                    <i class="{{ $item->icon }} opacity-60 font-size-lg mt-n1 mr-2"></i>
                                    {{ $item->libelle }}
                                </a>
                                <div class="dropdown-menu p-0">
                                    <div class="d-flex flex-wrap flex-md-nowrap px-2">
                                        <div class="mega-dropdown-column py-4 px-3">
                                            <div class="widget widget-links mb-3">
                                                <ul class="widget-list">
                                                    @php($i = 0)
                                                    @foreach ($item->childrens as $valeur)
                                                        @php($i++)
                                                        <li class="widget-list-item pb-1">
                                                            <a class="widget-list-link" href="{{ urlMode(url('category/'.$valeur->slug), $parametre->type_id) }}">
                                                                {{ $valeur->libelle }}
                                                            </a>
                                                        </li>
                                                        @if ($i == 13)
                                                            </ul></div></div><div class="mega-dropdown-column py-4 px-3"><div class="widget widget-links mb-3"> <ul class="widget-list">
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="mega-dropdown-column d-none d-lg-block py-4 text-center">
                                            <a class="d-block mb-2" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                                @if($item->getMedia('image')->first())
                                                    <img height="80" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="Atrê Marché">
                                                @endif
                                            </a>
                                            <div class="font-size-sm mb-3">
                                                Découvrez !!!
                                                <span class='font-weight-medium'>à partir de 1000 Fcfa</span>
                                            </div>
                                            <a class="btn btn-primary btn-shadow btn-sm" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                                Voir les produits<i class="czi-arrow-right font-size-xs ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <!-- Primary menu-->
            <ul class="navbar-nav">
                <li class="nav-item dropdown active">
                    <a class="nav-link" href="{{ url('/') }}">
                        Accueil
                    </a>
                </li>
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" href="{{ urlMode(url('category/'.'marche-de-gros'), $parametre->type_id) }}">
                        Marché de gros
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Produits transformés
                        <i class="icofont-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($categorieEcommerce[2]->childrens as $item)
                            <li>
                                <a class="dropdown-item" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                    {{ $item->libelle }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Élévage & agriculture
                        <i class="icofont-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($categorieEcommerce[3]->childrens as $item)
                            <li>
                                <a class="dropdown-item" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                    <div class="d-flex">
                                        <div class="lead text-muted pt-1">
                                            <i class="{{ $item->icon }} text-danger"></i>
                                        </div>
                                        <div class="ml-2">
                                            <span class="d-block text-heading">
                                                {{ $item->libelle }}
                                            </span>
                                            <small class="d-block text-muted">
                                                {{ $item->sous_titre }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Recette & santé
                        <i class="icofont-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="lead text-muted pt-1">
                                        <i class="icofont-medical-sign-alt text-danger"></i>
                                    </div>
                                    <div class="ml-2">
                                        <span class="d-block text-heading">
                                            Conseils santé
                                        </span>
                                        <small class="d-block text-muted">
                                            Santé
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="lead text-muted pt-1">
                                        <i class="icofont-herbal text-danger"></i>
                                    </div>
                                    <div class="ml-2">
                                        <span class="d-block text-heading">
                                            Type de régime
                                        </span>
                                        <small class="d-block text-muted">
                                            Régime
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
@enddesktop
