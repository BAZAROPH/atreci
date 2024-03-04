@php($menu = menu(30))
@php ($i = 0)
@foreach ($menu as $menu)
    @php ($i++)
    @if (empty($menu->parent))
        @php($active = null)
        @if (count($menu->childrens) > 0)
            @foreach ($menu->childrens as $submenu)
                @empty($submenu->requete)
                    @if ($submenu->lien == $mySlug)
                        @php($active = 'active')
                        @break
                    @endif
                @else
                    @php($occurences = DB::select($submenu->requete))
                    @foreach ($occurences as $occurence)
                        {{--  @if ($menu->slug == 'post')
                            @php($myLink = 'celestadmin/p/'.$occurence->slug)
                        @else
                            @php($myLink = 'celestadmin/'.$occurence->slug)
                        @endif  --}}
                        @if ($occurence->slug == $mySlug)
                            @php($active = 'active')
                            @break
                        @endif
                    @endforeach
                @endempty
            @endforeach
        @else
            @if (($menu->lien) == $mySlug)
                @php($active = 'active')
            @endif
        @endif
        <li class="{!! (count($menu->childrens) > 0) ? 'drop-down' : '' !!} {{ $active }}">
            <a href="{{ urlMode(url($menu->lien), $parametre->type_id) }}">
                {{ $menu->libelle }}
            </a>
            @if (count($menu->childrens))
                <ul>
                    @include('celestadmin.categorie.children', [
                        'childrens' => $menu->childrens,
                        'nombreIteration' => 1,
                        'page' => 'menu',
                        'i' => ++$i,
                    ])
                </ul>
            @endif
        </li>
    @endif
@endforeach
