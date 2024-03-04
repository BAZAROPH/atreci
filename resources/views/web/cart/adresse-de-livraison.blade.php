@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    {{--  <script type="text/javascript">
        $('#add-address').modal('show');
    </script>  --}}
    <form action="{{ url('addAddress') }}" class="needs-validation modal fade" method="post" id="add-address" tabindex="-1" novalidate>
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Nouvelle adresse de livraison
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address-country">
                                    Pays <span class="text-danger">*</span>
                                </label>
                                <select name="pays_id" class="custom-select" id="address-country" required>
                                    <option value="">-------Pays-------</option>
                                    @foreach ($pays as $item)
                                        <option value="{{ $item->id }}" {{ ($item->id == 928) ? 'selected' : '' }} >
                                            {{ $item->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Choisissez votre pays!</div>
                                @error('pays_id')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address-city">
                                    Ville <span class="text-danger">*</span>
                                </label>
                                <input value="{{ old('ville') }}" name="ville" class="form-control" type="text" id="address-city" required>
                                <div class="invalid-feedback">Veuillez indiquer votre ville!</div>
                                @error('ville')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address-line1">
                                    Lieu de livraison exact <span class="text-danger">*</span>
                                </label>
                                <input value="{{ old('adresse') }}" name="adresse" class="form-control" type="text" id="address-line1" required>
                                <div class="invalid-feedback">Veuillez indiquer votre lieu de livraison !</div>
                                @error('adresse')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address-line2">
                                    N°téléphone <span class="text-danger">*</span>
                                </label>
                                <input value="{{ old('telephone') }}" name="telephone" class="form-control" type="text" id="address-line2" required>
                                <div class="invalid-feedback">Veuillez indiquer votre numéro de téléphone !</div>
                                @error('telephone')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermer</button>
                    <button class="btn btn-primary btn-shadow" type="submit">Ajouter adresse</button>
                </div>
            </div>
        </div>
    </form>

    @foreach ($adresses as $item)
        {{--  Modification adresse de livraison  --}}
        <form action="{{ url('editAddress/'.$item->id) }}" class="needs-validation modal fade" method="post" id="edit-address{{ $item->id }}" tabindex="-1" novalidate>
            @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                            Modifier votre adresse <strong>"{{ $item->libelle }}"</strong>
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address-country">
                                        Pays <span class="text-danger">*</span>
                                    </label>
                                    <select name="pays_id" class="custom-select" id="address-country" required>
                                        <option value="">-------Pays-------</option>
                                        @foreach ($pays as $country)
                                            <option value="{{ $country->id }}" {{ ($country->id == $item->parent->id) ? 'selected' : '' }} >
                                                {{ $country->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Choisissez votre pays!</div>
                                    @error('pays_id')
                                        <div class="text-danger text-center">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address-city">
                                        Ville <span class="text-danger">*</span>
                                    </label>
                                    <input value="{{ $item->sous_titre }}" name="ville" class="form-control" type="text" id="address-city" required>
                                    <div class="invalid-feedback">Veuillez indiquer votre ville!</div>
                                    @error('ville')
                                        <div class="text-danger text-center">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address-line1">
                                        Lieu de livraison exact <span class="text-danger">*</span>
                                    </label>
                                    <input value="{{ $item->libelle }}" name="adresse" class="form-control" type="text" id="address-line1" required>
                                    <div class="invalid-feedback">Veuillez indiquer votre lieu de livraison !</div>
                                    @error('adresse')
                                        <div class="text-danger text-center">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address-line2">
                                        N°téléphone <span class="text-danger">*</span>
                                    </label>
                                    <input value="{{ $item->lien }}" name="telephone" class="form-control" type="text" id="address-line2" required>
                                    <div class="invalid-feedback">Veuillez indiquer votre numéro de téléphone !</div>
                                    @error('telephone')
                                        <div class="text-danger text-center">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermer</button>
                        <button class="btn btn-primary btn-shadow" type="submit">Modifier</button>
                    </div>
                </div>
            </div>
        </form>

        {{--  Suppression d'adresse  --}}
        <form action="{{ url('deleteAddress/'.$item->id) }}" class="needs-validation modal fade" method="post" id="delete-address{{ $item->id }}" tabindex="-1" novalidate>
            @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            Supprimer votre adresse <strong>"{{ $item->libelle }}"</strong>
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            Voulez-vous vraiment supprimer votre adresse de livraison <strong>"{{ $item->libelle }}"</strong>?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Non</button>
                        <button class="btn btn-primary btn-shadow" type="submit">
                            <i class="fa fa-trash" aria-hidden="true"></i> Oui
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endforeach

    @include('web.user.entete', [
        'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">'.$infosPage['title'].'</li>',
    ])
    {{--  <div class="page-title-overlap bg-dark pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ url('/') }}">
                                <i class="czi-home"></i>Accueil
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                <h1 class="h3 text-light mb-0">
                    Finalisation de la commande
                </h1>
            </div>
        </div>
    </div>  --}}
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

                    <a class="step-item active current" href="#">
                        <div class="step-progress">
                            <span class="step-count">2</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-google-map"></i>Adresse
                        </div>
                    </a>

                    <span class="step-item" href="#">
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
                <!-- Autor info-->
                {{--  <div class="d-sm-flex justify-content-between align-items-center bg-secondary p-4 rounded-lg mb-grid-gutter">
                    <div class="media align-items-center">
                        <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
                            <span class="badge badge-warning" data-toggle="tooltip" title="Reward points">384</span>
                            <img class="rounded-circle" src="img/shop/account/avatar.jpg" alt="Susan Gardner">
                        </div>
                        <div class="media-body pl-3">
                            <h3 class="font-size-base mb-0">Susan Gardner</h3>
                            <span class="text-accent font-size-sm">s.gardner@example.com</span>
                        </div>
                    </div>
                    <a class="btn btn-light btn-sm btn-shadow mt-3 mt-sm-0" href="account-profile.html">
                        <i class="czi-edit mr-2"></i>Edit profile
                    </a>
                </div>  --}}
                <div class="row pt-4">
                    @forelse ($adresses as $item)
                        <div class="col-lg-4 col-sm-6 mb-grid-gutter">
                            <div class="card border-0 box-shadow">
                                <div class="card-body">
                                    <a href="#edit-address{{ $item->id }}" data-toggle="modal" class="float-right">
                                        <i class="fa icofont-pen-alt-2" aria-hidden="true"></i>
                                    </a>
                                    <div><br></div>
                                    <a href="#delete-address{{ $item->id }}" data-toggle="modal" class="float-right">
                                        <i class="fa icofont-trash" aria-hidden="true"></i>
                                    </a>
                                    <ul class="list-unstyled mb-0">
                                        <li class="media pb-3 border-bottom">
                                            <i class="czi-location font-size-lg mt-2 mb-0 text-primary"></i>
                                            <div class="media-body pl-3">
                                                <span class="font-size-ms text-muted">Ville</span>
                                                <a class="d-block text-heading font-size-sm" href="#">
                                                    {{ $item->sous_titre }}, {{ $item->parent->libelle }}
                                                </a>
                                            </div>
                                        </li>
                                        <li class="media pt-2 pb-3 border-bottom">
                                            <i class="czi-phone font-size-lg mt-2 mb-0 text-primary"></i>
                                            <div class="media-body pl-3">
                                                <span class="font-size-ms text-muted">Téléphone</span>
                                                <a class="d-block text-heading font-size-sm" href="#">
                                                    {{ $item->lien }}
                                                </a>
                                            </div>
                                        </li>
                                        <li class="media pt-2">
                                            <i class="icofont-map font-size-lg mt-2 mb-0 text-primary"></i>
                                            <div class="media-body pl-3">
                                                <span class="font-size-ms text-muted">Lieu exact de livraison</span>
                                                <a class="d-block text-heading font-size-sm" href="">
                                                    {{ $item->libelle }}
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="text-center border-top">
                                        <a class="btn btn-success btn-shadow btn-block mt-4" href="{{ url()->current().'?address_id='.$item->id }}">
                                            <i class="icofont-check-circled font-size-lg mr-2"></i> Choisissez
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12 mb-grid-gutter">
                            <div class="alert alert-danger text-center">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                Ajouter au moins une adresse de livraison
                            </div>
                        </div>
                    @endforelse
                    <div class="col-lg-12 mb-grid-gutter">
                        <div class="text-sm-right">
                            <a class="btn btn-primary" href="#add-address" data-toggle="modal">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                Ajouter une nouvelle adresse de livraison
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            @include('web.cart.recapitulatif')
        </div>
    </div>
@endsection
