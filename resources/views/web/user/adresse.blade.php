@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'commande',
])

@section('content')

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
                                    <option value="{{ $item->id }}" {{ ($item->id == 44) ? 'selected' : '' }} >
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
                <button class="btn btn-danger btn-shadow" type="submit">Ajouter adresse</button>
            </div>
        </div>
    </div>
</form>

@foreach ($user->adresses as $item)
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
                    <button class="btn btn-danger btn-shadow" type="submit">Modifier</button>
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
                    <button class="btn btn-danger btn-shadow" type="submit">
                        <i class="fa fa-trash" aria-hidden="true"></i> Oui
                    </button>
                </div>
            </div>
        </div>
    </form>
@endforeach

@include('web.user.entete', [
    'breadcrumb' => '<li class="breadcrumb-item">
        <a class="text-nowrap" href="'.url('/profil').'"><i class="czi-user"></i>Votre compte</a>
    </li>
    <li class="breadcrumb-item text-nowrap active" aria-current="page">Commandes</li>',
])

<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-3">
    <div class="row">
		@include('web.user.compte-user')
		<!-- Content  -->
		<section class="col-lg-8">
			<!-- Toolbar-->
			<div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
				<div class="{{-- form-inline--}} mb-4">
					<label class="text-light opacity-75 text-nowrap mr-2 d-none d-lg-block" for="order-sort"></label>
					{{-- <select class="form-control custom-select" id="order-sort">
						<option>Tout</option>
						<option>Livrer</option>
						<option>En attente</option>
						<option>Annuler</option>
					</select> --}}
                </div>
			</div>


			<!-- Orders list-->
			<div class="font-size-md">
                @include('flash::message')
				<table class="table table-hover mb-0" id="simpletable" style="width: 100%;">
					<thead>
						<tr>
                            <th>Date</th>
							<th>Adresse</th>
							<th>Nbr commandes</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
                        @foreach ($user->adresses as $item)
                            <tr>
                                <td class="py-3">
                                    <span type="button" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="{{ $item->created_at->format('d-m-Y H:i') }}">
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <a class="nav-link-style font-weight-medium font-size-sm" href="#{{ $item->id }}" data-toggle="modal">
                                        {{ $item->libelle }}
                                    </a>
                                    <div>
                                        {{ $item->sous_titre }}, {{ $item->parent->libelle }} -- [{{ $item->lien }}]
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge badge-success m-0">{{ count($item->commandes) }}</span>
                                </td>
                                <td class="py-3 align-middle">
                                    <a class="nav-link-style mr-2" href="#edit-address{{ $item->id }}" data-toggle="modal" title="Modifier">
                                        <i class="czi-edit"></i>
                                    </a>
                                    <a class="nav-link-style text-danger" href="#delete-address{{ $item->id }}" data-toggle="modal" title="Supprimer">
                                        <i class="czi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

					</tbody>
				</table>
			</div>
            <hr class="pb-4">
            <div class="text-sm-right">
                <a class="btn btn-danger" href="#add-address" data-toggle="modal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Nouvelle adresse
                </a>
            </div>
		</section>
	</div>
</div>
@endsection
