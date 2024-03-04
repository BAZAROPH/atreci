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
                <div class="row">
                    <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-block">
                                    <div class="md-float-material">
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont icofont-user"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <select id="type_id" class="md-form-control" name="type_id">
                                                    <option value="">----------------</option>
                                                    @foreach ($type_valeurs as $type_valeur)
                                                        @if (request('id'))
                                                            <option value="{{ $type_valeur->id }}" {{ ( $type_valeur->id == $valeur->type_id) ? 'selected' : '' }}>
                                                                {{ $type_valeur->libelle }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $type_valeur->id }}" {{ ($type_valeur->id == old('type_id')) ? 'selected' : '' }}>
                                                                {{ $type_valeur->libelle }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <label for="type_id">Type de site web <i class="text-danger">*</i></label>
                                            </div>
                                            @error('type_id')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="libelle" name="libelle" value="{{ (request('id')) ? $valeur->libelle : old('libelle') }}" type="text" class="md-form-control">
                                                <label for="libelle">Libellé <i class="text-danger">*</i></label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('libelle')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="title" name="title" value="{{ (request('id')) ? $valeur->title : old('title') }}" type="text" class="md-form-control">
                                                <label for="title">Title <i class="text-danger">*</i></label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('title')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="sous_titre" name="sous_titre" value="{{ (request('id')) ? $valeur->sous_titre : old('sous_titre') }}" type="text" class="md-form-control">
                                                <label for="sous_titre">Sous titre</label>
                                            </div>
                                            @error('sous_titre')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="email" name="email" value="{{ (request('id')) ? $valeur->email : old('email') }}" type="text" class="md-form-control">
                                                <label for="email">Email <i class="text-danger">*</i></label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('email')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="url" name="url" value="{{ (request('id')) ? $valeur->url : old('url') }}" type="text" class="md-form-control">
                                                <label for="url">URL <i class="text-danger">*</i></label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('url')
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
                        <div class="col-lg-4 bg-white p-t-1">
                            <div class="md-group-add-on p-relative">
                                <span class="md-add-on">
                                    <i class="icofont-notebook"></i>
                                </span>
                                <div class="md-input-wrapper">
                                    <textarea id="description" name="description" class="md-form-control" cols="2" rows="3">{{ (request('id')) ? $valeur->description : old('description') }}</textarea>
                                    <label for="description">Description</label>
                                    <span class="messages"></span>
                                </div>
                                @error('description')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="md-group-add-on p-relative">
                                <span class="md-add-on">
                                    <i class="icofont-notebook"></i>
                                </span>
                                <div class="md-input-wrapper">
                                    <textarea id="keywords" name="keywords" class="md-form-control">{{ (request('id')) ? $valeur->keywords : old('keywords') }}</textarea>
                                    <label for="keywords">Mots clés</label>
                                    <span class="messages"></span>
                                </div>
                                @error('keywords')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="md-group-add-on p-relative">
                                <span class="md-add-on">
                                    <i class="icofont-notebook"></i>
                                </span>
                                <div class="md-input-wrapper">
                                    <input id="logo" name="logo" value="{{ old('logo') }}" type="file" class="md-form-control">
                                    <label for="logo">Logo</label>
                                    <span class="messages"></span>
                                </div>
                                @if (request('id'))
                                    @if(!empty($valeur->getMedia('logo')->first()))
                                        <div style="position: absolute; right:10px; margin-top:-40px;">
                                            <img height="40" src="{{ url($valeur->getMedia('logo')->first()->getUrl('thumb')) }}">
                                        </div>
                                    @endif
                                @endif
                                @error('logo')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="md-group-add-on p-relative">
                                <span class="md-add-on">
                                    <i class="icofont-notebook"></i>
                                </span>
                                <div class="md-input-wrapper">
                                    <input id="icon" name="icon" value="{{ old('icon') }}" type="file" class="md-form-control">
                                    <label for="icon">Icône</label>
                                    <span class="messages"></span>
                                </div>
                                @if (request('id'))
                                    @if(!empty($valeur->getMedia('icon')->first()))
                                        <div style="position: absolute; right:10px; margin-top:-40px;">
                                            <img height="40" src="{{ url($valeur->getMedia('icon')->first()->getUrl('thumb')) }}">
                                        </div>
                                    @endif
                                @endif
                                @error('icon')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection
