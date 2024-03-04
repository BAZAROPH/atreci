@php($categorieEcommerce = categorieEcommerce(2))
@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'advanced-search',
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
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        <!-- Sidebar-->
        <aside class="col-lg-12">
            <!-- Sidebar-->
            <div class="cz-sidebar rounded-lg box-shadow-lg" id="shop-sidebar" style="max-width: initial;">
                <div class="cz-sidebar-header box-shadow-sm">
                    <button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="Close">
                        <span class="d-inline-block font-size-xs font-weight-normal align-middle">Fermer sidebar</span>
                        <span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url("search") }}" method="get" name="category_name">
                    @csrf
                        <div class="cz-sidebar-body" class="mt-5" >
                            <!-- Price range-->
                            <div class="row">
                                <div class="col-lg-6">
                                    <span>
                                        <select value="Catégorie du produit" class="form-control" name="category_name" >
                                            @foreach ($categorieEcommerce->first()->childrens as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->libelle }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                                <div class="col-lg-6" >
                                    <span>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="text-input" placeholder="Nom du produit" name="term_search">
                                        </div>

                                    </span>
                                </div>
                            </div>
                                <h6  class="mt-3">Prix</h6>
                                <div class="cz-range-slider" data-start-min="100" data-start-max="15000" data-min="0" data-max="20000" data-step="1">
                                    <div class="cz-range-slider-ui"></div>
                                    <div class="d-flex pb-1">
                                        <div class="w-50 pr-2 mr-2">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control cz-range-slider-value-min" type="text" name="price_min">
                                                <div class="input-group-prepend"><span class="input-group-text">Fcfa</span></div>
                                            </div>
                                        </div>
                                        <div class="w-50 pl-2">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control cz-range-slider-value-max" type="text" name="price_max">
                                                <div class="input-group-prepend"><span class="input-group-text">Fcfa</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="text-center">
                            <button class="btn btn-primary mb-3" class="form control" type="submit">Rechercher</button>
                            </div>
                        </div>
            </form>
            </div>
        </aside>
        <!-- Content  -->
        <section class="col-lg-8">

        </section>

    </div>
</div>
@endsection
