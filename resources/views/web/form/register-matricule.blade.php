<form method="POST" action="{{ route('register') }}?matricule={{ request('matricule') }}" class="form-box">
    @csrf
    @if (request('matricule'))
        <h5 class="text-danger text-center">
            Votre parrain : <strong>{{ $user->prenom.' '.$user->name }}</strong>
        </h5>
    @endif
    <div class="form-group">
        <input placeholder="{{ __('Nom *') }}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        @error('name')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <input placeholder="{{ __('Prénoms *') }}" id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom" autofocus>
        @error('prenom')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <input placeholder="{{ __('Date de naissance') }}" id="date_naissance" type="date" class="form-control @error('date_naissance') is-invalid @enderror" name="date_naissance" value="{{ old('date_naissance') }}" autocomplete="date_naissance" autofocus>
        @error('date_naissance')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <input placeholder="{{ __('Lieu d\'adhésion *') }}" id="adresse" type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" value="{{ old('adresse') }}" required autocomplete="adresse" autofocus>
        @error('adresse')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <input placeholder="{{ __('Email') }}" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
        @error('email')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-3" style="padding-right: 0;">
                <input maxlength="4" class="form-control" type="text" required value="+225" name="indicatif_telephone">
            </div>
            <div class="col-md-9" style="padding-left: 0;">
                <input placeholder="{{ __('Téléphone *') }}" id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required autocomplete="telephone" autofocus>
            </div>
        </div>
        @error('telephone')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @error('indicatif_telephone')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <select class="form-control @error('type_piece') is-invalid @enderror" name="type_piece" id="type_piece" required>
            <option value="">Choisissez votre type de pièce *</option>
            <option value="cni">CNI</option>
            <option value="passeport">Passeport</option>
            <option value="attestation">Attestation d'identité</option>
        </select>
        @error('type_piece')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <input placeholder="{{ __('Numéro de la pièce *') }}" id="numero_piece" type="text" class="form-control @error('numero_piece') is-invalid @enderror" name="numero_piece" value="{{ old('numero_piece') }}" required autocomplete="name" autofocus>
        @error('numero_piece')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <input placeholder="{{ __('Mot de passe *') }}" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        @error('password')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <input placeholder="{{ __('Confimer le mot de passe *') }}" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
    </div>

    <div class="form-group mb-0">
        <button type="submit" class="btn btn-warning btn-block text-uppercase">
            {{ __('Valider') }}
        </button>
    </div>

    <div class="form-group mt-3 text-center">
        @if (request('matricule'))
            <a class="btn" href="{{ url('register?default=1') }}">Vous n'avez pas de parrain ? Cliquez ici</a>
        @else
            <a class="btn" href="{{ url('register') }}">Vous avez un parrain ? Cliquez ici</a>
        @endif
    </div>
</form>
