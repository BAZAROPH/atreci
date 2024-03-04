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
                                <table id="simpletable" class="table dt-responsive nowrap" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Commande</th>
                                            <th>Source</th>
                                            <th>Paiement</th>
                                            <th>Etat</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                            <th>Client</th>
                                            <th>Actions</th>
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
                                            <th>Client</th>
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php ($i = 0)
                                        @php ($totalCommandeLivree=0)
                                        @php ($totalCommandeAttentes=0)
                                        @php ($totalCommandeAnnulees=0)
                                        @foreach ($valeurs as $valeur)
                                            @php ($i++)
                                            @switch($valeur->etat_id)
                                                @case(110)
                                                    @php($totalCommandeLivree += $valeur->total_commande)
                                                    @break

                                                    @case(111)
                                                    @php($totalCommandeAttentes += $valeur->total_commande)
                                                    @break

                                                @case(112)
                                                    @php($totalCommandeAnnulees += $valeur->total_commande)
                                                    @break
                                            @endswitch
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>
                                                    {{-- @if(!empty($valeur->getMedia('logo')->first()))
                                                        <img width="150" src="{{ url($valeur->getMedia('logo')->first()->getUrl('thumb')) }}">
                                                    @endif --}}
                                                    @can('users show') <a href="{{ url()->current().'/'.$valeur->id }}"> @endcan
                                                        {{ $valeur->reference }}
                                                    @can('users show') </a> @endcan
                                                </td>
                                                <td>
                                                    {{ $valeur->source->libelle }}
                                                </td>
                                                <td>
                                                    @foreach ($valeur->mode_paiements as $item)
                                                        <span class="badge-danger badge" style="font-size: 10px;">{{ $item->libelle }}</span><br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <span class="{{ $valeur->etat->icon }}">
                                                        {{ $valeur->etat->libelle }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $valeur->quantite_produit }}
                                                </td>
                                                <td>
                                                    {{ number_format($valeur->total_commande, 0, '.', ' ').' Fcfa'  }}
                                                </td>
                                                <td>
                                                    @if ($valeur->user)
                                                        <a href="{{ url('celestadmin/users/'.$valeur->user->id) }}">
                                                            {{ $valeur->user->name.' '.$valeur->user->prenom }}
                                                        </a>
                                                    @else
                                                        {{ $valeur->created_ip }}
                                                    @endif

                                                </td>
                                                <td>
                                                    @include('celestadmin.layouts.action')
                                                </td>
                                                <td data-toggle="tooltip" data-placement="top" data-original-title="{{ $valeur->created_at->format('Y/m/d H:i:s') }}">
                                                    <div style="color:#fff; font-size:1px;">
                                                        {{ $valeur->created_at->format('Y/m/d H:i:s') }}
                                                    </div>
                                                    {{ $valeur->created_at->diffForHumans() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @include('celestadmin.user.total-commande')
                                @include('celestadmin.user.chart-commande')
                                {{-- {{ $valeurs->links() }} --}}
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

@endpush
