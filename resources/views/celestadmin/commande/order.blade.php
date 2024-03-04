<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-{{ (!request('download')) ? 'block' : 'body' }}">
                <h5 class="text-center">
                    Commande N°{{ $valeur->reference }}
                </h5>
                @if (!request('download'))
                    <h2 class="text-center text-danger">[{{ devise($valeur->total_commande) }}]</h2>
                    <div style="float: right;">
                        @can('commandes print')
                            <a href="{{ route('commande.print', [$valeur, 'download']) }}" class="btn btn-danger">
                                <i class="fa fa-print" aria-hidden="true"></i> Imprimer
                            </a>
                        @endcan
                    </div>
                @endif
                <table class="table">
                    <tbody>
                        @if ($valeur->user)
                            <tr>
                                <td>Nom & prénoms : </td>
                                <td>{{ $valeur->user->name }} {{ $valeur->user->prenoms }}</td>
                            </tr>
                            <tr>
                                <td>Email : </td>
                                <td>{{ $valeur->user->email }}</td>
                            </tr>
                        @endif

                        @if ($valeur->adresse)
                            <tr>
                                <td>Pays : </td>
                                <td>{{ $valeur->adresse->parent->libelle }}</td>
                            </tr>
                            <tr>
                                <td>Ville : </td>
                                <td>{{ $valeur->adresse->sous_titre }}</td>
                            </tr>
                            <tr>
                                <td>Adresse de livraison : </td>
                                <td>{{ $valeur->adresse->libelle }}</td>
                            </tr>
                            <tr>
                                <td>N° téléphone : </td>
                                <td>{{ $valeur->adresse->lien }}</td>
                            </tr>
                        @endif

                        @if ($valeur->date_livraison)
                            <tr>
                                <td>Date et heure de livraison : </td>
                                <td>
                                    {{ \Carbon\Carbon::createFromDate($valeur->date_livraison)->format('d/m/Y') }}
                                    @if ($valeur->heure)
                                        entre {{ $valeur->heure->libelle }}
                                    @endif

                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td>Date de commande : </td>
                            <td>
                                <span data-toggle="tooltip" data-placement="top" data-original-title="{{ $valeur->created_at->diffForHumans() }}">
                                    {{ $valeur->created_at->format('Y/m/d H:i:s') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Etat commande : </td>
                            <td>
                                <span class="{{ $valeur->etat->icon }}">
                                    {{ $valeur->etat->libelle }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Source de la commande : </td>
                            <td>{{ $valeur->source->libelle }}</td>
                        </tr>
                        <tr>
                            <td>Mode de paiement : </td>
                            <td>
                                @foreach ($valeur->mode_paiements as $item)
                                    <span class="badge-danger badge" style="">{{ $item->libelle }}</span>
                                @endforeach
                            </td>
                        </tr>
                        @if (!request('download'))
                            <tr>
                                <td colspan="2" class="text-center">
                                    Coût: <i class="badge btn-success">
                                        {{ devise($valeur->total_commande) }}
                                    </i> |
                                    Déjà versé:
                                    <i class="badge btn-warning">
                                        {{ devise($dejaVerser) }}
                                    </i> |
                                    Reste:
                                    <i class="badge btn-danger">
                                        {{ devise($resteAPayer) }}
                                    </i>
                                </td>
                            </tr>
                            @if ($resteAPayer > 0)
                                <tr>
                                    <td>Paiement de la commande : </td>
                                    <td>
                                        <form action="{{ url()->current() }}" method="post">
                                            @csrf
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <div class="input-group">
                                                    <div class="form-group">
                                                        <select required class="form-control" name="etat_id">
                                                            <option value="">-------Etat de la commande-------</option>
                                                            @foreach ($categories as $item)
                                                                <option value="{{ $item->id }}" {{ ($item->id == $valeur->etat->id) ? 'selected' : '' }} >
                                                                    {{ $item->libelle }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <span class="input-group-btn" id="btn-addon3.2">
                                                        <button type="submit" class="btn btn-success addon-btn waves-effect waves-light">
                                                            Valider
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
                <h3 class="text-center">
                    Produits ({{ count($valeur->produits) }})
                </h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Articles</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Sous-Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($valeur->produits as $key => $item)
                            @php($capacite = traitementCategory($item, 'capacite'))
                            @php($subdivision = traitementCategory($item, 'subdivision'))
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td scope="row">
                                    <a href="{{ url($item->slug) }}" target="_blank">
                                        @if(!empty($item->getMedia('image')->first()))
                                            <img class="mr-1" height="20" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}">
                                        @else
                                            <img class="mr-1" height="20" src="{{ asset('admin/image/no-image.png') }}">
                                        @endif
                                        {{ $item->libelle }}
                                    </a>
                                </td>
                                <td>
                                    {{ $item->pivot->quantite }}
                                    {{ $capacite->sous_titre }}
                                </td>
                                <td>
                                    {{ devise($item->pivot->cout) }}
                                </td>
                                <td>
                                    {{ devise($item->pivot->cout * $item->pivot->quantite) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="text-right">
                            <td colspan="5">
                                <div>Sous Total : {{ devise($valeur->cout_commande) }}</div>
                            </td>
                        </tr>
                        <tr class="text-right">
                            <td colspan="5">
                                <div>Livraison : {{ devise($valeur->cout_livraison) }}</div>
                            </td>
                        </tr>
                        <tr class="text-right">
                            <td colspan="5">
                                <h4 class="text-danger">Total : {{ devise($valeur->total_commande) }}</h4>
                            </td>
                        </tr>
                        @if (!request('download'))
                            <tr class="text-right">
                                <td colspan="5">
                                    <div class="text-warning">Déjà verser : {{ devise($dejaVerser) }}</div>
                                </td>
                            </tr>
                            <tr class="text-right">
                                <td colspan="5">
                                    <div class="text-warning">Rester à payer : {{ devise($resteAPayer) }}</div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="m-b-3" {{ (request('download')) ? 'style=margin-top:-50px; ' : '' }}>
                    <a href="https://www.atre.ci">www.atre.ci</a><br>
                    (+225) 20 00 05 71 / 09 09 65 51 / 75 03 42 03 / 02 71 71 86 <br>
                    <a href="mailto:info@atre.ci">info@atre.ci</a>
                </div>
                <div>
                    NB : Cher client(e), nous vous prions de bien vérifier la qualité et la Quantité des produits de votre commande à la livraison. Car, après le départ du livreur du lieu de livraison, aucune réclamation ne sera recevable.
                    <br>Merci de toujours nous faire confiance. A très bientôt !
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <br>
                        <h3>Signature</h3>
                    </div>
                    <div class="col-md-6">
                        @if(!empty($parametre->getMedia('logo')->first()))
                            <div style="float: right;">
                                <img height="100" src="{{ asset('web/img/logo-entreprise.png') }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
