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
                    <div class="col-lg-8">
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
                                                <select id="type_apparence_id" class="md-form-control" name="type_apparence_id" required>
                                                    <option value="">----------------</option>
                                                    @foreach ($type_valeurs as $type_valeur)
                                                        <option value="{{ $type_valeur->id }}" {{ ( $type_valeur->id == $valeur->type_apparence_id) ? 'selected' : '' }}>
                                                            {{ $type_valeur->libelle }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="type_apparence_id">Type apparence <i class="text-danger">*</i></label>
                                            </div>
                                            @error('type_apparence_id')
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
                                                <i class="icofont icofont-user"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <select id="parent_id" class="md-form-control" name="parent_id">
                                                    <option value="">----------------</option>
                                                    @foreach ($apparences as $apparence)
                                                        <option value="{{ $apparence->id }}" {{ ( $type_valeur->id == $valeur->parent_id) ? 'selected' : '' }}>
                                                            {{ $apparence->libelle }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="parent_id">Parent</label>
                                            </div>
                                            @error('parent_id')
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
                                            @if(!empty($valeur->getMedia('image')->first()))
                                                <div style="position: absolute; right:10px; margin-top:-40px;">
                                                    <img height="40" src="{{ url($valeur->getMedia('image')->first()->getUrl('thumb')) }}">
                                                </div>
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
                                                <textarea class="display-none" name="code" class="md-form-control" cols="2" rows="1">{{ $valeur->description }}</textarea>
                                                <label style="margin-top: -15px;">Apparence proprement dite</label>
                                            </div>
                                            <div id="code">{{ $valeur->description }}</div>
                                            @error('code')
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
                                                <textarea class="display-none" name="debut" class="md-form-control" cols="2" rows="1">{{ $valeur->debut }}</textarea>
                                                <label style="margin-top: -15px;">Debut du block</label>
                                                <span class="messages"></span>
                                            </div>
                                            <div id="debut">{{ $valeur->debut }}</div>
                                            @error('debut')
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
                                                <textarea class="display-none" name="fin" class="md-form-control" cols="2" rows="1">{{ $valeur->fin }}</textarea>
                                                <label style="margin-top: -15px;">Fin du block</label>
                                                <span class="messages"></span>
                                            </div>
                                            <div id="fin">{{ $valeur->fin }}</div>
                                            @error('fin')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="md-group-add-on text-center">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                <i class="icofont-edit m-r-5"> </i>MODIFIER
                                            </button>
                                            <a href="{{ url('celestadmin/'.$infosPage['slug']) }}" class="btn btn-default waves-effect waves-light">
                                                <i class="icofont-reply m-r-5"> </i>RETOUR
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('celestadmin.apparence.champs')
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection
