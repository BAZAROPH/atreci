@php($categorieEcommerce = categorieEcommerce(2))
@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
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
                        @if ($categorie->parent)
                            <li class="breadcrumb-item">
                                <a class="text-nowrap" href="{{ url('category/'.$categorie->parent->slug) }}">
                                    <i class="{{ $categorie->parent->icon }}"></i>{{ $categorie->parent->libelle }}
                                </a>
                            </li>
                        @endif
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

    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <!-- Sidebar-->
            <aside class="col-lg-4">
                <!-- Sidebar-->
                <div class="cz-sidebar rounded-lg box-shadow-lg" id="shop-sidebar">
                    <div class="cz-sidebar-header box-shadow-sm">
                        <button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="Close">
                            <span class="d-inline-block font-size-xs font-weight-normal align-middle">Fermer sidebar</span>
                            <span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="cz-sidebar-body">
                        <!-- Categories-->
                        <div class="widget widget-categories mb-4 pb-4 border-bottom">
                            <h3 class="widget-title">Catégories</h3>
                            <div class="accordion mt-n1" id="shop-categories">
                                @foreach ($categorieEcommerce->first()->childrens as $item)
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="accordion-heading">
                                                {{--  <a href="#clothing" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="clothing">
                                                    Clothing
                                                    <span class="accordion-indicator"></span>
                                                </a>  --}}
                                                <a {{ ($item->slug != request('slug')) ? 'class=collapsed' : '' }} href="#{{ $item->slug }}" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="{{ $item->slug }}">
                                                    {{ $item->libelle }}
                                                    <span class="accordion-indicator"></span>
                                                </a>
                                            </h3>
                                        </div>

                                        <div class="collapse {{ ($item->slug == request('slug')) ? 'show' : '' }}" id="{{ $item->slug }}" data-parent="#shop-categories">
                                            <div class="card-body">
                                                <div class="widget widget-links cz-filter">
                                                    <div class="input-group-overlay input-group-sm mb-2">
                                                        <input class="cz-filter-search form-control form-control-sm appended-form-control" type="text" placeholder="Search">
                                                        <div class="input-group-append-overlay">
                                                            <span class="input-group-text"><i class="czi-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <ul class="widget-list cz-filter-list pt-1" style="height: 12rem;" data-simplebar data-simplebar-auto-hide="false">
                                                        <li class="widget-list-item cz-filter-item">
                                                            <a class="widget-list-link d-flex justify-content-between align-items-center" href="{{ url('category/'.$item->slug) }}">
                                                                <span class="cz-filter-item-text">Voir tous</span>
                                                                <span class="font-size-xs text-muted ml-3">{{ count($item->posts) }}</span>
                                                            </a>
                                                        </li>
                                                        @foreach ($item->childrens as $valeur)
                                                            <li class="widget-list-item cz-filter-item">
                                                                <a class="widget-list-link d-flex justify-content-between align-items-center" href="{{ url('category/'.$valeur->slug) }}">
                                                                    <span class="cz-filter-item-text">
                                                                        {{ $valeur->libelle }}
                                                                    </span>
                                                                    <span class="font-size-xs text-muted ml-3">
                                                                        {{ count($valeur->posts) }}
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Price range-->
                        <div class="widget mb-4 pb-4 border-bottom">
                            <h3 class="widget-title">Prix</h3>
                            <div class="cz-range-slider" data-start-min="100" data-start-max="15000" data-min="0" data-max="20000" data-step="1">
                                <div class="cz-range-slider-ui"></div>
                                <div class="d-flex pb-1">
                                    <div class="w-50 pr-2 mr-2">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control cz-range-slider-value-min" type="text">
                                            <div class="input-group-prepend"><span class="input-group-text">Fcfa</span></div>
                                        </div>
                                    </div>
                                    <div class="w-50 pl-2">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control cz-range-slider-value-max" type="text">
                                            <div class="input-group-prepend"><span class="input-group-text">Fcfa</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <!-- Content  -->
            <section class="col-lg-8">
                <div class="d-flex justify-content-center justify-content-sm-between align-items-center pt-2 pb-4 pb-sm-5">
                    <div class="d-flex flex-wrap">
                        <form method="GET" class="form-inline flex-nowrap mr-3 mr-sm-4 pb-3">
                            @csrf
                            <label class="text-light opacity-75 text-nowrap mr-2 d-none d-sm-block" for="sorting">
                                Trier par:
                            </label>
                            <select name="trier" class="form-control custom-select" id="sorting" onChange="this.form.submit()">
                                @foreach ($elementDeTri as $item)
                                    <option value="{{ $item->id }}" {{ ($item->id == request('trier')) ? 'selected' : '' }} >{{ $item->libelle }}</option>
                                @endforeach
                            </select>
                            @php($array = listing_post($parametre->type_id, $categorie_id = $categorie->id, $apparence_id = null, $limit = 60, $column = 'col-md-4 col-sm-6', $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = 'category'))
                            <span class="font-size-sm text-light opacity-75 text-nowrap ml-2 d-none d-md-block">
                                {{ count($array['postsSansPaginate']) }} produits
                            </span>
                        </form>
                    </div>
                    {{--  <div class="d-flex pb-3">
                        <a class="nav-link-style nav-link-light mr-3" href="#">
                            <i class="czi-arrow-left"></i>
                        </a>
                        <span class="font-size-md text-light">1 / 5</span>
                        <a class="nav-link-style nav-link-light ml-3" href="#">
                            <i class="czi-arrow-right"></i>
                        </a>
                    </div>  --}}
                    {{--  <div class="d-none d-sm-flex pb-3">
                        <a class="btn btn-icon nav-link-style bg-light text-dark disabled opacity-100 mr-2" href="#">
                            <i class="czi-view-grid"></i>
                        </a>
                        <a class="btn btn-icon nav-link-style nav-link-light" href="shop-list-ls.html">
                            <i class="czi-view-list"></i>
                        </a>
                    </div>  --}}
                </div>
                @if ($array)
                    {!! $array['code'] !!}
                @else
                    <div class="text-danger h4 text-center">
                        <i class="fa fa-exclamation-triangle"></i>
                        Pas de produits pour le moment
                    </div>
                @endif

                <hr class="my-3">
                <nav class="d-flex justify-content-between pt-2 justify-content-center" aria-label="Page navigation">
                    @if ($array)
                        {{ $array['posts']->links() }}
                    @endif
                </nav>
            </section>
        </div>
    </div>
@endsection
