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
                        <h4>
                            {{ $infosPage['title'] }}
                            <span class="badge badge-warning">{{ count($valeurs) }}</span>
                        </h4>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="breadcrumb-icon-block">
                                    <ul id="breadcrumb-triangle">
                                        <li><a href="{{ url('/') }}"><span class="icofont icofont-home"> </span></a></li>
                                        <li><a href="#"><span class="{{ $infosPage['icon'] }}"> </span> {{ $infosPage['title'] }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2" style="margin-top:20px;">
                                <a href="{{ url('celestadmin/'.$infosPage['slug'].'/create') }}" class="btn btn-primary">
                                    <i class="icofont icofont-ui-rate-add"></i> AJOUTER
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @include('flash::message')
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                @if (count($valeurs) >= 1)
                                    <table id="simpletable" class="table dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Libellé</th>
                                                <th>Guard</th>
                                                <th>Action</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Libellé</th>
                                                <th>Guard</th>
                                                <th>Action</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @php ($i = 0)
                                            @foreach ($valeurs as $valeur)
                                                @php ($i++)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>
                                                        {{ $valeur->name }}
                                                    </td>
                                                    <td>
                                                        {{ $valeur->guard_name }}
                                                    </td>
                                                    <td>
                                                        @include('celestadmin.role.modal')
                                                    </td>
                                                    <td>
                                                        <div style="color:#fff; font-size:1px;">
                                                            {{ $valeur->created_at->format('Y/m/d H:i') }}
                                                        </div>
                                                        {{ $valeur->created_at->diffForHumans() }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-danger">Pas de permissions</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection
