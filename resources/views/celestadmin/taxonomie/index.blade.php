@extends('celestadmin.layouts.app', [
    'title' => $infosPage['title']
])

@section('content')
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
                                            <th>Libellé</th>
                                            <th>Type</th>
                                            <th>Catégorie</th>
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Libellé</th>
                                            <th>Type</th>
                                            <th>Catégorie</th>
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php ($i = 0)
                                        @foreach ($valeurs as $valeur)
                                            @php ($i++)
                                            {{-- @php(create_permission('-t '.$valeur->slug)) --}}
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <span data-toggle="tooltip" data-placement="top" title="{!! strip_tags($valeur->description) !!}" data-original-title="{!! strip_tags($valeur->description) !!}">
                                                        <i class="{{ $valeur->icon }} text-warning-color"></i>
                                                        {{ $valeur->libelle }}
                                                        @if (!empty($valeur->visible))
                                                            <i class="badge badge-danger">{{ $valeur->visible }}</i>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $valeur->type_taxonomie->libelle }}
                                                </td>
                                                <td>
                                                    @foreach ($valeur->categories as $item)
                                                        <div style="white-space:normal;width:200px">
                                                            - {{ $item->libelle }}
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @include('celestadmin.layouts.action')
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
