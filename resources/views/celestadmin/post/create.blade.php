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
                        <div class="col-md-8">
                            <div class="breadcrumb-icon-block">
                                <ul id="breadcrumb-triangle">
                                    <li>
                                        <a href="{{ url('/') }}">
                                            <span class="icofont-home"> </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('celestadmin/'.$infosPage['slug']) }}">
                                            <span class="{{ $infosPage['icon'] }}"> </span>
                                            {{ $infosPage['element'] }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                        {!! (request('id')) ? "<i class='$valeur->icon'></i> ".$valeur->libelle : '<span class="icofont-ui-rate-add"></span> Ajout' !!}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- @php(dd($errors->all())) --}}
            @foreach ($errors->all() as $error)
                <div class="row">
                    <div class="col-lg-12">
                        <p class="alert alert-danger f-16 text-center">{{ $error }}</p>
                    </div>
                </div>
            @endforeach
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-block">
                                <div class="md-float-material">
                                    @foreach ($categorie->champs as $champ)
                                        @switch($champ->type_champ->libelle)
                                            @case('varchar')
                                                <div class="md-group-add-on p-relative">
                                                    <span class="md-add-on">
                                                        <i class="icofont-notebook"></i>
                                                    </span>
                                                    <div class="md-input-wrapper">
                                                        <input id="{{ $champ->libelle }}" name="{{ $champ->libelle }}" value="{{ (request('id')) ? $valeur[$champ->libelle] : old($champ->libelle) }}" type="text" class="md-form-control">
                                                        <label for="{{ $champ->libelle }}">
                                                            {{ $champ->titre }}
                                                            {!! champ_obligatoire($champ->pivot->obligatoire) !!}
                                                        </label>
                                                    </div>
                                                    @error($champ->libelle)
                                                        <div class="text-danger text-center">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                @break
                                            @case('int')
                                                <div class="md-group-add-on p-relative">
                                                    <span class="md-add-on">
                                                        <i class="icofont-notebook"></i>
                                                    </span>
                                                    <div class="md-input-wrapper">
                                                        <input id="{{ $champ->libelle }}" name="{{ $champ->libelle }}" value="{{ (request('id')) ? $valeur[$champ->libelle] : old($champ->libelle) }}" type="number" class="md-form-control">
                                                        <label for="{{ $champ->libelle }}">
                                                            {{ $champ->titre }}
                                                            {!! champ_obligatoire($champ->pivot->obligatoire) !!}
                                                        </label>
                                                    </div>
                                                    @error($champ->libelle)
                                                        <div class="text-danger text-center">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                @break
                                            @case('select')
                                                @php($libelle = null)
                                                @if (request('id'))
                                                    @foreach ($valeur->categories as $item)
                                                        @if ($item->pivot->type == $champ->libelle)
                                                            @php($libelle = $item->id)
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <div class="md-group-add-on p-relative">
                                                    <span class="md-add-on">
                                                        <i class="icofont-notebook"></i>
                                                    </span>
                                                    <div class="md-input-wrapper">
                                                        <select id="{{ $champ->libelle }}" class="md-form-control" name="{{ $champ->libelle }}">
                                                            <option value="">----------------</option>
                                                            @php($occurences = DB::select($champ->requete))
                                                            @forelse ($occurences as $occurence)
                                                                @if (request('id'))
                                                                    <option value="{{ $occurence->id }}" {{ ( $occurence->id == $libelle) ? 'selected' : '' }}>
                                                                        {{ $occurence->libelle }}
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $occurence->id }}" {{ ($occurence->id == old('parent_id')) ? 'selected' : '' }}>
                                                                        {{ (isset($occurence->libelle)) ? $occurence->libelle : $occurence->name }}
                                                                    </option>
                                                                @endif
                                                            @empty

                                                            @endforelse
                                                        </select>
                                                        <label>{{ $champ->titre }}</label>
                                                    </div>
                                                    @error('{{ $champ->libelle }}')
                                                        <div class="text-danger text-center">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                @break

                                            @case('date')
                                                <div class="md-group-add-on p-relative">
                                                    <label for="{{ $champ->libelle }}">{{ $champ->titre }}</label>
                                                    <span class="md-add-on">
                                                        <i class="icofont-notebook"></i>
                                                    </span>
                                                    <div class="md-input-wrapper">
                                                        <input id="{{ $champ->libelle }}" name="{{ $champ->libelle }}" value="{{ (request('id')) ? ($valeur[$champ->libelle]) ? date("m/d/Y", strtotime($valeur[$champ->libelle])) : '' : old($champ->libelle) }}" type="text" class="form-control">
                                                        {{--  <label>{{ $champ->titre }}</label>  --}}
                                                    </div>
                                                    @error('{{ $champ->libelle }}')
                                                        <div class="text-danger text-center">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                @break

                                            @case('text')
                                                <div class="md-group-add-on p-relative">
                                                    <span class="md-add-on">
                                                        <i class="icofont-notebook"></i>
                                                    </span>
                                                    <div class="md-input-wrapper">
                                                        <textarea id="{{ $champ->libelle }}" name="{{ $champ->libelle }}" class="md-form-control" cols="2" rows="3">{{ (request('id')) ? $valeur[$champ->libelle] : old($champ->libelle) }}</textarea>
                                                        <label>{{ $champ->titre }}</label>
                                                    </div>
                                                    @error('{{ $champ->libelle }}')
                                                        <div class="text-danger text-center">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                @break


                                            @case('file')
                                                <div class="md-group-add-on p-relative">
                                                    <span class="md-add-on">
                                                        <i class="icofont-notebook"></i>
                                                    </span>
                                                    <div class="md-input-wrapper">
                                                        @if (request('id'))
                                                            {{-- <div id="app">
                                                                {{ url($valeur->getMedia('image')->first()->getUrl()) }}
                                                                <file-media :files="{{ $valeur->getMedia('image') }}"></file-media>
                                                            </div> --}}
                                                            @livewire('image-post')
                                                        @endif
                                                        @include('celestadmin.post.drop', [
                                                            'champ' => $champ
                                                        ])
                                                        {{-- <label>{{ $champ->titre }}</label> --}}
                                                    </div>
                                                    @error('{{ $champ->libelle }}')
                                                        <div class="text-danger text-center">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                @break

                                            @case('fileWeb')
                                                @php($libelle = null)
                                                @if (request('id'))
                                                    @foreach ($valeur->categories as $item)
                                                        @if ($item->pivot->type == $champ->libelle)
                                                            @php($libelle = $item->libelle)
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <div class="md-group-add-on p-relative">
                                                    <span class="md-add-on">
                                                        <i class="icofont-notebook"></i>
                                                    </span>
                                                    <div class="md-input-wrapper">
                                                        <input id="{{ $champ->libelle }}" name="{{ $champ->libelle }}" value="{{ (request('id')) ? $libelle : old($champ->libelle) }}" type="text" class="md-form-control">
                                                        <label for="{{ $champ->libelle }}">
                                                            {{ $champ->titre }}
                                                            {!! champ_obligatoire($champ->pivot->obligatoire) !!}
                                                        </label>
                                                    </div>
                                                    @error('{{ $champ->libelle }}')
                                                        <div class="text-danger text-center">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                @break

                                            @case('tarif---')
                                                <div class="md-group-add-on p-relative">
                                                    <span class="md-add-on">
                                                        <i class="icofont-notebook"></i>
                                                    </span>
                                                    <div class="md-input-wrapper">
                                                        {{-- <input id="{{ $champ->libelle }}" name="{{ $champ->libelle }}" value="{{ (request('id')) ? $valeur[$champ->libelle] : old($champ->libelle) }}" type="text" class="md-form-control"> --}}
                                                        <label for="{{ $champ->libelle }}">
                                                            {{ $champ->titre }}
                                                            {!! champ_obligatoire($champ->pivot->obligatoire) !!}
                                                        </label>
                                                        <div id="repeater">
                                                            <!-- Repeater Heading -->
                                                            <div class="repeater-heading">
                                                                <button class="btn btn-primary pt-5 pull-right repeater-add-btn">
                                                                    Ajouter
                                                                </button>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Repeater Items -->
                                                            <div class="items" data-group="test">
                                                                <!-- Repeater Content -->
                                                                <div class="item-content">
                                                                    <div class="form-group">
                                                                        <label for="inputEmail" class="col-lg-2 control-label">Name</label>
                                                                        <div class="col-lg-10">
                                                                            <input type="text" class="form-control" id="inputName" placeholder="Name" data-name="name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                                                        <div class="col-lg-10">
                                                                            <input type="text" class="form-control" id="inputEmail" placeholder="Email" data-skip-name="true" data-name="email">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Repeater Remove Btn -->
                                                                <div class="pull-right repeater-remove-btn">
                                                                    <button class="btn btn-danger remove-btn">
                                                                        Remove
                                                                    </button>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div class="items" data-group="test">
                                                                <!-- Repeater Content -->
                                                                <div class="item-content">
                                                                    <div class="form-group">
                                                                        <label for="inputEmail" class="col-lg-2 control-label">Name</label>
                                                                        <div class="col-lg-10">
                                                                            <input type="text" class="form-control" id="inputName" placeholder="Name" data-name="name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                                                        <div class="col-lg-10">
                                                                            <input type="text" class="form-control" id="inputEmail" placeholder="Email" data-skip-name="true" data-name="email">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Repeater Remove Btn -->
                                                                <div class="pull-right repeater-remove-btn">
                                                                    <button class="btn btn-danger remove-btn">
                                                                        Remove
                                                                    </button>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error($champ->libelle)
                                                        <div class="text-danger text-center">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                @break
                                            @default

                                        @endswitch
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-block">
                                <div class="md-float-material">
                                    @foreach ($categorie->champs as $champ)
                                        @switch($champ->type_champ->libelle)
                                        @case('checkbox')
                                            @php($occurences = checkbox($champ->slug))
                                            {{-- {{ dd($occurences->toArray()) }} --}}
                                            @if (count($occurences))
                                                <div class="md-group-add-on p-relative">
                                                    <span class="md-add-on">
                                                        <i class="icofont-notebook"></i>
                                                    </span>
                                                    <div class="md-input-wrapper">
                                                        @include('celestadmin.post.categorie')
                                                        {{-- <label for="{{ $champ->libelle }}">
                                                            {{ $champ->titre }}
                                                            {!! champ_obligatoire($champ->pivot->obligatoire) !!}
                                                        </label> --}}
                                                    </div>
                                                    @error('{{ $champ->libelle }}')
                                                        <div class="text-danger text-center">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                            @break
                                        @default
                                    @endswitch
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-10 btn-validation">
                    <div class="col-12">
                        <div class="md-group-add-on text-center">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    {!! (request('id')) ? "<i class='icofont-edit m-r-5'> </i> MODIFIER " : "<i class='icofont-plus m-r-5'></i> AJOUTER" !!}
                            </button>
                            <a href="{{ url('celestadmin/'.$infosPage['slug']) }}" class="btn btn-default waves-effect waves-light">
                                <i class="icofont icofont-reply m-r-5"> </i>RETOUR
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @include('celestadmin.layouts.footer')
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@endsection
