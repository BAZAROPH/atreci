@foreach($childrens as $children)
    @if ($page == 'add')
        {{-- @if ($children->option_id == 16) --}}
            <option value="{{ $children->id }}" {{ ( $children->id == old('parent_id')) ? 'selected' : '' }}>
                @for ($j = 0; $j < $nombreIteration; $j++)
                    --
                @endfor
                {{ $children->libelle }}
            </option>
            @if(count($children->childrens))
                @php ($nombreIteration++)
                @include('celestadmin.categorie.children',[
                    'childrens' => $children->childrens,
                    'nombreIteration' => $nombreIteration,
                    'page' => 'add',
                    'option' => $option,
                ])
                @php ($nombreIteration--)
            @endif
        {{-- @endif --}}
    @elseif ($page == 'edit')
        {{-- @if ($children->option_id == 16) --}}
            <option value="{{ $children->id }}" {{ ($children->id == $category->parent_id) ? 'selected' : '' }}>
                @for ($j = 0; $j < $nombreIteration; $j++)
                    --
                @endfor
                {{ $children->libelle }}
            </option>
            @if(count($children->childrens))
                @php ($nombreIteration++)
                @include('celestadmin.categorie.children',[
                    'childrens' => $children->childrens,
                    'nombreIteration' => $nombreIteration,
                    'page' => 'edit',
                    'option' => $option,
                    'category' => $category,
                ])
                @php ($nombreIteration--)
            @endif
        {{-- @endif --}}
    @elseif($page == 'index')
        @php ($i++)
        <tr>
            <td>{{ $i }}</td>
            <td>
                @for ($j = 0; $j < $nombreIteration; $j++)
                    &nbsp; &nbsp; &nbsp;
                @endfor
                @if(!empty($children->getMedia('image')->first()))
                    <img width="40" src="{{ url($children->getMedia('image')->first()->getUrl('thumb')) }}">
                @else
                    @if ($option->type_taxonomie_id != 5)
                        <img height="40" src="{{ asset('admin/image/no-image.png') }}">
                    @endif
                @endif
                <i class="{{ $children->icon }} text-warning-color"></i>
                <span data-toggle="tooltip" data-placement="top" title="{!! strip_tags($children->description) !!}" data-original-title="{!! strip_tags($children->description) !!}">
                    {{ $children->libelle }}
                </span>
            </td>
            <td>
                <a href="{{ url('celestadmin/'.$infosPage['slug'].'/edit/'.$children->id) }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier"><i class="icofont icofont-edit"></i>
                </a>
                <a href="#" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#exampleModal{{ $children->id }}" data-placement="top" title="Supprimer" data-original-title="Supprimer"><i class="icofont icofont-trash"></i>
                </a>
                <div class="modal fade" id="exampleModal{{ $children->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="modal-title" id="exampleModalLabel">Supprimer : {{ $children->libelle }}</h5>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-warning">
                                    <i class="icofont icofont-exclamation-tringle"></i> Voulez-vous vraiment supprimer ??
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ url('celestadmin/'.$infosPage['slug'].'/delete/'.$children->id) }}" method="post">
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
                {{-- @include('celestadmin.layouts.action') --}}
            </td>
            <td>
                <div style="color:#fff; font-size:1px;">
                    {{ $children->created_at->format('Y/m/d H:i') }}
                </div>
                {{ $children->created_at->diffForHumans() }}
            </td>
        </tr>
        @if(count($children->childrens))
            @php ($nombreIteration++)
            @include('celestadmin.categorie.children',[
                'childrens' => $children->childrens,
                'nombreIteration' => $nombreIteration,
                'page' => 'index',
                'i' => $i,
                'option' => $option,
            ])
            @php ($nombreIteration--)
        @endif
        @php ($i += count($children->childrens))
    @elseif($page == 'post')
        <tr>
            <td>{{ $i }}</td>
            <td>
                @for ($j = 0; $j < $nombreIteration; $j++)
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                @endfor
                @php($checked = '')
                @if (request('id'))
                    @foreach ($valeur->categories as $item)
                        @if ($item->id == $children->id)
                            @php($checked = 'checked')
                            @break
                        @endif
                    @endforeach
                @else
                    @if ($children->id == old($champ->libelle.$i))
                        @php($checked = 'checked')
                    @endif
                @endif
                <i class="{{ $children->icon }} text-warning-color"></i>
                <div class="rkmd-checkbox checkbox-rotate checkbox-ripple">
                    <label class="input-checkbox checkbox-warning">
                        <input value="{{ $children->id }}" name="{{ $champ->libelle }}[]" type="checkbox" id="{{ $champ->libelle.$i }}" {{ $checked }}>
                        <span class="checkbox"></span>
                    </label>
                    <label for="{{ $champ->libelle.$i }}" class="captions">
                        {{ $children->libelle }}
                    </label>
                </div>
            </td>
        </tr>
        @if(count($children->childrens) and ($option->id != 20))
            @php ($i++)
            @php ($nombreIteration++)
            @include('celestadmin.categorie.children',[
                'childrens' => $children->childrens,
                'nombreIteration' => $nombreIteration,
                'page' => 'post',
                'option' => $option,
            ])
            @php ($nombreIteration--)
        @endif
        @php ($i += count($children->childrens))

    @elseif($page == 'arborescence')
        @php($i++)
        {'name': '{{ $children->matricule }}',
        'title': '{{ $children->prenom." ".$children->name." -- ".$children->telephone }}',
        @if(count($children->childrens))
            'children': [
                @php ($nombreIteration++)
                @include('celestadmin.categorie.children',[
                    'childrens' => $children->childrens,
                    'nombreIteration' => $nombreIteration,
                    'page' => 'arborescence',
                ])
                @php ($nombreIteration--)
            ]
        @endif
        },

    @elseif($page == 'menu')
        @php($i++)
        @empty($children->requete)
            <li>
                <a href="{{ urlMode(url($children->lien), $parametre->type_id) }}">
                    <i class="icon-arrow-right"></i>
                    {{ $children->libelle }}
                </a>
            </li>
        @else
            @php($occurences = DB::select($children->requete))
            @foreach ($occurences as $occurence)
                @if ($children->lien == 'c/')
                    @php($myLink = $occurence->slug)
                @else
                    @php($myLink = $occurence->categorie_slug.'/'.$occurence->slug)
                @endif
                {{--  @php($myLink = $children->lien.$occurence->slug)  --}}
                <li>
                    <a href="{{ urlMode(url($myLink), $parametre->type_id) }}">
                        <i class="icon-arrow-right"></i>
                        {{ $occurence->libelle }}
                    </a>
                    @if(count($children->childrens))
                        @php ($nombreIteration++)
                        @include('celestadmin.categorie.children',[
                            'childrens' => $children->childrens,
                            'nombreIteration' => $nombreIteration,
                            'page' => 'menu',
                            'i' => $i,
                        ])
                        @php ($nombreIteration--)
                    @endif
                </li>
            @endforeach
        @endempty
    @endif
@endforeach
