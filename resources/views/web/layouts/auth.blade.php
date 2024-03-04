@guest
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ (old('name')) ? '' : 'active' }}" href="#signin-tab" data-toggle="tab" role="tab" aria-selected="true">
                                <i class="czi-unlocked mr-2 mt-n1"></i>Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (old('name')) ? 'active' : '' }}" href="#signup-tab" data-toggle="tab" role="tab" aria-selected="false">
                                <i class="czi-user mr-2 mt-n1"></i>Inscription
                            </a>
                        </li>
                    </ul>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body tab-content py-4">
                    <form class="needs-validation tab-pane fade {{ (old('name')) ? '' : 'show active' }}" autocomplete="off" novalidate id="signin-tab" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="text-center mb-3">
                            <a class="social-btn sb-outline sb-facebook sb-lg connexion-social" href="{{ url('/auth/facebook') }}">
                                <i class="czi-facebook"></i>
                                Se connecter avec Facebook
                            </a>
                        </div>
                        <div class="text-center">
                            <a class="social-btn sb-outline sb-google sb-lg connexion-social" href="{{ url('/auth/google') }}">
                                <i class="czi-google"></i>
                                Se connecter avec Google
                            </a>
                        </div>
                        <div class="form-group">
                            <label for="si-email">Email</label>
                            <input name="email" class="form-control" type="email" id="si-email" placeholder="koffiabou@example.com" required>
                            <div class="invalid-feedback">
                                Veuillez fournir une adresse email valide.
                            </div>
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="si-password">Mot de passe</label>
                            <div class="password-toggle">
                                <input name="password" class="form-control" type="password" id="si-password" required>
                                <label class="password-toggle-btn">
                                    <input class="custom-control-input" type="checkbox">
                                    <i class="czi-eye password-toggle-indicator"></i>
                                    <span class="sr-only">Afficher le mot de passe</span>
                                </label>
                                @error('password')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between">
                            <div class="custom-control custom-checkbox mb-2">
                                <input class="custom-control-input" type="checkbox" id="si-remember">
                                <label class="custom-control-label" for="si-remember">
                                    Rester connecter
                                </label>
                            </div>
                            <a class="font-size-sm" href="{{ route('password.request') }}">Mot de passe oublié?</a>
                        </div>
                        <button class="btn btn-primary btn-block btn-shadow" type="submit">
                            Se connecter
                        </button>
                    </form>

                    <form class="needs-validation tab-pane fade {{ (old('name')) ? 'show active' : '' }}" autocomplete="off" novalidate id="signup-tab" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="text-center mb-3">
                            <a class="social-btn sb-outline sb-facebook sb-lg connexion-social" href="{{ url('/auth/facebook') }}">
                                <i class="czi-facebook"></i>
                                S'inscrire avec Facebook
                            </a>
                        </div>
                        <div class="text-center">
                            <a class="social-btn sb-outline sb-google sb-lg connexion-social" href="{{ url('/auth/google') }}">
                                <i class="czi-google"></i>
                                S'inscrire avec Google
                            </a>
                        </div>
                        <div class="form-group">
                            <label for="su-name">Nom complet</label>
                            <input value="{{ old('name') }}" name="name" class="form-control" type="text" id="su-name" placeholder="Koffi Abou" required>
                            <div class="invalid-feedback">Veuillez remplir votre nom.</div>
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="su-email">Email</label>
                            <input value="{{ old('email') }}" name="email" class="form-control" type="email" id="su-email" placeholder="koffiabou@example.com" required>
                            <div class="invalid-feedback">
                                Veuillez fournir une adresse email valide.
                            </div>
                            @error('email')
                                <span class="text-danger" role="alert">
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
                                    <span class="text-danger" role="alert">
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
                        <button name="sinscrire" class="btn btn-primary btn-block btn-shadow" type="submit">
                            S'inscrire
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endguest
