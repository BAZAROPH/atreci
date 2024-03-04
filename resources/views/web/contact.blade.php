@extends('web.layouts.app', [
    'title' => 'Contact',
    'page' => 'profil',
])
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8 bg-white pt-4 pb-4">
            <form class="form-horizontal" action="{{ url('contact') }}" role="form" id="primaryPostForm" method="POST" data-toggle="validator" enctype="multipart/form-data">
                @csrf
                <h4 class="text-uppercase border-bottom">
                    Envoyez un message
                </h4>

                <div class="input-group mb-1">
                    <input id="title" name="libelle" type="text" class="form-control form-control-md" placeholder="Nom & prénoms *" required value="{{ old('libelle') }}">
                    @error('libelle')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-1">
                    <input id="title" name="email" type="email" class="form-control form-control-md" placeholder="Email *" required value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-1">
                    <input id="title" name="telephone" type="text" class="form-control form-control-md" placeholder="Téléphone" value="{{ old('telephone') }}">
                    @error('telephone')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-1">
                    <textarea rows="4" name="description" id="description" class="form-control" data-error="Saisir votre message" placeholder="Votre message *" required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{--  <button class="post-submit btn btn-primary sharp btn-md btn-style-one btn-block" type="submit" name="publier">ENVOYER</button>  --}}
            </form>
        </div>
    </div>
</div>
@endsection
