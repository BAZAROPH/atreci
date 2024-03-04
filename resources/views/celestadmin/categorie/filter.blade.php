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
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-block">
                                <div class="md-float-material">
                                    @php($i = 0)
                                    @foreach ($valeur->champs as $champ)
                                        @php($i++)
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input type="hidden" name="champs{{ $i }}" value="{{ $champ->id }}">
                                                <input id="rang{{ $i }}" name="rang{{ $i }}" value="{{ $champ->pivot->rang }}" type="number" class="md-form-control">
                                                <label for="rang{{ $i }}">{{ $champ->libelle }}</label>
                                            </div>
                                            @error('rang{{ $i }}')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    @endforeach

                                    <div class="md-group-add-on text-center">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                            VALIDER
                                        </button>
                                        <a href="{{ url('celestadmin/'.$infosPage['slug']) }}" class="btn btn-default waves-effect waves-light">
                                            <i class="icofont icofont-reply m-r-5"> </i>RETOUR
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @include('celestadmin.layouts.footer')
    </div>
</div>
@endsection
