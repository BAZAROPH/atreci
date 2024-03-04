<form method="POST" action="{{ url('findMatricule') }}" class="form-box mt-5">
    @csrf
    <div class="form-group">
        <input placeholder="{{ __('Matricule de votre parrain *') }}" id="matricule" type="text" class="form-control @error('matricule') is-invalid @enderror" name="matricule" value="{{ old('matricule') }}" required autocomplete="matricule" autofocus>
        @error('matricule')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-0">
        <button type="submit" class="btn btn-warning btn-block text-uppercase">
            {{ __('Valider') }}
        </button>
    </div>

    <div class="form-group mt-3 text-center">
        <a class="btn" href="{{ url('register?default=1') }}">S'inscire sans parrain</a>
    </div>
</form>
