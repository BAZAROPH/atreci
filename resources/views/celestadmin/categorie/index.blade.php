@extends('celestadmin.layouts.app', [
    'title' => $infosPage['title']
])

@section('content')
    <div class="wrapper">
        @include('celestadmin.layouts.menu')
        <div class="content-wrapper">
            <div class="container-fluid">
                @include('celestadmin.layouts.header', [
                    'id' => '/'.$taxonomie->id
                ])
                @if (request('status') == 'trashed')
                    @php($valeurs = $trashed)
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                <table id="simpletable" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Libellé</th>
                                            @if ($infosPage['slug'] == 'rubrique')
                                                <th>Champs</th>
                                                <th>Apparence</th>
                                            @endif
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Libellé</th>
                                            @if ($infosPage['slug'] == 'rubrique')
                                                <th>Champs</th>
                                                <th>Apparence</th>
                                            @endif
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php ($i = 0)
                                        @foreach ($valeurs as $valeur)
                                            @php ($i++)
                                            {{-- @if ($infosPage['slug'] == 'rubrique')
                                                @php(create_permission('-r '.$valeur->slug))
                                            @endif --}}
                                            @if (empty($valeur->parent))
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>
                                                        @if(!empty($valeur->getMedia('image')->first()))
                                                            <img height="40" src="{{ url($valeur->getMedia('image')->first()->getUrl('thumb')) }}">
                                                        @else
                                                            @if ($taxonomie->type_taxonomie_id != 5)
                                                                <img height="40" src="{{ asset('admin/image/no-image.png') }}">
                                                            @endif
                                                        @endif
                                                        <span data-toggle="tooltip" data-placement="top" title="{!! ($valeur->description) !!}" data-original-title="{!! ($valeur->description) !!}">
                                                            <i class="{{ $valeur->icon }} text-warning-color"></i>
                                                            {{ $valeur->libelle }}
                                                        </span>
                                                    </td>
                                                    @if ($infosPage['slug'] == 'rubrique')
                                                        <td>
                                                            @foreach ($valeur->champs as $item)
                                                                - {{ $item->libelle }}
                                                                <strong class="text-danger">[{{ $item->pivot->rang }}]</strong><br>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @if (count($valeur->apparences))
                                                                <span data-toggle="tooltip" data-placement="top" title="{{  $valeur->apparences->first()->id  }}" data-original-title="{{  $valeur->apparences->first()->id  }}">
                                                                    @if(!empty($valeur->apparences->first()->getMedia('image')->first()))
                                                                        <img width="70" src="{{ url($valeur->apparences->first()->getMedia('image')->first()->getUrl('thumb')) }}">
                                                                    @endif
                                                                    {{ $valeur->apparences->first()->libelle }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if ($infosPage['slug'] == 'rubrique')
                                                            @can($infosPage['can'].$infosPage['slug'].' edit')
                                                                <a href="{{ url('celestadmin/rubrique/filter/'.$valeur->id) }}" class="btn btn-warning waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Trier les champs">
                                                                    <i class="icofont-filter"></i>
                                                                </a>
                                                            @endcan
                                                        @endif
                                                        @include('celestadmin.layouts.action')
                                                    </td>
                                                    <td>
                                                        <div style="color:#fff; font-size:1px;">
                                                            {{ $valeur->created_at->format('Y/m/d H:i') }}
                                                        </div>
                                                        {{ $valeur->created_at->diffForHumans() }}
                                                    </td>
                                                </tr>
                                                @if(count($valeur->childrens))
                                                    @include('celestadmin.categorie.children', [
                                                        'childrens' => $valeur->childrens,
                                                        'nombreIteration' => 1,
                                                        'page' => 'index',
                                                        'i' => $i,
                                                        'option' => $taxonomie,
                                                    ])
                                                @endif
                                                @php ($i += count($valeur->childrens))
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('celestadmin.layouts.footer')
        </div>
    </div>
@endsection
