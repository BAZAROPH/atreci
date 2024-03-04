@extends('web.layouts.app', [
    'title' => 'Modification photo de profil',
    'page' => 'profil',
])
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
        </div>
    </div>
    <div class="row">
        @include('web.user.compte-user')
        <div class="col-md-9">
            <h3>Modification photo de profil</h3>
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data" class="form-box">
                @csrf
                <div class="form-group">
                    <input type="file" name="photo" class="form-control form-control-lg @error('photo') is-invalid @enderror">
                    @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{!! $message !!}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-warning btn-block text-uppercase btn-lg">
                        {{ __('Valider') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>
@endsection
