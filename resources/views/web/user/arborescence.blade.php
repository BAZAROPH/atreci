<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Filleuls</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <table id="simpletable" class="dt-responsive nowrap" width="100%">
                    <tbody>
                        <tr>
                            @php($i = 0)
                            @php($border = 'style="border-right: 1px solid #b15c1c;"')
                            @forelse ($user->childrens as $item)
                                @php($i++)
                                <td {!! ($i == 1) ? 'style="border-right: 1px solid #b15c1c;"' : '' !!}>
                                    <div class="text-center text-danger">
                                        @if(!empty($item->getMedia('image')->first()))
                                            <img class="img-fluid circle" width="40" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}">
                                        @else
                                            <img class="img-fluid circle" width="40" src="{{ asset('admin/image/user.png') }}">
                                        @endif
                                        {{ $item->prenom.' '.$item->name }}
                                        <strong class="text-danger">
                                            [{{ $item->matricule }}]
                                        </strong>
                                    </div>
                                    <div class="text-center" style="margin-top: -10px;">
                                        Inscrit {{ $item->created_at->diffForHumans() }}
                                    </div>
                                    @if(count($item->childrens))
                                        <table class="table" width="100%">
                                            <tr>
                                                @include('celestadmin.categorie.children', [
                                                    'childrens' => $item->childrens,
                                                    'nombreIteration' => 1,
                                                    'page' => 'arborescence',
                                                    'i' => $i++,
                                                ])
                                            </tr>
                                        </table>
                                    @endif
                                </td>
                            @empty
                                <div class="alert alert-warning" role="alert">
                                    <strong>Pas de Filleuls</strong>
                                </div>
                            @endforelse
                        </tr>
                    </tbody>
                </table> --}}
                {{-- <div class="content">
                    <figure class="org-chart cf">
                        <ul class="administration">
                            <li>
                                <ul class="director">
                                    <li>
                                        <a href="#">
                                            <span>
                                                {!! auth()->user()->prenom.' '.auth()->user()->name !!}
                                            </span>
                                        </a>
                                        <ul class="subdirector">
                                            <li><a href="#"><span>Assistante Director</span></a></li>
                                        </ul>
                                        <ul class="departments cf">
                                            <li><a href="#"><span>Administration</span></a></li>
                                            <li class="department dep-a">
                                                <a href="#"><span>Department A</span></a>
                                                <ul class="sections">
                                                <li class="section"><a href="#"><span>Section A1</span></a></li>
                                                <li class="section"><a href="#"><span>Section A2</span></a></li>
                                                <li class="section"><a href="#"><span>Section A3</span></a></li>
                                                <li class="section"><a href="#"><span>Section A4</span></a></li>
                                                <li class="section"><a href="#"><span>Section A5</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="department dep-b">
                                                <a href="#"><span>Department B</span></a>
                                                <ul class="sections">
                                                <li class="section"><a href="#"><span>Section B1</span></a></li>
                                                <li class="section"><a href="#"><span>Section B2</span></a></li>
                                                <li class="section"><a href="#"><span>Section B3</span></a></li>
                                                <li class="section"><a href="#"><span>Section B4</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="department dep-c">
                                                <a href="#"><span>Department C</span></a>
                                                <ul class="sections">
                                                <li class="section"><a href="#"><span>Section C1</span></a></li>
                                                <li class="section"><a href="#"><span>Section C2</span></a></li>
                                                <li class="section"><a href="#"><span>Section C3</span></a></li>
                                                <li class="section"><a href="#"><span>Section C4</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="department dep-d">
                                                <a href="#"><span>Department D</span></a>
                                                <ul class="sections">
                                                <li class="section"><a href="#"><span>Section D1</span></a></li>
                                                <li class="section"><a href="#"><span>Section D2</span></a></li>
                                                <li class="section"><a href="#"><span>Section D3</span></a></li>
                                                <li class="section"><a href="#"><span>Section D4</span></a></li>
                                                <li class="section"><a href="#"><span>Section D5</span></a></li>
                                                <li class="section"><a href="#"><span>Section D6</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="department dep-e">
                                                <a href="#"><span>Department E</span></a>
                                                <ul class="sections">
                                                <li class="section"><a href="#"><span>Section E1</span></a></li>
                                                <li class="section"><a href="#"><span>Section E2</span></a></li>
                                                <li class="section"><a href="#"><span>Section E3</span></a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </figure>
                </div> --}}
                {{-- <div class="container-tree">
                    <ul id="tree-data" style="display:none">
                        <li id="root">
                            root
                            <ul>
                                <li id="node1">
                                    node1
                                </li>
                                <li id="node2">
                                    node2
                                    <ul>
                                        <li id="node3">
                                            node3
                                            <ul>
                                                <li id="node4">
                                                    node4
                                                    <ul type="vertical">
                                                        <li id="node5">
                                                            node5
                                                            <ul>
                                                                <li id="node6">
                                                                    node6
                                                                </li>

                                                                <li id="node7">
                                                                    node7
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li id="node8" class="last">
                                                            node8
                                                            <ul>
                                                                <li id="node9">
                                                                    node9
                                                                </li>

                                                                <li id="node10">
                                                                    node10
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li id="node11">
                                                    node11
                                                    <ul type="vertical">
                                                        <li id="node12">
                                                            node12
                                                            <ul>
                                                                <li id="node13">
                                                                    node13
                                                                </li>

                                                                <li id="node14">
                                                                    node14
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li id="node15" class="last">
                                                            node15
                                                            <ul>
                                                                <li id="node16">
                                                                    node16
                                                                </li>

                                                                <li id="node17">
                                                                    node17
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="node18" class="last">
                                            node18
                                            <ul>
                                                <li id="node19">
                                                    node19
                                                </li>

                                                <li id="node20">
                                                    node20
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li id="node21">
                                    node21
                                    <ul type="vertical">
                                        <li id="node22">
                                            node22
                                            <ul>
                                                <li id="node23">
                                                    node23
                                                </li>

                                                <li id="node24">
                                                    node24
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="node25" class="last">
                                            node25
                                            <ul>
                                                <li id="node26">
                                                    node26
                                                </li>

                                                <li id="node27">
                                                    node27
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li id="node28" class="last">
                                    node28
                                    <ul>
                                        <li id="node29">
                                            node29
                                            <ul type="vertical">
                                                <li id="node30">
                                                    node30
                                                    <ul>
                                                        <li id="node31">
                                                            node31
                                                        </li>

                                                        <li id="node32">
                                                            node32
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li id="node33" class="last">
                                                    node33
                                                    <ul>
                                                        <li id="node34">
                                                            node34
                                                        </li>

                                                        <li id="node35">
                                                            node35
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>

                                        <li id="node36">
                                            node36
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li id="node37">
                            node37
                        </li>
                    </ul>
                    <div id="tree-view"></div>
                </div> --}}
                <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
                <script src="orgchart/js/jquery.orgchart.js"></script>
                <script>
                    (function($) {
                        $(function() {
                            var ds = {
                                'name': '{{ auth()->user()->matricule }}',
                                'title': '{{ auth()->user()->prenom." ".auth()->user()->name." -- ".auth()->user()->telephone }}',
                                'children': [
                                    @php($i = 0)
                                    @foreach ($user->childrens as $item)
                                        @php($i++)
                                        {'name': '{{ $item->matricule }}',
                                            'title': '{{ $item->prenom." ".$item->name." -- ".$item->telephone }}',
                                        @if(count($item->childrens))
                                            'children': [
                                                @include('celestadmin.categorie.children', [
                                                    'childrens' => $item->childrens,
                                                    'nombreIteration' => 1,
                                                    'page' => 'arborescence',
                                                    'i' => $i++,
                                                ])
                                            ]
                                        @endif
                                        },
                                    @endforeach
                                ]
                            };
                            var oc = $('#chart-container').orgchart({
                                'data' : ds,
                                'nodeContent': 'title',
                                //'visibleLevel': 999
                            });
                        });
                    })(jQuery);
                </script>
                <div id="chart-container"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
