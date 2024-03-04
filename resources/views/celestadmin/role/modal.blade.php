<a href="{{ url('celestadmin/'.$infosPage['slug'].'/edit/'.$valeur->id) }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier">
    <i class="icofont icofont-edit"></i>
</a>
<a href="#" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#permissionModal{{ $i }}" data-toggle="tooltip" data-placement="top" title="Voir ses permissions" data-original-title="Voir ses permissions"><i class="icofont icofont-ui-lock"></i>
</a>
<a href="#" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#exampleModal{{ $i }}" data-placement="top" title="Supprimer" data-original-title="Supprimer">
    <i class="icofont icofont-trash"></i>
</a>
<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Supprimer : "{{ $valeur->libelle }}"</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="icofont icofont-exclamation-tringle"></i>
                    Voulez-vous vraiment supprimer ??
                </div>
            </div>
            <div class="modal-footer">
                <form action="{{ url('celestadmin/'.$infosPage['slug'].'/delete/'.$valeur->id) }}" method="post">
                    @csrf
                    <button class="btn btn-danger waves-effect" data-toggle="tooltip" data-placement="top" title="Supprimer" data-original-title="Supprimer">
                        <i class="icofont icofont-trash"></i> OUI
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="permissionModal{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title" id="exampleModalLabel">Permissions de "{{ $valeur->name }}"</h5>
        </div>
        <div class="modal-body">
            @forelse ($valeur->permissions as $item)
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
