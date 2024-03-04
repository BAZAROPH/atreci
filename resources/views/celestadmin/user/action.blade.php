{{-- Modal pour afficher les détails d'un user --}}
<div class="modal fade modal-flex" id="detail{{ $valeur->matricule }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Détails</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Matricule</td>
                            <td>{{ $valeur->matricule }}</td>
                        </tr>
                        <tr>
                            <td>Nom & prénoms</td>
                            <td>{{ $valeur->name }} {{ $valeur->prenom }}</td>
                        </tr>
                        @if($valeur->parent->matricule)
                            <tr class="text-danger">
                                <td>Parrain</td>
                                <td>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Matricule</th>
                                                <th>Nom & prénoms</th>
                                                <th>Téléphone</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $valeur->parent->matricule }}</td>
                                                <td>
                                                    <a href="detail{{ $valeur->parent->matricule }}" data-toggle="modal" data-target="#detail{{ $valeur->parent->matricule }}">
                                                        {{ $valeur->parent->name }}
                                                        {{ $valeur->parent->prenom }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $valeur->parent->indicatif_telephone }}
                                                    {{ $valeur->parent->telephone }}
                                                </td>
                                                <td>{{ $valeur->parent->email }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>Email</td>
                            <td>{{ $valeur->email }}</td>
                        </tr>
                        <tr>
                            <td>Téléphone</td>
                            <td>{{ $valeur->indicatif_telephone }} {{ $valeur->telephone }}</td>
                        </tr>
                        <tr>
                            <td>Whatsapp</td>
                            <td>{{ $valeur->indicatif_whatsapp }} {{ $valeur->whatsapp }}</td>
                        </tr>
                        <tr>
                            <td>Biographie</td>
                            <td>{{ $valeur->biographie }}</td>
                        </tr>
                        <tr>
                            <td>Lieu d'adhésion</td>
                            <td>{{ $valeur->adresse }}</td>
                        </tr>
                        <tr>
                            <td>Sexe</td>
                            <td>{{ $valeur->sexe }}</td>
                        </tr>
                        <tr>
                            <td>Date de naissance</td>
                            <td>{{ $valeur->date_naissance }}</td>
                        </tr>
                        <tr>
                            <td>Piece</td>
                            <td>{{ $valeur->type_piece }} -- {{ $valeur->numero_piece }}</td>
                        </tr>
                        <tr>
                            <td>Date d'inscription</td>
                            <td>{{ $valeur->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Date de dernière modification</td>
                            <td>{{ $valeur->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@can('users permission')
    <a href="#" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#permissionModal{{ $k }}" data-toggle="tooltip" data-placement="top" title="Voir ses permissions" data-original-title="Voir ses permissions"><i class="icofont-ui-lock"></i>
    </a>
    <div class="modal fade" id="permissionModal{{ $k }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel">Permissions de " {{ $valeur->name }} {{ $valeur->prenom }}"</h5>
                </div>
                <div class="modal-body">
                    @forelse ($valeur->getAllPermissions() as $item)
                        <div class="pb-2">-{{ $item->name }}</div>
                    @empty
                        <div class="alert alert-danger" role="alert">
                            Pas de permissions
                        </div>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endcan
@can('users childrens')
    <a href="#" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#children{{ $k }}" title="Arboresence">
        <i class="icofont-users-social"></i>
    </a>
    <div class="modal fade" id="children{{ $k }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel">
                        Arboresence
                    </h5>
                </div>
                <div class="modal-body">
                    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
                    <script src="{{ asset('orgchart/js/jquery.orgchart.js') }}"></script>
                    <script>
                        (function($) {
                            $(function() {
                                var ds = {
                                    'name': '{{ $valeur->matricule }}',
                                    'title': '{{ $valeur->prenom." ".$valeur->name." -- ".$valeur->telephone }}',
                                    'children': [
                                        @php($i = 0)
                                        @foreach ($valeur->childrens as $item)
                                            @php($i++)
                                            {'name': '{{ $item->matricule }}',
                                                'title': '{{ $item->prenom." ".$item->name." -- ".$item->telephone }}',
                                            @if(count($item->childrens))
                                                'children': [
                                                    @include('celestadmin.categorie.children', [
                                                        'childrens' => $item->childrens,
                                                        'nombreIteration' => 1,
                                                        'page' => 'arborescence',
                                                        'i' => $i++,
                                                    ])
                                                ]
                                            @endif
                                            },
                                        @endforeach
                                    ]
                                };
                                var oc = $('#chart-container{{ $k }}').orgchart({
                                    'data' : ds,
                                    'nodeContent': 'title',
                                    //'visibleLevel': 999
                                });
                            });
                        })(jQuery);
                    </script>
                    <div id="chart-container{{ $k }}"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endcan
