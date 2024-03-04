@extends('celestadmin.layouts.app', [
    'title' => 'Tableau de bord'
])

@section('content')
    <div class="wrapper">
        @include('celestadmin.layouts.menu')
        <!-- Sidebar chat end-->
        <div class="content-wrapper">
            <!-- Container-fluid starts -->
            <!-- Main content starts -->
            <div class="container-fluid">
                <div class="row">
                    <div class="main-header">
                        <h4>Tableau de bord</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card dashboard-product">
                            <div class="row dashboard-header">
                                <div class="col-lg-3 col-md-4">
                                    <a href={{url('celestadmin/commandes')}}>
                                        <div class="card dashboard-product">
                                            <span>Commandes en attentes</span>
                                            <h2 class="dashboard-total-products" style="font-size:20px">
                                                {{$nbrCommandeEnAttente}}
                                            </h2>
                                            {{-- <span class="label label-warning">Sales</span>Arriving Today --}}
                                            <div class="side-box">
                                                <i class="icofont-cart-alt text-warning-color"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <a href="{{url('celestadmin/commandes')}}">
                                        <div class="card dashboard-product">
                                            <span>Recette journalière</span>
                                            <h2 class="dashboard-total-products" style="font-size:20px">
                                                {{ $recetteJournaliere }}
                                            </h2>
                                            {{-- <span class="label label-success">Views</span>View Today --}}
                                            <div class="side-box ">
                                                <i class="icofont-money text-success-color"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <a href={{url('celestadmin/users')}}>
                                        <div class="card dashboard-product">
                                            <span>Utilisateur(s) connecté(s)</span>
                                            <h2 class="dashboard-total-products" style="font-size:20px"><span>{{$usersConnectes}}</span></h2>
                                            {{-- <span class="label label-info">Sales</span>Reviews --}}
                                            <div class="side-box">
                                                <i class="icofont-connection text-info-color"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <a href={{url('celestadmin/users')}}>
                                        <div class="card dashboard-product">
                                        <span>Nombre total client</span>
                                        <h2 class="dashboard-total-products" style="font-size:20px"><span>{{$nbrClient}}</span></h2>
                                        {{-- <span class="label label-primary">Sales</span>Reviews --}}
                                            <div class="side-box">
                                                <i class="icofont-ui-user-group text-danger-color"></i>
                                            </div>
                                       </div>
                                    </a>
                                </div>
                            </div>
                                <!-- -->
                            <div id="barchart" style="min-width: 250px; height: 330px; margin: 0 auto"></div><br>
                                <!-- -->
                            <div class="row dashboard-header">
                                <div class="col-lg-3 col-md-4">
                                    <a href={{url('celestadmin/commandes')}}>
                                        <div class="card dashboard-product">
                                            <span>Commandes livrées</span>
                                            <h2 class="dashboard-total-products" style="font-size:20px">
                                                {{ devise($montantTotalCommandesLivrees) }}
                                            </h2>
                                            <div class="side-box">
                                                <span class="badge badge-success">{{$nombreTotalCommandesLivrees}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <a href="{{url('celestadmin/commandes')}}">
                                        <div class="card dashboard-product">
                                            <span>Commandes en attentes</span>
                                            <h2 class="dashboard-total-products" style="font-size:20px">{{ devise($montantTotalCommandesAttentes)}}
                                            </h2>
                                            {{-- <span class="label label-success">Views</span>View Today --}}
                                            <div class="side-box ">
                                                {{-- <i class="icofont-money text-success-color"></i> --}}
                                                <span class="badge badge-warning">{{$nbrCommandeEnAttente}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <a href={{url('celestadmin/users')}}>
                                    <div class="card dashboard-product">
                                        <span>Commandes annulées</span>
                                        <h2 class="dashboard-total-products " style="font-size:20px">
                                            <span>{{ devise($montantTotalCommandesAnnulees) }}</span>
                                        </h2>
                                        {{-- <span class="label label-info">Sales</span>Reviews --}}
                                        <div class="side-box">
                                        {{-- <i class="icofont-connection text-info-color"></i> --}}
                                        <span class="badge badge-info">{{ $nombreTotalCommandesAnnulees }}</span>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <a href={{url('celestadmin/users')}}>
                                        <div class="card dashboard-product">
                                        <span>Comptes recemment crées</span>
                                        <h2 class="dashboard-total-products" style="font-size:20px">
                                            <span>{{$nbrClientIncritsRecen}}</span></h2>
                                        {{-- <span class="label label-primary">Sales</span>Reviews --}}
                                            <div class="side-box">
                                                {{-- <i class="icofont-ui-user-group text-danger-color"></i> --}}
                                                <span class="badge badge-danger">{{$nbrClientIncritsRecen}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- -->

                            <table id="simpletable" class="table dt-responsive nowrap">
                                <thead>
                                    <h2 class="text-center" style="font-size: 20px">Dernier clients inscrit</h2>
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
                                    @foreach ($listeLastClientIns as $valeur)
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
                                                    @can('users show') <a href="{{ route('user.show', $valeur) }}"> @endcan
                                                        {{ $valeur->name }}
                                                        {{ $valeur->prenom }}
                                                    @can('users show') </a> @endcan
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
                                                @can('users show')
                                                    @if (request('status') != 'trashed')
                                                        <a href="{{ url('celestadmin/users/'.$valeur->id) }}" class="btn btn-primary waves-effect" data-toggle="tooltip" data-placement="top" title="Voir" data-original-title="Voir">
                                                            <i class="icofont-eye"></i>
                                                        </a>
                                                    @endif
                                                @endcan

                                                {{--  Edit  --}}
                                                @can('users edit')
                                                    @if (request('status') != 'trashed')
                                                        <a href="{{ url('celestadmin/users/edit/'.$valeur->id) }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier">
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

                            <!-- -->
                            <div id="barpie" style="min-width: 250px; height: 330px; margin: 0 auto"></div><br>
                            <!-- -->
                            <table id="simpletable2" class="table dt-responsive nowrap">
                                <thead>
                                    <h2 class="text-center" style="font-size: 20px">Clients performants les 30 derniers jours</h2>
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
                                    @foreach ($clientsPerforms as $valeur)
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
                                                    @can('users show') <a href="{{ route('user.show', $valeur) }}"> @endcan
                                                        {{ $valeur->name }}
                                                        {{ $valeur->prenom }}
                                                    @can('users show') </a> @endcan
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
                                                @can('users show')
                                                    @if (request('status') != 'trashed')
                                                        <a href="{{ url('celestadmin/users/'.$valeur->id) }}" class="btn btn-primary waves-effect" data-toggle="tooltip" data-placement="top" title="Voir" data-original-title="Voir">
                                                            <i class="icofont-eye"></i>
                                                        </a>
                                                    @endif
                                                @endcan

                                                {{--  Edit  --}}
                                                @can('users edit')
                                                    @if (request('status') != 'trashed')
                                                        <a href="{{ url('celestadmin/users/edit/'.$valeur->id) }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier">
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
                             <!-- -->
                        </div>
                    </div>
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        @if($commande_periode)
            //Histogramme
            Highcharts.chart('barchart', {
                title: {
                    text: 'Commandes des 7 derniers jours'
                },
                xAxis: {
                    categories: [
                            @foreach ($commande_periode['commande'] as $commande )
                                "{{ $commande['period'] }}",
                            @endforeach
                        //'Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'
                        ]
                },
                labels: {
                    items: [{
                        html: 'Total des commandes',
                        style: {
                            left: '130px',
                            top: '18px',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                        }
                    }]
                },
                series: [
                {
                    type: 'column',
                    name: 'Gain en Fcfa',
                    data: [
                            @foreach ($commande_periode['commande'] as $gain_sur_com_liv)
                                {{ $gain_sur_com_liv['gain'] }},
                            @endforeach
                    ],
                    color:'#5CB990'
                },{
                    type: 'column',
                    name: 'Total commande en attente',
                    data: [
                            @foreach ($commande_periode['commande'] as $total_com_att)
                                {{ $total_com_att['total_commande_en_attente'] }},
                            @endforeach
                    ],
                    color:'#EEAC54'
                },{
                    type: 'column',
                    name: 'Total commandes annulées',
                    data: [
                        @foreach ($commande_periode['commande'] as $manque_gagn)
                                {{ $manque_gagn['manque_a_gagne'] }},
                        @endforeach
                    ],
                    color:'#F71C28'
                },{
                    type: 'pie',
                    name: 'Total',
                    data: [

                    {
                        name: 'Gain',
                        y: {{ $commande_periode["cout_total"] }},
                        color: '#5CB990'
                    },{
                        name: 'Total commande en attente',
                        y: {{ $commande_periode["cout_total_com_att"] }},
                        color: '#EEAC54'
                    },{
                        name: 'Total commandes annulées',
                        y: {{ $commande_periode["manque_a_gagne_total"] }},
                        color:'#F71C28'
                    }],
                    center: [40, 20],
                    size: 100,
                    showInLegend: false,
                    dataLabels: {
                        enabled: false
                    }
                }]
            });
        @endif
        @if ($nbrUsersligneConnect)
            //camembert
            Highcharts.chart('barpie', {
                title: {
                    text: 'Visiteur avec compte, sans compte'
                },

                series: [{
                    type: 'pie',
                    allowPointSelect: true,
                    keys: ['name', 'y', 'selected', 'sliced'],
                    data: [
                        ['visiteur(s) avec compte', {{ $nbrUsersligneConnect}}, true,true],
                        ['Visiteur(s) sans compte', {{ $nbrUsersligneNoConnect}}, false],

                    ],
                    showInLegend: true
                }]
            });
        @endif

    </script>

    <script>
        'use strict';
        $(document).ready(function() {
            var simple = $('#simpletable2').DataTable({
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
