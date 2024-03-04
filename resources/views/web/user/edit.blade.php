@extends('web.layouts.app', [
    'title' => 'Modification profil',
    'page' => 'profil',
])
@section('content')

@include('web.user.entete', [
    'breadcrumb' => '<li class="breadcrumb-item">
        <a class="text-nowrap" href="'.url('/profil').'"><i class="czi-user"></i>Votre compte</a>
    </li>
    <li class="breadcrumb-item text-nowrap active" aria-current="page">Commandes</li>',
])

<div class="container pb-5 mb-2 mb-md-3">
    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
        </div>
    </div>
    <div class="row">
        @include('web.user.compte-user')
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
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data" class="form-box">
                @csrf
                <div class="form-group">
                    <input placeholder="{{ __('Nom *') }}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input placeholder="{{ __('Prénoms *') }}" id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ auth()->user()->prenom }}" required autocomplete="prenom">
                    @error('prenom')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input placeholder="{{ __('Date de naissance') }}" id="date_naissance" type="date" class="form-control @error('date_naissance') is-invalid @enderror" name="date_naissance" value="@if(auth()->user()->date_naissance) {{ date('Y-m-d', strtotime(auth()->user()->date_naissance)) }} @endif" autocomplete="date_naissance">
                    @error('date_naissance')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <input placeholder="{{ __('Lieu d\'adhésion *') }}" id="adresse" type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" value="{{ auth()->user()->adresse }}" required autocomplete="adresse" autofocus>
                    @error('adresse')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <select name="sexe" class="form-control form-control-md" id="sexe">
                        <option value="">-- Votre sexe --</option>
                        <option value="Masculin" {{ (auth()->user()->sexe == 'Masculin') ? 'selected' : '' }}>Masculin</option>
                        <option value="Feminin" {{ (auth()->user()->sexe == 'Feminin') ? 'selected' : '' }}>Feminin</option>
                    </select>
                    @error('sexe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input placeholder="{{ __('Email') }}" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3" style="padding-right: 0;">
                            <input maxlength="4" class="form-control" type="text" required value="{{ auth()->user()->indicatif_telephone }}" name="indicatif_telephone">
                        </div>
                        <div class="col-md-9" style="padding-left: 0;">
                            <input placeholder="{{ __('Téléphone *') }}" id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ auth()->user()->telephone }}" required autocomplete="telephone" autofocus>
                        </div>
                    </div>
                    @error('telephone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @error('indicatif_telephone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3" style="padding-right: 0;">
                            <input maxlength="4" class="form-control" type="text" required value="{{ auth()->user()->indicatif_whatsapp }}" name="indicatif_whatsapp">
                        </div>
                        <div class="col-md-9" style="padding-left: 0;">
                            <input placeholder="{{ __('Whatsapp') }}" id="whatsapp type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ auth()->user()->whatsapp }}" autocomplete="whatsapp" autofocus>
                        </div>
                    </div>
                    @error('whatsapp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @error('indicatif_whatsapp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <select class="form-control @error('type_piece') is-invalid @enderror" name="type_piece" id="type_piece" required>
                        <option value="">Choisissez votre type de pièce *</option>
                        <option value="cni" {{ (auth()->user()->type_piece == 'cni') ? 'selected' : '' }}>CNI</option>
                        <option value="passeport" {{ (auth()->user()->type_piece == 'passeport') ? 'selected' : '' }}>Passeport</option>
                        <option value="attestation" {{ (auth()->user()->type_piece == 'attestation') ? 'selected' : '' }}>Attestation d'identité</option>
                    </select>
                    @error('type_piece')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                {{-- <div class="form-group">
                    <input placeholder="{{ __('Numéro de la pièce *') }}" id="numero_piece" type="text" class="form-control @error('numero_piece') is-invalid @enderror" name="numero_piece" value="{{ auth()->user()->numero_piece }}" required autocomplete="numero_piece">
                    @error('numero_piece')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <textarea rows="5" placeholder="{{ __('Votre biographie') }}" id="biographie" type="text" class="form-control @error('biographie') is-invalid @enderror" name="biographie">{{ auth()->user()->biographie }}</textarea>
                    @error('biographie')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-success btn-block text-uppercase btn-lg">
                        {{ __('Valider') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>
@endsection
