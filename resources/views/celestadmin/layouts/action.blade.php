@php
    $slug = $infosPage['slug'];
@endphp
@isset($infosPage['url'])
    @php
        $slug = $infosPage['url'];
    @endphp
@endisset

{{-- Show --}}
@can($infosPage['can'].$slug.' show')
    @if (request('status') != 'trashed')
        <a href="{{ url('celestadmin/'.$infosPage['slug'].'/'.$valeur->id) }}" class="btn btn-primary waves-effect" data-toggle="tooltip" data-placement="top" title="Voir" data-original-title="Voir">
            <i class="icofont-eye"></i>
        </a>
    @endif
@endcan

{{--  Edit  --}}
@can($infosPage['can'].$slug.' edit')
    @if (request('status') != 'trashed')
        <a href="{{ url('celestadmin/'.$infosPage['slug'].'/edit/'.$valeur->id) }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier">
            <i class="icofont icofont-edit"></i>
        </a>
    @endif
@endcan

{{--  Delete or trash  --}}
@can($infosPage['can'].$slug.' delete')
    @if (request('status') == 'trashed')
        @php
            $text = 'Supprimer definitivement';
            $url = url('celestadmin/'.$infosPage['slug'].'/delete/'.$valeur->id.'?status=trashed');
        @endphp
    @else
        @php
            $text = 'Mettre à la corbeille';
            $url = url('celestadmin/'.$infosPage['slug'].'/delete/'.$valeur->id);
        @endphp
    @endif
    <a href="#" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#exampleModal{{ $i }}" data-placement="top" title="{!! $text !!}" data-original-title="">
        <i class="icofont icofont-trash"></i>
    </a>
    <div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel">
                        {!! $text !!} : "{{ $valeur->libelle }}"
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="icofont icofont-exclamation-tringle"></i>
                        Voulez-vous vraiment {!! $text !!} ?
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ $url }}" method="post">
                        @csrf
                        <button class="btn btn-danger waves-effect" data-toggle="tooltip" data-placement="top" title="{!! $text !!}" data-original-title="{!! $text !!}">
                            <i class="icofont icofont-trash"></i> OUI
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endcan

{{--  Restore  --}}
@can($infosPage['can'].$slug.' restore')
    @if (request('status') == 'trashed')
        <a href="#" class="btn btn-success waves-effect" data-toggle="modal" data-target="#restaurer{{ $i }}" title="Restaurer">
            <i class="icofont-refresh"></i>
        </a>
    @endif
    <div class="modal fade" id="restaurer{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel">
                        Restaurer : "{{ $valeur->libelle }}"
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="icofont icofont-exclamation-tringle"></i>
                        Voulez-vous vraiment restaurer ?
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ url('celestadmin/'.$infosPage['slug'].'/restaurer/'.$valeur->id.'?status=trashed') }}" method="post">
                        @csrf
                        <button class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top">
                            <i class="icofont-refresh"></i> OUI
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endcan
{{--  Valider une inscription  --}}
@can($infosPage['can'].$slug.' validation')
    @if ($valeur->valide == 0)
        <a href="#" class="btn btn-warning waves-effect" data-toggle="modal" data-target="#validation{{ $k }}" title="Valider inscription"><i class="icofont-ui-check"></i>
        </a>
        <div class="modal fade" id="validation{{ $k }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="exampleModalLabel">
                            Validation de l'inscription
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="icofont icofont-exclamation-tringle"></i>
                            Voulez-vous vraiment valider l'inscription de ce membre <strong>({{ $valeur->name }} {{ $valeur->prenom }})</strong> ??
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ url('celestadmin/'.$infosPage['slug'].'/valide/'.$valeur->id) }}" method="post">
                            @csrf
                            <button class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Valider" data-original-title="Valider">
                                <i class="icofont-ui-check"></i> OUI
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @else
        <span class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Inscription valide" data-original-title="Inscription valide">
            <i class="icofont-checked"></i>
        </span>
    @endif
@endcan

{{--  Edit  --}}
{{-- @can($infosPage['can'].$slug.' iron') --}}
    <a href="{{ route('commande-repasser', $valeur) }}" target="_blank" class="btn btn-warning waves-effect" data-toggle="tooltip" data-placement="top" title="Repasser la commande" data-original-title="Repasser la commande">
        <i class="icofont-retweet"></i>
    </a>
{{-- @endcan --}}
