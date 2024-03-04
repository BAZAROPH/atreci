@extends('celestadmin.layouts.app', [
    'title' => $infosPage['title']
])

@section('content')
    <link rel="stylesheet" href="{{ asset('orgchart/css/jquery.orgchart.css') }}">
    <style>
        #chart-container {
            font-family: Arial;
            height: 420px;
            border: 2px dashed #aaa;
            border-radius: 5px;
            overflow: auto;
            text-align: center;
        }
    </style>
    <div class="wrapper">
        @include('celestadmin.layouts.menu')
        <!-- Sidebar chat end-->
        <div class="content-wrapper">
            <div class="container-fluid">
                @include('celestadmin.layouts.header', [
                    'id' => '/q',
                ])
                @if (request('status') == 'trashed')
                    @php($valeurs = $trashed)
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                <table id="simpletable" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Matricule</th>
                                            <th>Nom & Prénoms</th>
                                            <th>Email</th>
                                            <th>Commande</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Matricule</th>
                                            <th>Nom & Prénoms</th>
                                            <th>Email</th>
                                            <th>Commande</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php ($k = 0)
                                        @foreach ($valeurs as $valeur)
                                            @php ($k++)
                                            <tr style="font-size: 14px;">
                                                <td>{{ $k }}</td>
                                                <td>
                                                    {{ $valeur->matricule }}
                                                </td>
                                                <td>
                                                   <div style="width: 100px;">
                                                        @if(!empty($valeur->getMedia('image')->first()))
                                                            <img height="40" src="{{ url($valeur->getMedia('image')->first()->getUrl('thumb')) }}">
                                                        @else
                                                            <img height="40" src="{{ asset('admin/image/user.png') }}">
                                                        @endif
                                                        @can($infosPage['slug'].' show') <a href="{{ route('user.show', $valeur) }}"> @endcan
                                                            {{ $valeur->name }}
                                                            {{ $valeur->prenom }}
                                                        @can($infosPage['slug'].' show') </a> @endcan
                                                        {{-- <span class="badge badge-danger">
                                                            {{ count($valeur->childrens) }}
                                                        </span> --}}
                                                   </div>
                                                </td>
                                                <td>
                                                    <div style="width: 170px;">
                                                        {{ $valeur->email }}
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <span class="badge badge-success">
                                                        {{ $valeur->commandes_count }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @foreach ($valeur->roles as $item)
                                                        {{ $item->name }} -
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if (count($valeur->session))
                                                        <li class="text-success">
                                                            En ligne
                                                        </li>
                                                    @else
                                                        <li class="text-muted">
                                                            Hors ligne
                                                        </li>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{--  @include('celestadmin.user.action', [
                                                        'i' => $k
                                                    ])  --}}
                                                    {{--  @include('celestadmin.layouts.action', [
                                                        'i' => $k
                                                    ])  --}}


                                                    {{-- Show --}}
                                                    @can($infosPage['can'].'users show')
                                                        @if (request('status') != 'trashed')
                                                            <a href="{{ url('celestadmin/'.$infosPage['slug'].'/'.$valeur->id) }}" class="btn btn-primary waves-effect" data-toggle="tooltip" data-placement="top" title="Voir" data-original-title="Voir">
                                                                <i class="icofont-eye"></i>
                                                            </a>
                                                        @endif
                                                    @endcan

                                                    {{--  Edit  --}}
                                                    @can($infosPage['can'].'users edit')
                                                        @if (request('status') != 'trashed')
                                                            <a href="{{ url('celestadmin/'.$infosPage['slug'].'/edit/'.$valeur->id) }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier">
                                                                <i class="icofont icofont-edit"></i>
                                                            </a>
                                                        @endif
                                                    @endcan


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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection
