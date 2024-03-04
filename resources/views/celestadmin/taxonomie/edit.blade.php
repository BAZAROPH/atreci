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
                                            <span class="icofont icofont-card"></span>
                                            {{ $valeur->libelle }}
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
                                                <select id="type_taxonomie_id" class="md-form-control" name="type_taxonomie_id" required>
                                                    <option>----------------</option>
                                                    @foreach ($type_valeurs as $type_valeur)
                                                        <option value="{{ $type_valeur->id }}" {{ ( $type_valeur->id == $valeur->type_taxonomie_id) ? 'selected' : '' }}>
                                                            {{ $type_valeur->libelle }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label>Type taxonomie <i class="text-danger">*</i></label>
                                            </div>
                                            <div style="right:10px; position:absolute;">
                                                <a target="_blank" href="{{ url('celestadmin/type-taxonomies/create') }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Si le type de taxonomie que vous cherchez n'existe pas créer un nouveau" data-original-title="Si le type de taxonomie que vous cherchez n'existe pas créer un nouveau">
                                                    <i class="icofont-ui-add"></i>
                                                    Ajouter nouveau type
                                                </a>
                                            </div>
                                            @error('type_taxonomie_id')
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
                                                <input id="libelle" name="libelle" value="{{ $valeur->libelle }}" type="text" class="md-form-control">
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
                                                <input id="sous_titre" name="sous_titre" value="{{ $valeur->sous_titre }}" type="text" class="md-form-control">
                                                <label for="sous_titre">Sous titre</label>
                                                <span class="messages"></span>
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
                                                <input id="cout" name="cout" value="{{ $valeur->cout }}" type="number" class="md-form-control">
                                                <label for="cout">Coût</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('cout')
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
                                                <input placeholder="fa fa-qenium" id="icon" name="icon" value="{{ $valeur->icon }}" type="text" class="md-form-control">
                                                <label for="icon">Icon</label>
                                                <span class="messages"></span>
                                                <div>
                                                    <a class="text-warning" href="https://fontawesome.com/v4.7.0/icons/" target="_blank">Font Awesone</a> --
                                                    <a class="text-warning" href="https://icofont.com/icons" target="_blank">Ico Font</a>
                                                </div>
                                            </div>
                                            @error('icon')
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
                                                <textarea id="description" name="description" class="md-form-control" cols="2" rows="3">{!! $valeur->description !!}</textarea>
                                                <label for="description">Description</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('description')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="md-group-add-on text-center">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                <i class="icofont-ui-edit m-r-5"></i>MODIFIER
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
