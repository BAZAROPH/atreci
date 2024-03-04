@extends('celestadmin.layouts.app', [
    'title' => $infosPage['title']
])
@section('content')
    <div class="wrapper">
        @include('celestadmin.layouts.menu')
        <div class="content-wrapper">
        <!-- Sidebar chat end-->
            <div class="container-fluid">
                <div class="row">
                    <div class="main-header">
                        <h4>{{ $infosPage['title'] }}</h4>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="breadcrumb-icon-block">
                                    <ul id="breadcrumb-triangle">
                                        <li>
                                            <a href="{{ url('/celestadmin') }}">
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
                                                <span class="icofont-ui-v-card"></span>
                                                Détails commandes N° {{ $valeur->reference }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-right m-r-2 m-t-2">
                                    <a href="#" class="btn btn-success waves-effect" data-toggle="modal" data-target="#corbeille" title="Voir l'historique">
                                        <i class="icofont-history"></i>
                                        Historique
                                    </a>
                                    <div class="modal fade" id="corbeille" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h5 class="modal-title text-center" id="exampleModalLabel">
                                                        Historique de la commande
                                                    </h5>
                                                </div>
                                                <div class="modal-body">
                                                    {{-- Ton code Roxane --}}
                                                    <table id="activity_log" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Description</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Description</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            @foreach ($activities as $item)
                                                                <tr style="font-size: 14px;">
                                                                    <td>
                                                                        {{ $item->description }}
                                                                    </td>
                                                                    <td align="center">
                                                                        <span class="badge badge-success">
                                                                            {{ $item->created_at }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('celestadmin.commande.order')
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        'use strict';
        $(document).ready(function() {
            var simple = $('#activity_log').DataTable({
                "pageLength": 100,
                "language": {
                    "decimal":        "",
                    "emptyTable":     "aucune donnée disponible",
                    "info":           "Affichage _START_ to _END_ of _TOTAL_ entrées",
                    "infoEmpty":      "Affichage 0 to 0 of 0 entrées",
                    "infoFiltered":   "(Trie sur _MAX_ total entrées)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Affichage _MENU_ entrées",
                    "loadingRecords": "Chargement...",
                    "processing":     "Traitement...",
                    "search":         "Rechercher:",
                    "zeroRecords":    "Aucun enregistrements correspondants trouvés",
                    "paginate": {
                        "first":      "Premier",
                        "last":       "Dernier",
                        "next":       "Suivant",
                        "previous":   "Précédent"
                    },
                    "aria": {
                        "sortAscending":  ": activer pour trier les colonnes par ordre croissant",
                        "sortDescending": ": activer pour trier la colonne par ordre décroissant"
                    }
                }
            });
        });
    </script>
@endpush
