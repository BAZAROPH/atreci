@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'profil',
])
@section('content')

@include('web.user.entete', [
    'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">'.$infosPage['title'].'</li>',
])
<div class="container pb-5 mb-2 mb-md-3">
	<div class="row">
		@include('web.user.compte-user')
		<section class="col-lg-8 mt-5 pt-5">
            @if (!count(Cart::instance('shopping')->content()))
                <div>
                    <div class="text-center text-white bg-danger border m-auto p-2 pt-4" style="border-radius: 100%; border: solid 3px; width: 150px; height:140px;">
                        <i class="icofont-shopping-cart fa-5x"></i>
                    </div>
                    <h3 class="font-weight-bold text-center">Pas de liste d'envie</h3>
                </div>
            @endif

            @include('flash::message')
            @foreach (Cart::instance('wishlist')->content() as $item)
                @php($post = detailPanier($item->id))
                @php($capacite = traitementCategory($post, 'capacite'))
                @php($subdivision = traitementCategory($post, 'subdivision'))
                @php($categorie = traitementCategory($post, 'categorie'))
                <div class="d-sm-flex justify-content-between align-items-center my-4 pb-3 border-bottom">
                    <div class="media media-ie-fix d-block d-sm-flex align-items-center text-center text-sm-left" style="width: 100%;">
                        <a class="d-inline-block mx-auto mr-sm-4" href="{{ url($post->slug) }}">
                            @if(!empty($post->getMedia('image')->first()))
                                <img width="100" src="{{ url($post->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                            @endif
                        </a>
                        <div class="media-body pt-2">
                            <h3 class="product-title font-size-base mb-2">
                                <a href="{{ url($post->slug) }}">
                                    {{ $item->name }}
                                </a>
                            </h3>
                            <div class="font-size-sm">
                                {{ number_format($post->prix_nouveau, 0, '.', ' ').' Fcfa' }}
                            </div>
                            <a href="{{ url('category/'.$categorie->slug) }}">
                                <div class="font-size-sm badge badge-success">
                                    <i class="{{ $categorie->icon }}"></i>
                                    {{ $categorie->libelle }}
                                </div>
                            </a>
                            <div>
                                <a class="btn btn-link px-0 text-danger" href="{{ url('wishlist?rowId='.$item->rowId) }}">
                                    <i class="icofont-trash mr-2"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
            {{--  <button class="btn btn-outline-accent btn-block" type="button">
                <i class="czi-loading font-size-base mr-2"></i>Update cart
            </button>  --}}
        </section>
	</div>
</div>
@endsection
