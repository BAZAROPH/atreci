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
                        </h4>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="breadcrumb-icon-block">
                                    <ul id="breadcrumb-triangle">
                                        <li>
                                            <a href="{{ url('/') }}">
                                                <i class="icofont-home"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('commandes') }}">
                                                <i class="icofont-food-basket"></i>
                                                {{-- <i class=""></i> --}}
                                               Commandes
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="{{ $infosPage['icon'] }}"></i>
                                                {{ $infosPage['title'] }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @php($slug = $infosPage['slug'])
                            @isset($infosPage['url'])
                                @php($slug = $infosPage['url'])
                            @endisset
                            @can($infosPage['can'].$slug.' create')
                                <div class="col-md-2" style="margin-top:20px;">
                                    <a href="{{ url('celestadmin/'.$infosPage['slug'].'/create') }}" class="btn btn-primary">
                                        <i class="icofont-ui-rate-add"></i> AJOUTER
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            {{-- <div class="card-block"> --}}
                                <div class="row dashboard-header">
                                    <div class="col-lg-4 col-md-4">
                                        {{-- <a href={{url('celestadmin/commandes')}}> --}}
                                        <div class="card dashboard-product">
                                            <span>Commandes livrées</span>
                                            <h2 class="dashboard-total-products" style="font-size:20px">{{$nombreTotalComLiv}}</h2>
                                            {{-- <span class="label label-warning">Sales</span>Arriving Today --}}
                                            <div class="side-box">
                                                <i class="icofont-cart-alt text-success-color"></i>
                                            </div>
                                        </div>
                                        {{-- </a> --}}
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        {{-- <a href="{{url('celestadmin/commandes')}}"> --}}
                                            <div class="card dashboard-product">
                                                <span>Commandes en attentes</span>
                                                <h2 class="dashboard-total-products" style="font-size:20px">{{$nombreTotalComAtt}}</h2>
                                                {{-- <span class="label label-success">Views</span>View Today --}}
                                                <div class="side-box ">
                                                    <i class="icofont-stopwatch text-warning-color"></i>
                                                </div>
                                            </div>
                                        {{-- </a> --}}
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        {{-- <a href={{url('celestadmin/users')}}> --}}
                                        <div class="card dashboard-product">
                                            <span>Commandes annulées</span>
                                            <h2 class="dashboard-total-products" style="font-size:20px"><span>{{$nombreTotalComAnnu}}</span></h2>
                                            {{-- <span class="label label-info">Sales</span>Reviews --}}
                                            <div class="side-box">
                                                <i class="icofont-close-line text-danger-color"></i>

                                        </div>
                                        {{-- </a> --}}
                                    </div>
                                </div>

                            {{-- </div> --}}
                        </div>

                        <!-- -->

                        {{-- <div class="card"> --}}

                            <!-- champ pour filtrer-->
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="text-right mb-1">
                                        <form action="{{ url('celestadmin/commandes/statistics')}}"  method="get">
                                            @csrf
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="reportrange" id="reportrange" value="">
                                                <span class="input-group-btn" id="btn-addon3.2">
                                                    <button type="submit" class="btn btn-success    addon-btn waves-effect waves-light">
                                                        Filtrer
                                                    </button>

                                                </span>
                                            </div>
                                        </form>

                                    </div>
                            </div>
                        </div>
                        <!-- -->

                        <div class="row dashboard-header mt-4">
                            {{-- <h2 class="text-center" style="font-size: 20px">Statistique selon le filtrage</h2> --}}
                            <div class="col-lg-3 col-md-4">
                                {{-- <a href={{url('celestadmin/commandes')}}> --}}
                                <div class="card dashboard-product">
                                    <span>Commandes livrées</span>
                                    <h2 class="dashboard-total-products" style="font-size:20px">{{$nombreTotalComLivFiltre}}</h2>
                                    {{-- <span class="label label-warning">Sales</span>Arriving Today --}}
                                    <div class="side-box">
                                        <i class="icofont-cart-alt text-success-color"></i>
                                    </div>
                                </div>
                                {{-- </a> --}}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{-- <a href="{{url('celestadmin/commandes')}}"> --}}
                                    <div class="card dashboard-product">
                                        <span>Commandes en attentes</span>
                                        <h2 class="dashboard-total-products" style="font-size:20px">{{$nombreTotalComAttFiltre}}</h2>
                                        {{-- <span class="label label-success">Views</span>View Today --}}
                                        <div class="side-box ">
                                            <i class="icofont-stopwatch text-warning-color"></i>
                                        </div>
                                    </div>
                                {{-- </a> --}}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{-- <a href={{url('celestadmin/users')}}> --}}
                                <div class="card dashboard-product">
                                    <span>Commandes annulées</span>
                                    <h2 class="dashboard-total-products" style="font-size:20px"><span>{{$nombreTotalComAnnuFiltre}}</span></h2>
                                    {{-- <span class="label label-info">Sales</span>Reviews --}}
                                    <div class="side-box">
                                        <i class="icofont-close-line text-danger-color"></i>
                                    </div>
                                </div>
                                {{-- </a> --}}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{-- <a href={{url('celestadmin/users')}}> --}}
                                <div class="card dashboard-product">
                                    <span>Commandes en paiement </span>
                                    <h2 class="dashboard-total-products" style="font-size:20px"><span>{{$nombreTotalComEnPaiementFiltre}}</span></h2>
                                    {{-- <span class="label label-info">Sales</span>Reviews --}}
                                    <div class="side-box">
                                        <i class="icofont-refresh text-info-color"></i>

                                    </div>
                                </div>
                                {{-- </a> --}}
                            </div>
                        </div>

                        <!-- Histogramme 01-->
                        <div id="barchart" style="min-width: 250px; height: 330px; margin: 0 auto"></div><br>

                        <!--Camambert -->

                        <div id="barpie" style="min-width: 250px; height: 330px; margin: 0 auto"></div><br>

                        <!--Histogramme 02-->

                        <div id="barhart" style="min-width: 250px; height: 330px; margin: 0 auto"></div><br>

                        <!-- Histogramme 03-->

                        <div id="barhar" style="min-width: 250px; height: 330px; margin: 0 auto"></div><br>

                        {{-- </div> --}}

                            <!--Recette Annuelle-->

                        <div class="row ">
                            <h2 class="text-center" style="font-size: 20px" >Recette Annuelle</h2>
                            @foreach ($commandes as $key => $element)
                            <div class="col-lg-6 col-md-4">
                                <div class="dashboard-product">
                                    <a class="btn-primary btn btn-block  waves-effect" href="#"
                                    data-toggle="modal" data-target="#default-Modal{{ $key }}" role="button">{{ $key }}</a>
                                    {{-- <button type="button" class="btn btn-inverse-warning waves-effect md-trigger" data-modal="modal-4">Newspaper</button> --}}
                                </div>
                                <!-- Modal -->
                                <div class="modal fade modal-flex" id="default-Modal{{ $key }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title">Recette mensulle {{ $key }}</h4>
                                            </div>
                                            {{-- <div class="modal-body">
                                                <h5>Janvier</h5>
                                                <h5>Fevrier</h5>
                                                <h5>Mars</h5>
                                                <h5>Avril</h5>
                                                <h5>Mai</h5>
                                                <h5>Juin</h5>
                                                <h5>Juillet</h5>
                                                <h5>Août</h5>
                                                <h5>Septembre</h5>
                                                <h5>Octobre</h5>
                                                <h5>Novembre</h5>
                                                <h5>Décemebre</h5>
                                            </div> --}}
                                            <table class="table table-striped  table-bordered ">

                                                <tbody>

                                                    @php ($nombreCommandeLivree=0)
                                                    @php ($nombreCommandeAnnulees=0)

                                                    @php ($totalCommandeLivree=0)
                                                    @php ($totalCommandeAnnulees=0)

                                                    @foreach ($element as $key=>$elmt )
                                                        <tr>
                                                            {{-- <td >{{$key}}</td> --}}
                                                            <td>{{ $key }}</td>
                                                            <td>
                                                                @foreach ($elmt as $i=>$value)
                                                                    @if ($value->etat_id == 110)
                                                                        <span class="text-success">Livrée: {{ devise($value->somme) }} </span>
                                                                        <span class="badge badge-success">{{$value->nombre }}</span><br/>
                                                                        @php($nombreCommandeLivree++)
                                                                        @php($totalCommandeLivree+=$value->somme)
                                                                    @elseif($value->etat_id == 112)
                                                                        <span class="text-danger">Annulée: {{ devise($value->somme) }} </span>
                                                                        <span class="badge badge-danger">{{$value->nombre }}</span>
                                                                        <br/>
                                                                        @php($nombreCommandeAnnulees++)
                                                                        @php($totalCommandeAnnulees+=$value->somme)
                                                                   @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>
                                                            <span class="text-success">livrée:{{ devise($totalCommandeLivree) }}<span><br/>
                                                            <span class="text-danger">Annulée:{{ devise($totalCommandeAnnulees) }}<span>
                                                        </td>
                                                    </tr>
                                                 </tfoot>
                                            </table>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success waves-effect " data-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           @endforeach

                        </div>
                        <!---->

                        <!-- -->

                        <!---->

                    </div>
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection

@push('scripts')
    @if($commande_periode)
        <script type="text/javascript">

            //Histogramme
            Highcharts.chart('barchart', {
            title: {
                text: 'Statistique des commandes'
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

            //camembert

            Highcharts.chart('barpie', {
                title: {
                    text: 'Nombre des commandes selon le types'
                },

                series: [{
                    type: 'pie',
                    allowPointSelect: true,
                    keys: ['name', 'y', 'selected', 'sliced'],
                    data: [
                        // ['Commandes livrées', {{ $commande_periode["nombre_commande_livrer"]}}, true,true],
                        // ['Commandes annulées', {{ $commande_periode["nombre_commande_annuler"]}}, false],
                        // ['Commandes en attente',  {{ $commande_periode["nombre_commande_en_attente"]}}, false]

                        ['Commandes en attente', {{ $nombreTotalComAttFiltre}}, true,true],
                        ['Commandes annulées', {{ $nombreTotalComAnnuFiltre}}, false],
                        ['Commandes livrées',  {{ $nombreTotalComLivFiltre}}, false]
                        // ['Commandes en attente',  {{ $montantTotalComAttFiltre}}, false]


                    ],
                    showInLegend: true
                }]
            });

             //Histogramme 02

             Highcharts.chart('barhart', {
            title: {
                text: 'Statistique des commandes en jours'
            },
            xAxis: {
                categories: [

                    @if (count ($commandesParJour))
                        @foreach ($commandesParJour as $commande )
                            "{{ $commande['day'] }}",
                        @endforeach
                    @endif
                    //'Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'
                    ]
            },
            labels: {
                items: [{
                    html: '',
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
                    @if (count ($commandesParJour))
                        @foreach ($commandesParJour as $commande)
                            {{ $commande['montant'] }},
                        @endforeach
                    @endif
                ],
                color:'#5CB990'
            },]
            });

            // Histogramme 03

            Highcharts.chart('barhar', {
            title: {
                text: 'Statistique des commandes en heures'
            },
            xAxis: {
                categories: [

                       @if (count ($commandesParHeure))
                            @foreach ( $commandesParHeure as $commande )
                                "{{ $commande['heure'] }}",
                            @endforeach
                        @endif
                    //'Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'


                    ]
            },
            labels: {
                items: [{
                    html: '',

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
                    @if (count ($commandesParHeure))
                        @foreach ($commandesParHeure as $commande)
                            {{ $commande['montant'] }},
                        @endforeach
                    @endif
                ],
                color:'#5CB990'
            }
            ]
            });


        </script>
    @endif
@endpush

