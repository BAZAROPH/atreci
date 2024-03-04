<div id="flash-overlay-modal" class="modal fade {{ isset($modalClass) ? $modalClass : '' }}">
    <div class="modal-dialog modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <p class="alert
                alert-{{ $message['level'] }}
                {{ $message['important'] ? 'alert-important' : '' }}"
                role="alert">{!! $body !!}</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
