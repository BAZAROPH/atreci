<div class="col-md-12">
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
    @if (request('status') == 'trashed' and count($trashed) > 0)
        @can($infosPage['can'].$infosPage['slug'].' trash')
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
                            <form action="{{ url('celestadmin/'.$infosPage['slug'].'/corbeille/'.$taxonomie->id) }}" method="post">
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

        @can($infosPage['can'].$infosPage['slug'].' restore')
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
                            <form action="{{ url('celestadmin/'.$infosPage['slug'].'/restaurer/'.$id) }}" method="post">
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
</div>
