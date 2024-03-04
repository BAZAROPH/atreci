@extends('web.layouts.app', [
    'title' => 'Inscription',
    'page' => 'auth',
])
@section('content')

    <div class="container py-4 py-lg-5 my-4">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <h2 class="h4 mb-4 text-center">Inscription</h2>
                        <form method="POST" action="{{ route('register') }}" class="form-box">
                            @csrf
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
                            <div class="form-group">
                                <label for="su-name">Nom complet</label>
                                <input name="name" class="form-control" type="text" id="su-name" placeholder="Koffi Abou" required>
                                <div class="invalid-feedback">Veuillez remplir votre nom.</div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="su-email">Email</label>
                                <input name="email" class="form-control" type="email" id="su-email" placeholder="koffiabou@example.com" required>
                                <div class="invalid-feedback">
                                    Veuillez fournir une adresse email valide.
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="su-password">Mot de passe</label>
                                <div class="password-toggle">
                                    <input name="password" class="form-control" type="password" id="su-password" required>
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox">
                                        <i class="czi-eye password-toggle-indicator"></i>
                                        <span class="sr-only">Afficher le mot de passe</span>
                                    </label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                {!! htmlFormSnippet() !!}
                                @error('g-recaptcha-response')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="su-password-confirm">Confirmer le mot de passe</label>
                                <div class="password-toggle">
                                    <input class="form-control" type="password" id="su-password-confirm" required>
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox">
                                        <i class="czi-eye password-toggle-indicator"></i>
                                        <span class="sr-only">Afficher le mot de passe</span>
                                    </label>
                                </div>
                            </div> --}}
                            <button class="btn btn-primary btn-block btn-shadow" type="submit">
                                S'inscrire
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
