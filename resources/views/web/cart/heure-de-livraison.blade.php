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
                <form class="needs-validation align-items-center" method="post" action="{{ url('choix-heure') }}" tabindex="-1" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-8">
                            <select name="heure" class="form-control-lg form-control" id="heure" required>
                                <option value="">Choisissez votre heure de livraison</option>
                                @foreach ($heures as $item)
                                    <option value="{{$item->id }}" {{ ($item->id == old('heure')) ? 'selected' : '' }}>
                                        {{ $item->libelle }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Choisissez votre pays!</div>
                            @error('heure')
                                <div class="text-danger text-center">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="col pl-0">
                            <button class="btn btn-success btn-lg btn-block" type="submit">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i> Valider
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            @include('web.cart.recapitulatif')
        </div>
    </div>
@endsection
