<h5 class="m-t-1">{{ $champ->titre }}</h5>
<table class="table dt-responsive nowrap" id="simpletable" style="font-size: 13px;">
    <thead>
        <tr>
            <th>#</th>
            <th>Libellé</th>
        </tr>
    </thead>
    <tbody>
        @php ($i = 0)
        @forelse ($occurences as $occurence)
            @if (empty($occurence->parent))
                @php ($i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        <i class="{{ $occurence->icon }} text-warning-color"></i>
                        <div class="rkmd-checkbox checkbox-rotate checkbox-ripple" style="font-size: 13px;">
                            <label class="input-checkbox checkbox-warning">
                                @if (request('id'))
                                    @php($checked = '')
                                    {{-- {{ dd($valeur->categories->toArray()) }} --}}
                                    @foreach ($valeur->categories as $item)
                                        @if ($item->id == $occurence->id)
                                            @php($checked = 'checked')
                                            @break
                                        @endif
                                    @endforeach
                                    {{-- @for ($j = 0; $j < count($valeur->categories); $j++)
                                        @if ($valeur->categories[$j]->id == $occurence->id)
                                            @php($checked = 'checked')
                                            @break
                                        @endif
                                    @endfor --}}
                                    <input value="{{ $occurence->id }}" name="{{ $champ->libelle }}[]" type="checkbox" id="{{ $champ->libelle.$i }}" {{ $checked }}>
                                @else
                                    <input value="{{ $occurence->id }}" name="{{ $champ->libelle }}[]" type="checkbox" id="{{ $champ->libelle.$i }}" {{ ($occurence->id == old($champ->libelle.$i)) ? 'checked' : '' }}>
                                @endif
                                <span class="checkbox"></span>
                            </label>
                            <label for="{{ $champ->libelle.$i }}" class="captions">
                                {{ $occurence->libelle }}
                            </label>
                        </div>
                    </td>
                </tr>
                @if(count($occurence->childrens))
                    @include('celestadmin.categorie.children', [
                        'childrens' => $occurence->childrens,
                        'nombreIteration' => 1,
                        'page' => 'post',
                        'i' => ++$i,
                        'option' => $occurence,
                        ])
                @endif
                @php ($i += count($occurence->childrens))
            @endif
        @endforeach
    </tbody>
</table>
