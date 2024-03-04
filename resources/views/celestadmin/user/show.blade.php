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
                                                Détails utilisateur {{ $valeur->name.' '.$valeur->prenom }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-block">
                                        <div class="row m-b-30">
                                            <div class="col-lg-12">
                                                <ul class="nav nav-tabs md-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link @if(!request('reportrange')) active @endif" data-toggle="tab" href="#home3" role="tab">
                                                            Infos Utilisateurs
                                                        </a>
                                                        <div class="slide"></div>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if(request('reportrange')) active @endif" data-toggle="tab" href="#profile3" role="tab">
                                                            Commandes ({{ count ($valeur->commandes) }})
                                                        </a>
                                                        <div class="slide"></div>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#messages3" role="tab">
                                                            Adresses de livraison
                                                            ({{ count ($valeur->adresses) }})
                                                        </a>
                                                        <div class="slide"></div>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#settings3" role="tab">
                                                            Historique
                                                            ({{ count ($activities) }})
                                                        </a>
                                                        <div class="slide"></div>
                                                    </li>
                                                </ul>
                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane @if(!request('reportrange')) active @endif" id="home3" role="tabpanel">
                                                        <div class="card-header">
                                                            <h1 class="text-center text-uppercase">
                                                                Détails Utilisateur
                                                            </h1>
                                                        </div>

                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-right">Matricule : </td>
                                                                    <td>{{ $valeur->matricule }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right">Nom & prénoms : </td>
                                                                    <td>
                                                                        @if(!empty($valeur->getMedia('image')->first()))
                                                                            <img style="margin-right: 10px; float: left;" width="60" src="{{ url($valeur->getMedia('image')->first()->getUrl('thumb')) }}">
                                                                        @else
                                                                            <img style="margin-right: 10px; float: left;" width="60" src="{{ asset('admin/image/user.png') }}">
                                                                        @endif
                                                                        {{ $valeur->name }} {{ $valeur->prenoms }}
                                                                        <div class="text-danger">[{{ $valeur->slug }}]</div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right">Email : </td>
                                                                    <td>{{ $valeur->email }}</td>
                                                                </tr>
                                                                @if ($valeur->login)
                                                                    <tr>
                                                                        <td class="text-right">Login : </td>
                                                                        <td>{{ $valeur->login }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->telephone)
                                                                    <tr>
                                                                        <td class="text-right">Numéro de téléphone : </td>
                                                                        <td>{{ $valeur->telephone }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->biographie)
                                                                    <tr>
                                                                        <td class="text-right">Biographie : </td>
                                                                        <td>{{ $valeur->biographie }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->adresse)
                                                                    <tr>
                                                                        <td class="text-right">Adresse : </td>
                                                                        <td>{{ $valeur->adresse }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->sexe)
                                                                    <tr>
                                                                        <td class="text-right">Sexe : </td>
                                                                        <td>{{ $valeur->sexe }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->date_naissance)
                                                                    <tr>
                                                                        <td class="text-right">Date de naissance : </td>
                                                                        <td>{{ \Carbon\Carbon::parse($valeur->date_naissance)->format('d-m-Y') }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->poste)
                                                                    <tr>
                                                                        <td class="text-right">Poste : </td>
                                                                        <td>{{ $valeur->poste }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->type_piece)
                                                                    <tr>
                                                                        <td class="text-right">Type de pièce : </td>
                                                                        <td>{{ $valeur->type_piece }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->numero_piece)
                                                                    <tr>
                                                                        <td class="text-right">Numéro de pièce : </td>
                                                                        <td>{{ $valeur->numero_piece }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->created_user)
                                                                    <tr>
                                                                        <td class="text-right">Date d'inscription : </td>
                                                                        <td>{{ $valeur->created_user->format('d-m-Y') }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->parent_id)
                                                                    <tr>
                                                                        <td class="text-right">Commercial : </td>
                                                                        <td>{{ $valeur->parent->name.' '.$valeur->parent->prenom }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->source_id)
                                                                    <tr>
                                                                        <td class="text-right">Inscrit à partir : </td>
                                                                        <td>{{ $valeur->source->libelle }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->created_at)
                                                                    <tr>
                                                                        <td class="text-right">Date de l'inscription </td>
                                                                        <td data-toggle="tooltip" data-placement="top" title="{{ \Carbon\Carbon::parse($valeur->created_at)->format('d/m/Y')}}" data-original-titletitle="{{ \Carbon\Carbon::parse($valeur->created_at)->format('d/m/Y')}}">{{ $valeur->created_at->diffForHumans() }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->updated_at)
                                                                    <tr>
                                                                        <td class="text-right">Date de la dernière modification : </td>
                                                                            <span><td data-toggle="tooltip" data-placement="top" title="{{ \Carbon\Carbon::parse($valeur->updated_at)->format('d/m/Y')}}" data-original-titletitle="{{ \Carbon\Carbon::parse($valeur->updated_at)->format('d/m/Y')}}" >
                                                                                {{ $valeur->updated_at->diffForHumans() }}
                                                                            </td></span>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->provider)
                                                                    <tr>
                                                                        <td class="text-right">Provider : </td>
                                                                        <td>{{ $valeur->provider }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->provider_id)
                                                                    <tr>
                                                                        <td class="text-right">Nom du provider : </td>
                                                                        <td>{{ $valeur->provider }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->deleted_at)
                                                                    <tr>
                                                                        <td class="text-right">Date de supression : </td>
                                                                        <td>{{ $valeur->deleted_at->diffForHumans() }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->stripe_id)
                                                                    <tr>
                                                                        <td class="text-right">Paiement stripe : </td>
                                                                        <td>{{ $valeur->stripe_id }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->card_brand)
                                                                    <tr>
                                                                        <td class="text-right">Carte : </td>
                                                                        <td>{{ $valeur->card_brand }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->card_last_four)
                                                                    <tr>
                                                                        <td class="text-right">Card last four : </td>
                                                                        <td>{{ $valeur->card_last_four }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->trial_ends_at)
                                                                    <tr>
                                                                        <td class="text-right">Trial Ends at : </td>
                                                                        <td>{{ $valeur->trial_ends_at }}</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($valeur->original_id)
                                                                    <tr>
                                                                        <td class="text-right">Original id : </td>
                                                                        <td>Il a été importé</td>
                                                                    </tr>
                                                                @endif

                                                            </tbody>
                                                        </table>

                                                    </div>

                                                    @if(request('reportrange'))
                                                        <div class="text-center m-t-20">
                                                            <div class="btn btn-flat flat-success txt-success waves-effect waves-light">
                                                                Liste des commandes du {{ request('reportrange') }}
                                                                <a class="text-danger" href="{{ route('user.show', $valeur) }}">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="tab-pane @if(request('reportrange')) active @endif" id="profile3" role="tabpanel">
                                                        <div class="row m-t-30 m-b-20">
                                                            <div class="col-md-6"></div>
                                                            <div class="col-md-6">
                                                                <form action="{{ url()->current() }}" method="get">
                                                                    @csrf
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="text" name="reportrange" id="reportrange" value="{{ old('reportrange') }}">
                                                                        <span class="input-group-btn" id="btn-addon3.2">
                                                                            <button type="submit" class="btn btn-success addon-btn waves-effect waves-light">
                                                                                Filtrer
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <table id="simpletable" class="table dt-responsive nowrap" style="font-size: 13px; width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Commande</th>
                                                                    <th>Source</th>
                                                                    <th>Paiement</th>
                                                                    <th>Etat</th>
                                                                    <th>Quantité</th>
                                                                    <th>Total</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Commande</th>
                                                                    <th>Source</th>
                                                                    <th>Paiement</th>
                                                                    <th>Etat</th>
                                                                    <th>Quantité</th>
                                                                    <th>Total</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>
                                                                @php ($i = 0)
                                                                @php ($totalCommandeLivree=0)
                                                                @php ($totalCommandeAttentes=0)
                                                                @php ($totalCommandeAnnulees=0)
                                                                @foreach ($valeur->commandes as $commande)
                                                                    @php ($i++)
                                                                    @switch($commande->etat_id)
                                                                        @case(110)
                                                                            @php($totalCommandeLivree += $commande->total_commande)
                                                                            @break

                                                                            @case(111)
                                                                            @php($totalCommandeAttentes += $commande->total_commande)
                                                                            @break

                                                                        @case(112)
                                                                            @php($totalCommandeAnnulees += $commande->total_commande)
                                                                            @break
                                                                    @endswitch
                                                                    <tr>
                                                                        <td>{{ $i }}</td>
                                                                        <td>
                                                                            {{-- @if(!empty($valeur->getMedia('logo')->first()))
                                                                                <img width="150" src="{{ url($valeur->getMedia('logo')->first()->getUrl('thumb')) }}">
                                                                            @endif --}}
                                                                            @can('commandes show') <a href="{{ url('celestadmin/commandes/'.$commande->id) }}"> @endcan
                                                                                {{ $commande->reference }}
                                                                            @can('commandes show') </a> @endcan
                                                                        </td>
                                                                        <td>
                                                                            {{ $commande->source->libelle }}
                                                                        </td>
                                                                        <td>
                                                                            @foreach ($commande->mode_paiements as $item)
                                                                                <span class="badge-danger badge" style="font-size: 10px;">{{ $item->libelle }}</span><br>
                                                                            @endforeach
                                                                        </td>
                                                                        <td>
                                                                            <span class="{{ $commande->etat->icon }}">
                                                                                {{ $commande->etat->libelle }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            {{ $commande->quantite_produit }}
                                                                        </td>
                                                                        <td>
                                                                            {{ devise($commande->total_commande)  }}
                                                                        </td>
                                                                        <td>
                                                                            <div style="color:#fff; font-size:1px;">
                                                                                {{ $commande->created_at->format('Y/m/d H:i:s') }}
                                                                            </div>
                                                                            <span data-toggle="tooltip" data-placement="top" data-original-title="{{ $commande->created_at->format('Y/m/d H:i:s') }}">
                                                                                {{ $commande->created_at->diffForHumans() }}
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @include('celestadmin.user.total-commande')
                                                        @include('celestadmin.user.chart-commande')
                                                    </div>

                                                    <div class="tab-pane" id="messages3" role="tabpanel">
                                                        <br>
                                                        <table id="simpletable" class="table dt-responsive nowrap" style="font-size: 13px; width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Adresse</th>
                                                                    <th>Nbr. Commande</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Adresse</th>
                                                                    <th>Nbr. Commande</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>
                                                                @php ($i = 0)
                                                                @foreach ($valeur->adresses as $commande)
                                                                    @php ($i++)
                                                                    <tr>
                                                                        <td class="py-3">
                                                                            <span type="button" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="{{ $commande->created_at->format('d-m-Y H:i') }}">
                                                                                {{ $commande->created_at->diffForHumans() }}
                                                                            </span>
                                                                        </td>
                                                                        <td class="py-3">
                                                                            <a class="nav-link-style font-weight-medium font-size-sm" href="{{ $commande->id }}" data-toggle="modal">
                                                                                {{ $commande->libelle }}
                                                                            </a>
                                                                            <div>
                                                                                {{ $commande->sous_titre }}, {{ $commande->parent->libelle }} -- [{{ $commande->lien }}]
                                                                            </div>
                                                                        </td>
                                                                        <td class="py-3">
                                                                            <span class="badge badge-success m-0">{{ count($commande->commandes) }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="settings3" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <table id="activity_log" class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Description</th>
                                                                                    <th>Model</th>
                                                                                    <th>Model ID</th>
                                                                                    <th>Date</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th>Description</th>
                                                                                    <th>Model</th>
                                                                                    <th>Model ID</th>
                                                                                    <th>Date</th>
                                                                                </tr>
                                                                            </tfoot>
                                                                            <tbody>
                                                                                @foreach ($activities as $item)
                                                                                    <tr style="font-size: 14px;">
                                                                                            <td>
                                                                                                {{ $item->description }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <div style="width: 100px;">
                                                                                                    {{ $item->subject_type }}
                                                                                                </div>
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ $item->subject_id }}
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection

@push('scripts')
    @include('celestadmin.user.statistiquesJS')
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
