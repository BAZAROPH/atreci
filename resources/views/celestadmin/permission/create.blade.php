@extends('celestadmin.layouts.app', [
    'title' => $infosPage['title']
])

@section('content')
    <div class="wrapper">
        @include('celestadmin.layouts.menu')
        <!-- Sidebar chat end-->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="main-header">
                        <h4>{{ $infosPage['title'] }}</h4>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="breadcrumb-icon-block">
                                    <ul id="breadcrumb-triangle">
                                        <li><a href="{{ url('/') }}">
                                            <span class="icofont icofont-home"> </span>
                                        </a></li>
                                        <li><a href="{{ url('celestadmin/'.$infosPage['slug']) }}">
                                            <span class="{{ $infosPage['icon'] }}"> </span>
                                            {{ $infosPage['element'] }}
                                        </a></li>
                                        <li><a href="#">
                                            <span class="icofont icofont-ui-rate-add"></span>
                                            Ajout
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-block">
                                    <div class="md-float-material">
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input autofocus id="name" name="name" value="{{ (request('id')) ? $valeur->name : old('name') }}" type="text" class="md-form-control">
                                                <label for="name">Name <i class="text-danger">*</i></label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('name')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="md-group-add-on text-center">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                {!! (request('id')) ? "<i class='icofont-edit m-r-5'> </i> MODIFIER " : "<i class='icofont-plus m-r-5'> </i> AJOUTER" !!}
                                            </button>
                                            <a href="{{ url('celestadmin/'.$infosPage['slug']) }}" class="btn btn-default waves-effect waves-light">
                                                <i class="icofont icofont-reply m-r-5"> </i>RETOUR
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('celestadmin.permission.listing')
                    </div>
                </form>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
    <script src="{{ asset('celestadmin/pages/form-validation.js') }}"></script>
@endsection
