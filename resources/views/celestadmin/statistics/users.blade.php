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
                                                <i class="icofont-ui-user-group"></i>
                                                {{-- <i class=""></i> --}}
                                               Utilisateur
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
                        {{-- Header --}}
                        <div class="card">
                            <div class="card-block">
                                <div class="row dashboard-header">
                                    <div class="col-lg-3 col-md-4">
                                       <div class="card dashboard-product">
                                            <span>Admin</span>
                                                <h2 class="dashboard-total-products">{{ $nbrAdmin }}</h2>
                                            <div class="side-box">
                                                <i class="icofont-user-male text-warning-color"></i>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                       <div class="card dashboard-product">
                                            <span>Détaillant</span>
                                                <h2 class="dashboard-total-products">{{ $nbrDetaillant }}</h2>
                                            <div class="side-box ">
                                                <i class="icofont-user-alt-1 text-danger-color"></i>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                       <div class="card dashboard-product">
                                            <span>Grossiste</span>
                                            <h2 class="dashboard-total-products">{{ $nbrGrossiste }}</h2>
                                            <div class="side-box">
                                                <i class="icofont-users-alt-1 text-success-color"></i>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                       <div class="card dashboard-product">
                                            <span>Fournisseur</span>
                                                <h2 class="dashboard-total-products">{{ $nbrFournisseur }}</h2>
                                            <div class="side-box">
                                                <i class="icofont-users-social text-info-color"></i>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Filtre et graphe 1 penché penché --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    {{-- filtre --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-right mb-1">
                                                <form action="{{ url('celestadmin/users/statistics')}}"  method="get">
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
                                    </div><br>
                                    {{-- graphe 1 penché penché --}}
                                    <div id="graphe1" style="min-width: 250px; height: 330px; margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-header-text">Les utilisateurs avec ou sans comptes /Temps</h5>
                                    </div>
                                    <div class="card-block">
                                        <div id="activityInToSite" style="min-width: 250px; height: 330px; margin: 0 auto"></div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="col-xl-4 col-lg-12 grid-item">
                                        <div class="card">
                                           <div class="card-block horizontal-card-img d-flex">
                                                <img class="media-object img-circle" src="{{ asset('admin/image/user.png')}}" alt="utilisateur image">
                                                <span class="d-inlineblock  p-l-20">
                                                    <h6>Utilisateurs connectés</h6>
                                                    <h4 class="text-success font-weight-bold">{{ $usersConnected }}</h4>
                                                </span>
                                              <h6 class="txt-success"><i class="icofont-user-alt-5"></i></h6>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-12 grid-item">
                                        <div class="card">
                                            <div class="card-block horizontal-card-img d-flex">
                                                <img class="media-object img-circle" src="{{ asset('admin/image/anonymous_users.png')}}" alt="Utilisateur image">
                                                <span class="d-inlineblock  p-l-20">
                                                    <h6>Utilisateurs sans comptes</h6>
                                                    <h4 class="text-danger font-weight-bold">{{ $usersNotConnected }}</h4>
                                                </span>
                                                <h6 class="txt-danger"><i class="icofont-user-alt-4"></i></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-12 grid-item">
                                        <div class="card">
                                            <div class="card-block horizontal-card-img d-flex">
                                                <img class="media-object img-circle" src="{{ asset('admin/image/user.png')}}" alt="Utilisateur image">
                                                <span class="d-inlineblock  p-l-20">
                                                    <h6>Total des comptes clients</h6>
                                                    <h4 class="text-warning font-weight-bold">{{ $nbrUsers }}</h4>
                                                </span>
                                                <h6 class="txt-warning"><i class="icofont-business-man-alt-1"></i><h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <div class="card">
                                   <div class="card-header">
                                        <h5 class="card-header-text">Statistiques sur les navigateurs utilisés</h5>
                                   </div>
                                   <div class="card-block">
                                        <div id="bloc2" style="min-width: 250px; height: 460px; margin: 0 auto">
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 grid-item">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class=" text-center font-weight-bold text-dark">Les clients les plus performants sur ces 30 derniers jours</h5>
                                    </div>
                                   <div class="card-block">
                                      <div class="table-responsive">
                                         <table class="table m-b-0">
                                            <thead>
                                               <tr class="text-capitalize">
                                                  <th class="text-muted text-center">#</th>
                                                  <th>Nom & prenom</th>
                                                  <th>Email</th>
                                                  <th class="text-center">Commandes</th>
                                                  <th class="text-center">Rôle</th>
                                                  <th class="text-center">Status</th>
                                                  <th>Date</th>
                                               </tr>
                                            </thead>
                                            <tbody>
                                                @php($i=0)
                                                @foreach ( $clientPerforms as $client )
                                                    <tr>
                                                        <td class="text-center"><a href="#">{{ $client->matricule }}</a>
                                                        </td>
                                                        <td>
                                                            <div class="text-dark" style="width: 180px;">
                                                                @if(!empty($client->getMedia('image')->first()))
                                                                    <img height="40" src="{{ url($client->getMedia('image')->first()->getUrl('thumb')) }}">
                                                                @else
                                                                    <img height="40" src="{{ asset('admin/image/user.png') }}">
                                                                @endif
                                                                @can('users show') <a class="text-dark" href="{{ route('user.show', $client) }}"> @endcan
                                                                    {{ $client->name }}
                                                                    {{ $client->prenom }}
                                                                @can('users show') </a> @endcan
                                                            </div>
                                                        </td>
                                                        <td>{{ $client->email }}</td>
                                                        <td class="text-center">
                                                            <span class="badge badge-success">
                                                            {{ $client->commandes_count }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            @foreach ($client->roles as $item)
                                                                {{ $item->name }} -
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center">
                                                            @if (count($client->session))
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
                                                            <div style="color:#fff; font-size:1px;">
                                                                {{ $client->created_at->format('Y/m/d H:i') }}
                                                            </div>
                                                            {{ $client->created_at->diffForHumans() }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="text-capitalize">
                                                   <th class="text-muted text-center">#</th>
                                                   <th>Nom & prenom</th>
                                                   <th>Email</th>
                                                   <th class="text-center">Commandes</th>
                                                   <th class="text-center">Rôle</th>
                                                   <th class="text-center">Status</th>
                                                   <th>Date</th>
                                                </tr>
                                            </tfoot>
                                         </table>
                                      </div>
                                   </div>
                                </div>
                            </div>
                        </div><br>
                    </div>
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection

@push('scripts')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


    <script>
        //Graphe sur les activités des détaillants
        Highcharts.getJSON(
            'https://cdn.jsdelivr.net/gh/highcharts/highcharts@v7.0.0/samples/data/usdeur.json',
            function (data) {
                Highcharts.chart('graphe1', {
                    chart: {
                        zoomType: 'x'
                    },
                    title: {
                        text: 'Activités des détaillant sur le temps'
                    },
                    xAxis: {
                        categories: [
                                @foreach ($commande_periode['commande'] as $commande )
                                    "{{ $commande['period'] }}",
                                @endforeach
                            ]
                    },
                    yAxis: {
                        title: {
                            text: 'Montant des commandes livrées'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[2]],
                                    [1, Highcharts.color(Highcharts.getOptions().colors[2]).setOpacity(0).get('rgba')]
                                ],
                            },
                            marker: {
                                radius: 2
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1
                                }
                            },
                            threshold: null
                        }
                    },

                    series: [{
                        type: 'area',
                        name: 'USD to EUR',
                        data: [
                                @foreach ($commande_periode['commande'] as $gain_sur_com_liv)
                                    {{ $gain_sur_com_liv['gain'] }},
                                @endforeach
                            ],
                        color:'#5CB990'
                    }]
                });
            }
        );

        //Bloc1 histogramme---------------------
        Highcharts.chart('activityInToSite', {
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Activité des utilisateurs du site'
            },
            subtitle: {
                text: 'Source: atre.ci'
            },
            xAxis: {
                categories: [
                    @foreach (range(0,23) as $hour )
                        {{ $hour}}+"h",
                    @endforeach
                ]
            },
            yAxis: {
                title: {
                    text: 'Nombre de client(s)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Inscrit',
                data: [
                    @foreach ($usersWithAccount as $elt )
                        {{ $elt }},
                    @endforeach
                ],
                color:'#5CB990',
            }, {
                name: 'Non Inscrit',
                data: [
                    @foreach ($usersWithoutAccount as $elt )
                        {{ $elt }},
                    @endforeach
                ],
                color:'#d9534f',
            }]
        });


        //Bloc sur les navigateurs-----------------------
        Highcharts.chart('bloc2', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
                //  backgroundColor:'#fff'
            },
            title: {
                text: 'Part des navigateurs'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Part du navigateur',
                data: [
                    {
                        name: 'Firefox',
                        y: {{ $browsers['firefox'] }},
                        sliced: true,
                        selected: true,
                        color:'#2BBBAD'
                    },
                    {
                        name: 'Internet Explorer',
                        y: {{ $browsers['internet_explorer'] }},
                        color:'#39444e'
                        },
                    {
                        name: 'Chrome',
                        y: {{ $browsers['chrome'] }},
                        color:'#2196F3'
                    },
                    {
                        name: 'Safari',
                        y: {{ $browsers['safari'] }},
                        color:'#3F729B'
                    },
                    {
                        name: 'Opera',
                        y: {{ $browsers['opera'] }},
                        color:'#f57c00'
                    },
                    {
                        name: 'Autres',
                        y: {{ $browsers['other'] }},
                        color:'#aa66cc'
                    }
                ]
            }]
        });

    </script>
@endpush

