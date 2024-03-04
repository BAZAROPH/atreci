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
                                            Modifier
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                <div class="md-float-material">
                                    <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont icofont-user"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <select id="role_id" class="md-form-control" name="role_id" required>
                                                    @foreach ($type_valeurs as $type_valeur)
                                                        <option value="{{ $type_valeur->id }}" {{ ( $type_valeur->id == old('role_id')) ? 'selected' : '' }}>
                                                        {{ $type_valeur->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label>Rôle<i class="text-danger">*</i></label>
                                            </div>
                                            @error('role_id')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont icofont-user"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="name" name="name" value="{{ $valeur->name }}" type="text" class="md-form-control">
                                                <label for="libelle">Nom <i class="text-danger">*</i></label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('name')
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
                                                <input id="prenom" name="prenom" value="{{ $valeur->prenom }}" type="text" class="md-form-control">
                                                <label for="prenom">Prénom <i class="text-danger">*</i></label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('prenom')
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
                                                <input id="adresse" name="adresse" value="{{ $valeur->adresse }}" type="text" class="md-form-control">
                                                <label for="adresse">Adresse</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('adresse')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="disable md-input-wrapper">
                                                <input id="telephone" name="telephone" value="{{ $valeur->telephone }}" type="text" class="md-form-control">
                                                <label for="telephone">Contact</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('telephone')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-mail-box"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input disabled="disabled" id="email" name="email" value="{{ $valeur->email }}" type="text" class="md-form-control">
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
                                                <div>
                                                    <label for="sexe">Genre</label>
                                                </div>
                                                <div>
                                                    <label checked for="">Masculin</label>
                                                    <input  {{ ($valeur->sexe=='M' ? 'checked' : '') }} type="radio" name="sexe" value="M">
                                                    <label for="">Feminin</label>
                                                    <input {{ ($valeur->sexe=='F' ? 'checked' : '') }} type="radio" name="sexe" value="F">
                                                </div>
                                            </div>
                                            @error('sexe')
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
                                                <textarea id="biographie" name="biographie" class="md-form-control" cols="2" rows="3">{{ $valeur->biographie }}</textarea>
                                                <label for="biographie">Biograhie</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('biographie')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont icofont-user"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <select id="commercial" class="md-form-control" name="commercial" required>
                                                    <option value=""></option>
                                                    @foreach ($admins as $admin)
                                                        <option value="{{ $admin->id }}" {{ ( $admin->id == $valeur->parent_id) ? 'selected' : '' }}>
                                                        {{ $admin->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label>Commercial<i class="text-danger">*</i></label>
                                            </div>
                                            @error('commercial')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        {{-- <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <textarea id="description" name="description" class="md-form-control" cols="2" rows="3">{{ old('description') }}</textarea>
                                                <label for="description">Description</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('description')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div> --}}

                                        <div class="md-group-add-on text-center">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                <i class="icofont icofont-plus m-r-5"> </i>Enregistrer
                                            </button>
                                            <a href="{{ url('celestadmin/'.$infosPage['slug']) }}" class="btn btn-default waves-effect waves-light">
                                                <i class="icofont icofont-reply m-r-5"> </i>RETOUR
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
    <script src="{{ asset('celestadmin/pages/form-validation.js') }}"></script>
@endsection
