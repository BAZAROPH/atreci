@extends('web.layouts.app', [
    'title' => 'Connexion',
    'page' => 'auth',
])
@section('content')
<div class="container py-4 py-lg-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <h2 class="h4 mb-4 text-center">Connexion</h2>

                    <div class="py-3">
                        <h3 class="d-inline-block align-middle font-size-base font-weight-semibold mb-2 mr-2">
                            Se connecter avec
                        </h3>
                        <div class="d-inline-block align-middle text-center">
                            <a class="social-btn sb-google mr-2 mb-2" href="{{ url('/auth/google') }}" data-toggle="tooltip" title="Avec Google">
                                <i class="czi-google"></i>
                            </a>
                            <a class="social-btn sb-facebook mr-2 mb-2" href="{{ url('/auth/facebook') }}" data-toggle="tooltip" title="Avec Facebook">
                                <i class="czi-facebook"></i>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <h3 class="font-size-base pt-4 pb-2">Ou utiliser ce formulaire</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Rester connecté') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié ?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Connexion') }}
                                </button>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center mt-3">
                                <a class="btn btn-link" href="{{ url('register') }}">
                                    {{ __('Ou s\'inscrire ') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
