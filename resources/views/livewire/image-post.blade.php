<div wire:poll.7s>
    @php($i = 0)
    @forelse ($post->getMedia('image') as $item)
        <div class="box-image" {{-- wire:poll.5s --}}>
            <img src="{{ url($item->getUrl('thumb')) }}">
            <div style="position: absolute; top: 0;">
                <span class="btn btn-danger text-white" wire:click="deleteMedia({{ $i }})">
                    <i class="icofont-trash"></i>
                </span>
            </div>
        </div>
        @php($i++)
    @empty
        <div class="text-danger">
            Pas dimage
        </div>
    @endforelse
</div>
