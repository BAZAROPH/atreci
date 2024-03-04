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
                                            <th>Valeurs</th>
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Libellé</th>
                                            <th>Type</th>
                                            <th>Valeurs</th>
                                            <th>Actions</th>
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
                                                    <span data-toggle="tooltip" data-placement="top" title="{!! strip_tags($valeur->titre) !!}" data-original-title="{!! strip_tags($valeur->titre) !!}">
                                                        <i class="{{ $valeur->icon }} text-warning-color"></i>
                                                        {{ $valeur->libelle }}
                                                        @if (!empty($valeur->visible))
                                                            <i class="badge badge-danger">{{ $valeur->visible }}</i>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $valeur->type_champ->libelle }}
                                                </td>
                                                <td>
                                                    @if (!empty($valeur->requete))
                                                        @php($occurences = DB::select($valeur->requete))
                                                        @foreach ($occurences as $item)
                                                            <div>- {{ (isset($item->libelle)) ? $item->libelle : $item->name }}</div>
                                                        @endforeach
                                                    @endif
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
