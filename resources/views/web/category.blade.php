@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    @php($array = listing_post($parametre->type_id, $categorie->id, null, 50, $categorie->icon, null, null, 'id desc', '', 'category'))
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
    <section class="container pt-5">
        @if (count($array['posts']))
            {!! $array['code'] !!}
        @else
            <div class="h4 text-center text-white">
                <i class="fa fa-exclamation-triangle"></i>
                Pas de éléments pour le moment
            </div>
        @endif

        <div class="container">
            <div class="row">
                <div class="col-12 justify-content-center">
                    {{ $array['posts']->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
