@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    {{-- <main id="main">
        {!! listing_post($parametre->type_id, $rubrique->id, 24, 1, null, $post->id) !!}
    </main> --}}
    <div class="bg-secondary py-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ url('/') }}"><i class="czi-home"></i>Accueil</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap">
                            <a href="{{ url('category/'.$rubrique->slug) }}">{{ $rubrique->libelle }}</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">
                            {{ $infosPage['title'] }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                <h1 class="h3 mb-0">{{ $infosPage['title'] }}</h1>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container pb-5">
        <div class="row pt-5 mt-md-2">
            <section class="col-lg-8">
                <!-- Post meta-->
                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4 mt-n1">
                    @if ($post->fournisseur)
                        <div class="d-flex align-items-center font-size-sm mb-2">
                            <a class="blog-entry-meta-link" href="{{ url('author/'.$post->fournisseur->slug) }}">
                                <div class="blog-entry-author-ava">
                                    @if(!empty($post->fournisseur->getMedia('image')->first()))
                                        <img alt="{{ $post->fournisseur->name }}" src="{{ url($post->fournisseur->getMedia('image')->first()->getUrl('thumb')) }}">
                                    @else
                                        <img alt="{{ $post->fournisseur->name }}" src="{{ asset('admin/image/user.png') }}">
                                    @endif
                                </div>
                                {{ $post->fournisseur->name }}
                            </a>
                            <span class="blog-entry-meta-divider"></span>
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                    @endif
                    @if (\Carbon\Carbon::parse($post->date_debut) > \Carbon\Carbon::now())
                        <div class="font-size-sm mb-2">
                            <a class="blog-entry-meta-link text-nowrap" href="#comments" data-scroll>
                                @php($date_debut = \Carbon\Carbon::parse($post->date_debut))
                                <i class="icofont-ui-calendar"></i> Début de la recolte {{ $date_debut->diffForHumans() }}
                            </a>
                        </div>
                    @else
                        <span class="blog-entry-meta-link text-nowrap" href="#comments" data-scroll>
                            <i class="icofont-ui-calendar"></i> {{ $post->created_at->diffForHumans() }}
                        </span>
                    @endif
                </div>

                @if (\Carbon\Carbon::parse($post->date_debut) > \Carbon\Carbon::now())
                    <div class="text-center">
                        <div class="cz-countdown py-2 h4" data-countdown="{{ \Carbon\Carbon::parse($post->date_debut) }}">
                            La recolte dans débute dans : &nbsp;
                            <div class="cz-countdown-days"><span class="cz-countdown-value"></span><span class="cz-countdown-label text-muted">jour(s)</span></div>
                            <div class="cz-countdown-hours"><span class="cz-countdown-value"></span><span class="cz-countdown-label text-muted">heure(s)</span></div>
                            <div class="cz-countdown-minutes"><span class="cz-countdown-value"></span><span class="cz-countdown-label text-muted">minute(s)</span></div>
                            <div class="cz-countdown-seconds"><span class="cz-countdown-value"></span><span class="cz-countdown-label text-muted">seconde(s)</span></div>
                        </div>
                    </div>
                @endif
                <!-- Gallery-->
                <div class="cz-gallery row pb-2">
                    <div class="col-sm-8">
                        @if(!empty($post->getMedia('image')->first()))
                            <a class="gallery-item rounded-lg mb-grid-gutter" href="{{ url($post->getMedia('image')->first()->getUrl('thumb')) }}" data-sub-html="&lt;h6 class=&quot;font-size-sm text-light&quot;&gt;{{ $infosPage['title'] }}&lt;/h6&gt;">
                                <img src="{{ url($post->getMedia('image')->first()->getUrl()) }}" alt="{{ $infosPage['title'] }}">
                                <span class="gallery-item-caption">{{ $infosPage['title'] }}</span>
                            </a>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        @php($i = 0)
                        @foreach ($post->getMedia('image') as $item)
                            @if ($i > 0)
                                <a class="gallery-item rounded-lg mb-grid-gutter" href="{{ url($item->getUrl()) }}" data-sub-html="&lt;h6 class=&quot;font-size-sm text-light&quot;&gt;{{ $infosPage['title'] }}&lt;/h6&gt;">
                                    <img src="{{ url($item->getUrl()) }}" alt="{{ $infosPage['title'] }}">
                                    <span class="gallery-item-caption">{{ $infosPage['title'] }}</span>
                                </a>
                            @endif
                            @php($i++)
                        @endforeach
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        @if ($post->localisation)
                            <i class="icofont-google-map"></i>
                            {{ $post->localisation }} <span class="blog-entry-meta-divider"></span>
                        @endif
                        @if ($post->quantite)
                            <i class="icofont-muscle-weight"></i>
                            {{ $post->quantite }} {{ $capacite->libelle }} <span class="blog-entry-meta-divider"></span>
                        @endif
                        @if ($post->certification)
                            <i class="icofont-paper"></i>
                            {{ $post->certification }} <span class="blog-entry-meta-divider"></span>
                        @endif
                        @if ($post->variete)
                            <i class="icofont-wheat"></i>
                            Variété : {{ $post->variete }} <span class="blog-entry-meta-divider"></span>
                        @endif
                        @if ($post->technique)
                            <i class="icofont-settings-alt"></i>
                            Techniques de production : {{ $post->technique }} <span class="blog-entry-meta-divider"></span>
                        @endif
                        @if ($post->intrant)
                            <i class="icofont-cement-mix"></i>
                            Intrants : {{ $post->intrant }} <span class="blog-entry-meta-divider"></span>
                        @endif
                    </div>
                </div>
                <!-- Post content-->
                {!! $post->description !!}
                <!-- Post tags + sharing-->
                <div class="d-flex flex-wrap justify-content-between pt-2 pb-4 mb-1">
                    <div class="mt-3">
                        <span class="d-inline-block align-middle text-muted font-size-sm mr-3 mb-2">Partager:</span>

                        <a target="_blank" class="social-btn sb-twitter mr-2 mb-2" href="https://twitter.com/intent/tweet?text=Regardez ce que j'ai trouvé sur Atrê marché : {{ $post->libelle }}&url={{ url()->current() }}">
                            <i class="czi-twitter"></i>
                        <a target="_blank" class="social-btn sb-facebook mr-2 mb-2" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}">
                            <i class="czi-facebook"></i>
                        </a>
                        <a target="_blank" class="social-btn sb-whatsapp mr-2 mb-2" href="https://api.whatsapp.com/send?text=Regardez ce que j'ai trouvé sur Atrê marché : {{ $post->libelle }}, {{ url()->current() }}">
                            <i class="icofont-whatsapp"></i>
                        </a>
                        <a target="_blank" class="social-btn sb-linkedin mr-2 mb-2" href="http://www.linkedin.com/shareArticle?mini=true&amp;title={{ $post->libelle }}&amp;url={{ url()->current() }}&amp;summary={{ $post->description }}&source=LinkedIn">
                            <i class="czi-linkedin"></i>
                        </a>
                    </div>
                </div>
                <!-- Post navigation-->
                {{-- <nav class="entry-navigation" aria-label="Post navigation">
                    <a class="entry-navigation-link" href="#" data-toggle="popover" data-placement="top" data-trigger="hover" data-html="true" data-content="&lt;div class=&quot;media align-items-center&quot;&gt;&lt;img src=&quot;web/img/blog/navigation/01.jpg&quot; width=&quot;60&quot; class=&quot;mr-3&quot; alt=&quot;Post thumb&quot;&gt;&lt;div class=&quot;media-body&quot;&gt;&lt;h6  class=&quot;font-size-sm font-weight-semibold mb-0&quot;&gt;How to choose perfect shoes for running&lt;/h6&gt;&lt;span class=&quot;d-block font-size-xs text-muted&quot;&gt;by Susan Mayer&lt;/span&gt;&lt;/div&gt;&lt;/div&gt;">
                        <i class="czi-arrow-left mr-2"></i>
                        <span class="d-none d-sm-inline">Prev post</span>
                    </a>
                    <a class="entry-navigation-link" href="blog-list.html">
                        <i class="czi-view-list mr-2"></i>
                        <span class="d-none d-sm-inline">All posts</span>
                    </a>
                    <a class="entry-navigation-link" href="#" data-toggle="popover" data-placement="top" data-trigger="hover" data-html="true" data-content="&lt;div class=&quot;media align-items-center&quot;&gt;&lt;img src=&quot;web/img/blog/navigation/02.jpg&quot; width=&quot;60&quot; class=&quot;mr-3&quot; alt=&quot;Post thumb&quot;&gt;&lt;div class=&quot;media-body&quot;&gt;&lt;h6  class=&quot;font-size-sm font-weight-semibold mb-0&quot;&gt;Factors behind smart watches popularity&lt;/h6&gt;&lt;span class=&quot;d-block font-size-xs text-muted&quot;&gt;by Logan Coleman&lt;/span&gt;&lt;/div&gt;&lt;/div&gt;">
                        <span class="d-none d-sm-inline">Next post</span>
                        <i class="czi-arrow-right ml-2"></i>
                    </a>
                </nav> --}}
            </section>
            <aside class="col-lg-4">
                <!-- Sidebar-->
                <div class="cz-sidebar border-left ml-lg-auto" id="blog-sidebar">
                    <div class="cz-sidebar-header box-shadow-sm">
                        <button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="Close">
                            <span class="d-inline-block font-size-xs font-weight-normal align-middle">
                                Close sidebar
                            </span>
                            <span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="cz-sidebar-body py-lg-1" data-simplebar data-simplebar-auto-hide="true">
                        <!-- Categories-->
                        <div class="widget widget-links mb-grid-gutter pb-grid-gutter border-bottom">
                            <h3 class="widget-title">Catégories</h3>
                            <ul class="widget-list">
                                <li class="widget-list-item">
                                    <a class="widget-list-link d-flex justify-content-between align-items-center" href="{{ url('category/'.$rubrique->slug) }}">
                                        <span>Offres fournisseurs</span>
                                        <i class="icofont-thin-double-right"></i>
                                        {{-- <span class="font-size-xs text-muted ml-3">18</span> --}}
                                    </a>
                                </li>
                                <li class="widget-list-item">
                                    <a class="widget-list-link d-flex justify-content-between align-items-center" href="{{ url('marche-de-gros') }}">
                                        <span>Marché de gros</span>
                                        <i class="icofont-thin-double-right"></i>
                                        {{-- <span class="font-size-xs text-muted ml-3">18</span> --}}
                                    </a>
                                </li>
                                <li class="widget-list-item">
                                    <a class="widget-list-link d-flex justify-content-between align-items-center" href="{{ url('category/previsions-fournisseurs') }}">
                                        <span>Prévisions de recoltes</span>
                                        <i class="icofont-thin-double-right"></i>
                                        {{-- <span class="font-size-xs text-muted ml-3">18</span> --}}
                                    </a>
                                </li>
                                {{-- <li class="widget-list-item">
                                    <a class="widget-list-link d-flex justify-content-between align-items-center" href="{{ url('demande-clients') }}">
                                        <span>Demandes des clients</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                        <!-- Trending posts-->
                        <div class="widget mb-grid-gutter pb-grid-gutter border-bottom">
                            <h3 class="widget-title">Derniers publications</h3>
                            {!! listing_post($parametre->type_id, $categorie_id = $rubrique->id, $apparence_id = 12, $limit = 5, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'created_at desc', $typeImage = 'thumb', $page = null, $additif = null, $restriction = [$post->id]) !!}
                            {{-- <div class="media align-items-center mb-3">
                                <a href="#">
                                    <img class="rounded" src="web/img/blog/widget/02.jpg" width="64" alt="Post image">
                                </a>
                                <div class="media-body pl-3">
                                    <h6 class="blog-entry-title font-size-sm mb-0">
                                        <a href="#">Retro Cameras are Trending. Why so Popular?</a>
                                    </h6>
                                    <span class="font-size-ms text-muted">by
                                        <a href='#' class='blog-entry-meta-link'>Andy Williams</a>
                                    </span>
                                </div>
                            </div> --}}
                        </div>
                        <!-- Popular tags-->
                        {{-- <div class="widget mb-grid-gutter">
                        <h3 class="widget-title">Popular tags</h3><a class="btn-tag mr-2 mb-2" href="#">#fashion</a><a class="btn-tag mr-2 mb-2" href="#">#gadgets</a><a class="btn-tag mr-2 mb-2" href="#">#online shopping</a><a class="btn-tag mr-2 mb-2" href="#">#top brands</a><a class="btn-tag mr-2 mb-2" href="#">#travel</a><a class="btn-tag mr-2 mb-2" href="#">#cartzilla news</a><a class="btn-tag mr-2 mb-2" href="#">#personal finance</a><a class="btn-tag mr-2 mb-2" href="#">#tips &amp; tricks</a>
                        </div> --}}
                        <!-- Promo banner-->
                        {!! listing_post($parametre->type_id, 631, $apparence_id = 10, $limit = 3, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'created_at desc', $typeImage = 'thumb', $page = null, $additif = null) !!}
                        {{-- <div class="bg-size-cover bg-position-center rounded-lg py-5" style="background-image: url(web/img/blog/banner-bg.jpg);">
                            <div class="py-5 px-4 text-center">
                                <h5 class="mb-2">Your Add Banner Here</h5>
                                <p class="font-size-sm text-muted">Hurry up to reserve your spot</p>
                                <a class="btn btn-primary btn-shadow btn-sm" href="#">Contact us</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
