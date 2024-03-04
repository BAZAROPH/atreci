<div class="row">
    <div class="main-header">
        <h4>
            {{ $infosPage['title'] }}
            <span class="badge badge-success">
                {{ count($valeurs) }}
            </span>
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
    <div class="col-md-12">
        {{--  Afficher la corbeille si ce n'est pas les users  --}}
        @if (url()->current() != url('celestadmin/users'))
            <a href="{{ url()->current() }}">
                Publiés
                <span class="badge badge-success">
                    {{ count($valeurs) }}
                </span>
            </a>

            <a href="{{ url()->current() }}?status=trashed">
                Corbeille
                <span class="badge badge-danger">
                    {{ count($trashed) }}
                </span>
            </a>
            {{-- {{ $infosPage['can'].$slug.' trash' }} --}}
            @if (request('status') == 'trashed' and count($trashed) > 0)
                @can($infosPage['can'].$slug.' trash')
                    | <a href="#" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#corbeille" title="Vider la corbeille">
                        <i class="icofont-trash"></i>
                        Vider la corbeille
                    </a>
                    <div class="modal fade" id="corbeille" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title" id="exampleModalLabel">Vider la corbeille</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-warning">
                                        <i class="icofont icofont-exclamation-tringle"></i>
                                        Voulez-vous vraiment videz la corbeille ?
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ url('celestadmin/'.$infosPage['slug'].'/corbeille'.$id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-danger waves-effect" data-toggle="tooltip" data-placement="top" title="Supprimer definitivement" data-original-title="Supprimer definitivement">
                                            <i class="icofont icofont-trash"></i> OUI
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                {{-- {{ $infosPage['can'].$slug.' restore' }} --}}
                @can($infosPage['can'].$slug.' restore')
                    | <a href="#" class="btn btn-success waves-effect" data-toggle="modal" data-target="#restaurer" title="Restaurer la corbeille">
                        <i class="icofont-refresh"></i>
                        Restaurer la corbeille
                    </a>
                    <div class="modal fade" id="restaurer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Restaurer la corbeille
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-info">
                                        <i class="icofont icofont-exclamation-tringle"></i>
                                        Voulez-vous vraiment restaurer la corbeille ?
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ url('celestadmin/'.$infosPage['slug'].'/restaurer'.$id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Restaurer la corbeille" data-original-title="Restaurer la corbeille">
                                            <i class="icofont-refresh"></i> OUI
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            @endif
        @else
            <a href="{{ url()->current() }}">
                Tous
                <span class="badge badge-success">
                    {{ $countUser['totalUsers'] }}
                </span>
            </a>
            @if(auth()->user()->hasRole('superadmin'))
                <a href="{{ url()->current() }}?type=superadmin">
                    Superadmin
                    <span class="badge badge-success">
                        {{ $countUser['superadmin'] }}
                    </span>
                </a>
            @endif
            <a href="{{ url()->current() }}?type=admin">
                Administrateur
                <span class="badge badge-success">
                    {{ $countUser['admin'] }}
                </span>
            </a>
            <a href="{{ url()->current() }}?type=fournisseur">
                Fournisseur
                <span class="badge badge-success">
                    {{ $countUser['fournisseur'] }}
                </span>
            </a>
            <a href="{{ url()->current() }}?type=grossiste">
                Grossiste
                <span class="badge badge-success">
                    {{ $countUser['grossiste'] }}
                </span>
            </a>
            <a href="{{ url()->current() }}?type=detaillant">
                Détaillant
                <span class="badge badge-success">
                    {{ $countUser['detaillant'] }}
                </span>
            </a>
        @endif
    </div>

    {{--  Lancer une recherche sur un intervalle de date  --}}
    @can($infosPage['can'].$slug.' date')
        <div class="col-md-6">
            <div class="text-right mb-1">
                {{-- <div class="btn-group dropdown-split-primary">
                    <button type="button" class="btn btn-primary">Mois en cours</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle primary</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item waves-effect waves-light" href="{{ url()->current().'?date=lastMonth' }}">
                            Dernier mois
                        </a>
                        <a class="dropdown-item waves-effect waves-light" href="{{ url()->current().'?date=lastMonth' }}">
                            3 derniers mois
                        </a>
                        <a class="dropdown-item waves-effect waves-light" href="{{ url()->current().'?date=lastMonth' }}">
                            La semaine en cours
                        </a>
                        <a class="dropdown-item waves-effect waves-light" href="{{ url()->current().'?date=lastMonth' }}">
                            Aujourd'hui
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item waves-effect waves-light" href="#">Personnaliser</a>
                    </div>
                </div> --}}
                <form action="{{ url()->current() }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" type="text" name="reportrange" id="reportrange" value="{{ old('reportrange') }}">
                        {{-- <div id="reportrange" class="f-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar icofont icofont-ui-calendar"></i>
                            <span></span> <b class="caret"></b>
                        </div> --}}
                        <span class="input-group-btn" id="btn-addon3.2">
                            <button type="submit" class="btn btn-success addon-btn waves-effect waves-light">
                                Filtrer
                            </button>
                            {{--  04%2F15%2F2021+-+04%2F23%2F2021  --}}
                        </span>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-md-6">
            @if(request('reportrange'))
                <div class="text-center">
                    <div class="flat-success txt-success waves-effect waves-light">
                        Liste des commandes du {{ request('reportrange') }}
                        <a class="text-danger" href="{{ route('commandes') }}" title="Effacer le filtre">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endcan
</div>
