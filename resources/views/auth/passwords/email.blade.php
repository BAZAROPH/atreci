@extends('web.layouts.app', [
    'title' => 'Réinitialisation du mot de passe',
    'page' => 'auth',
])

@section('content')
<div class="container py-4 py-lg-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <h2 class="h4 mb-4 text-center">{{ __('Réinitialisation du mot de passe') }}</h2>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-warning btn-block">
                                    {{ __('Envoyer le lien de réinitialisation') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
