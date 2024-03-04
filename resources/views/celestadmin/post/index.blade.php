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
                    'id' => '/'.$categorie->id
                ])
                @if (request('status') == 'trashed')
                    @php($valeurs = $trashed)
                @endif
                <div class="text-right">
                    <a href="#" class="btn btn-success waves-effect" data-toggle="modal" data-target="#integrer" title="Intégrer au site">
                        <i class="icofont-code-alt"></i> Intégrer
                    </a>
                    <div class="modal fade" id="integrer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title text-center" id="exampleModalLabel">Vider la corbeille</h5>
                                </div>
                                <div class="modal-body text-left">
                                    <code>
                                        listing_post($parametre->type_id, $categorie_id = {{ $categorie->id }}, $apparence_id = {{ $categorie->apparences[0]->id }}, $limit = null, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = 'thumb', $page = null, $additif = null, $restriction = [])
                                    </code>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                <table id="simpletable" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Libellé</th>
                                            @if ($categorie->id == 229)
                                                <th>Prix (Fcfa)</th>
                                            @endif
                                            @if ($categorie->id == 229 or $categorie->id == 629 or $categorie->id == 630)
                                                <th>Catégories</th>
                                                <th>Commandé</th>
                                            @endif
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Libellé</th>
                                            @if ($categorie->id == 229)
                                                <th>Prix (Fcfa)</th>
                                            @endif
                                            @if ($categorie->id == 229 or $categorie->id == 629 or $categorie->id == 630)
                                                <th>Catégories</th>
                                                <th>Commandé</th>
                                            @endif
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php ($i = 0)
                                        @foreach ($valeurs as $valeur)
                                            @php ($i++)
                                            <tr>
                                                <td data-toggle="tooltip" data-placement="top" title="{{ $valeur->id }}" data-original-title="{{ $valeur->id }}">{{ $i }}</td>
                                                <td>
                                                    @if(!empty($valeur->getMedia('image')->first()))
                                                        <img style="margin-right: 10px; float: left;" width="80" src="{{ url($valeur->getMedia('image')->first()->getUrl('thumb')) }}">
                                                        <i class="{{ $valeur->icon }} text-warning-color"></i>
                                                    @else
                                                        <i class="{{ $valeur->icon }} text-warning-color"></i>
                                                    @endif
                                                    <div style="width: 300px;" data-toggle="tooltip" data-placement="top" title="{!! strip_tags($valeur->description) !!}" data-original-title="{!! strip_tags($valeur->description) !!}">
                                                        {{ $valeur->libelle }}
                                                    </div>
                                                </td>
                                                @if ($categorie->id == 229)
                                                    <td>
                                                        {{ $valeur->prix_nouveau }}
                                                    </td>
                                                @endif
                                                @if ($categorie->id == 229 or $categorie->id == 629 or $categorie->id == 2140)
                                                    <td>
                                                        @foreach ($valeur->categories as $item)
                                                            @if ($item->pivot->type == 'categorie')
                                                                - {{ $item->libelle }}<br>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{ count($valeur->commandes) }}
                                                    </td>
                                                @endif
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
