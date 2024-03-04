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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                <div class="md-float-material">
                                    <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="md-group-add-on p-relative">
                                            <span class="md-add-on">
                                                <i class="icofont-notebook"></i>
                                            </span>
                                            <div class="md-input-wrapper">
                                                <input id="name" name="name" value="{{ (request('id')) ? $valeur->name : old('name') }}" type="text" class="md-form-control">
                                                <label for="name">Name <i class="text-danger">*</i></label>
                                                <span class="messages"></span>
                                            </div>
                                            @error('name')
                                                <div class="text-danger text-center">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="md-group-add-on p-relative">
                                            <style>
                                                .rkmd-checkbox {
                                                    display: block;
                                                }
                                            </style>
                                            <div class="checkbox-color checkbox-danger">
                                                <input onclick="toggle(this);" id="checkbox1" type="checkbox">
                                                <label for="checkbox1">
                                                        Toutes les permissions
                                                </label>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="z-depth-top-0 p-10 m-t-10">
                                                        @php($i = 0)
                                                        @php($j = 0)
                                                        @foreach ($permissions as $item)
                                                            @php($i++)
                                                            @php($j++)
                                                            <div class="rkmd-checkbox checkbox-rotate checkbox-ripple">
                                                                <label class="input-checkbox checkbox-warning">
                                                                    @if (request('id'))
                                                                        @php($checked = '')
                                                                        @for ($k = 0; $k < count($valeur->permissions); $k++)
                                                                            @if ($valeur->permissions[$k]->id == $item->id)
                                                                                @php($checked = 'checked')
                                                                                @break
                                                                            @endif
                                                                        @endfor
                                                                        <input value="{{ $item->name }}" name="permissions[]" type="checkbox" id="checkbox-{{ $i }}" {{ $checked }}>
                                                                    @else
                                                                        <input value="{{ $item->name }}" name="permissions[]" type="checkbox" id="checkbox-{{ $i }}" {{ ($item->name == old('permissions[]')) ? 'checked' : '' }}>
                                                                    @endif
                                                                    <span class="checkbox"></span>
                                                                </label>
                                                                <div class="captions">{{ $item->name }}</div>
                                                            </div>
                                                            @if ($j == 4)
                                                                @php($j = 0)
                                                                </div></div><div class="col-md-4"><div class="z-depth-top-0 p-10 m-t-10">
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
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
    <script>
        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endsection
