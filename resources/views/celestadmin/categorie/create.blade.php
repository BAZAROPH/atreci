@extends('celestadmin.layouts.app', [
    'title' => $infosPage['title'],
    'mode' => 'sql',
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
                        <div class="col-md-8">
                            <div class="breadcrumb-icon-block">
                                <ul id="breadcrumb-triangle">
                                    <li><a href="{{ url('/') }}">
                                        <span class="icofont-home"> </span>
                                    </a></li>
                                    <li><a href="{{ url('celestadmin/'.$infosPage['slug']) }}">
                                        <span class="{{ $infosPage['icon'] }}"> </span>
                                        {{ $infosPage['element'] }}
                                    </a></li>
                                    <li><a href="#">
                                        {!! (request('id')) ? "<i class='$valeur->icon'></i> ".$valeur->libelle : '<span class="icofont-ui-rate-add"></span> Ajout' !!}
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
                                            <input id="sous_titre" name="sous_titre" value="{{ (request('id')) ? $valeur->sous_titre : old('sous_titre') }}" type="text" class="md-form-control">
                                            <label for="sous_titre">Sous titre</label>
                                            <span class="messages"></span>
                                        </div>
                                        @error('sous_titre')
                                            <div class="text-danger text-center">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    @if ($taxonomie->type_taxonomie_id == 5)
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="lien" name="lien" value="{{ (request('id')) ? $valeur->lien : old('lien') }}" type="text" class="md-form-control">
                                                <label for="lien">Lien</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('lien')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        {{--  Requete pour menu  --}}
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <textarea style="display: none;" id="requete" name="requete" class="md-form-control">{{ (request('id')) ? $valeur->requete : old('requete') }}</textarea>
                                                <label for="requete">Requête (Eloquent, Query Bulder)</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('requete')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div id="editor">{{ (request('id')) ? $valeur->requete : "" }}</div>
                                    @endif

                                    @if ($infosPage['slug'] == 'pays')
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="indicateur" name="indicateur" value="{{ (request('id')) ? $valeur->indicateur : old('indicateur') }}" type="text" class="md-form-control">
                                                <label for="indicateur">Indicateur</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('indicateur')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    @endif

                                    @if ($infosPage['slug'] == 'categorie')
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="cout" name="cout" value="{{ (request('id')) ? $valeur->cout : old('cout') }}" type="number" class="md-form-control">
                                                <label for="cout">Coût</label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('cout')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="md-group-add-on p-relative">
                                        <span class="md-add-on">
                                            <i class="icofont-notebook"></i>
                                        </span>
                                        <div class="md-input-wrapper">
                                            <input placeholder="fa fa-qenium" id="icon" name="icon" value="{{ (request('id')) ? $valeur->icon : old('icon') }}" type="text" class="md-form-control">
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
                                            <input id="image" name="image" value="{{ old('image') }}" type="file" class="md-form-control">
                                            <label for="image">Image</label>
                                            <span class="messages"></span>
                                        </div>
                                        @if (request('id'))
                                            @if(!empty($valeur->getMedia('image')->first()))
                                                <div style="position: absolute; right:10px; margin-top:-40px;">
                                                    <img height="40" src="{{ url($valeur->getMedia('image')->first()->getUrl('thumb')) }}">
                                                </div>
                                            @endif
                                        @endif
                                        @error('image')
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
                                            <textarea id="description" name="description" class="md-form-control">{{ (request('id')) ? $valeur->description : old('description') }}</textarea>
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
                    @include('celestadmin.categorie.supplementaire')
                </div>
            </form>
        </div>
        @include('celestadmin.layouts.footer')
    </div>
</div>
@endsection
