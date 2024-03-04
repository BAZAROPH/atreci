@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    @include('web.user.entete', [
        'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">'.$infosPage['title'].'</li>',
    ])
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <section class="col-lg-8">
                <!-- Steps-->
                <div class="steps steps-light pt-2 pb-3 mb-5">
                    <a class="step-item active" href="{{ url('/panier') }}">
                        <div class="step-progress">
                            <span class="step-count">1</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-cart"></i>Panier
                        </div>
                    </a>

                    <a class="step-item active" href="{{ url('adresse-de-livraison') }}">
                        <div class="step-progress">
                            <span class="step-count">2</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-google-map"></i>Adresse
                        </div>
                    </a>

                    <span class="step-item active current" href="#">
                        <div class="step-progress">
                            <span class="step-count">3</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-ui-calendar"></i>Date & heure
                        </div>
                    </span>

                    <span class="step-item" href="{{ url('') }}">
                        <div class="step-progress">
                            <span class="step-count">4</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-card"></i>Paiement
                        </div>
                    </span>
                    <span class="step-item" href="{{ url('') }}">
                        <div class="step-progress">
                            <span class="step-count">5</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-check-circle"></i>Résumé
                        </div>
                    </span>
                </div>
                @include('flash::message')

                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger text-center">{{ $error }}</p>
                @endforeach
                <div class="row pt-4">
                    <div class="col-md-5 mb-grid-gutter">
                        <a href="{{ url()->current().'?date=tomorrow' }}" class="btn btn-success btn-block btn-lg">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> Livrer demain
                        </a>
                    </div>
                    <div class="col-md-1 mb-grid-gutter align-self-center text-center">
                        OU
                    </div>
                    <div class="col-md-6 mb-grid-gutter">
                        <form class="form-inline needs-validation" method="post" action="{{ url('choix-date') }}" tabindex="-1" novalidate>
                            @csrf
                            <input name="date" required min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}" class="form-control form-control-lg mb-3 mr-sm-1" type="date" placeholder="Choisir votre date de livraison">
                            <button class="btn btn-danger btn-lg mb-3" type="submit">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i> Valider
                            </button>
                            <div class="invalid-feedback">Choisissez correctement votre date de livraison!</div>
                        </form>
                    </div>
                </div>
            </section>
            @include('web.cart.recapitulatif')
        </div>
    </div>
@endsection
