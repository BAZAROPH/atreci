@extends('celestadmin.layouts.app', [
    'title' => $infosPage['title']
])

@section('content')
    <div class="wrapper">
        @include('celestadmin.layouts.menu')
        <!-- Sidebar chat end-->
        <div class="content-wrapper">
            <div class="container-fluid">
                @include('celestadmin.layouts.header', [
                    'id' => '/q',
                ])
                @if (request('status') == 'trashed')
                    @php($valeurs = $trashed)
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                {{-- <table id="simpletable" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Commande</th>
                                            <th>Source</th>
                                            <th>Paiement</th>
                                            <th>Etat</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                            <th>Client</th>
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Commande</th>
                                            <th>Source</th>
                                            <th>Paiement</th>
                                            <th>Etat</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                            <th>Client</th>
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php ($i = 0)
                                        @foreach ($valeurs as $valeur)
                                            @php ($i++)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>
                                                    @if(!empty($valeur->getMedia('logo')->first()))
                                                        <img width="150" src="{{ url($valeur->getMedia('logo')->first()->getUrl('thumb')) }}">
                                                    @endif
                                                    {{ $valeur->reference }}
                                                </td>
                                                <td>
                                                    {{ $valeur->source->libelle }}
                                                </td>
                                                <td>

                                                </td>
                                                <td>
                                                    {{ $valeur->etat->libelle }}
                                                </td>
                                                <td>
                                                    {{ $valeur->quantite_produit }}
                                                </td>
                                                <td>
                                                    {{ $valeur->total_commande }}
                                                </td>
                                                <td>
                                                    <a href="{{ url('celestadmin/user/'.$valeur->user->id) }}">
                                                        {{ $valeur->user->name.' '.$valeur->user->prenom }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @include('celestadmin.layouts.action')
                                                </td>
                                                <td>
                                                    <div style="color:#fff; font-size:1px;">
                                                        {{ $valeur->created_at->format('Y/m/d H:i') }}
                                                    </div>
                                                    {{ $valeur->created_at->diffForHumans() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table> --}}
                                {{-- {{ $valeurs->links() }} --}}
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Commande</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                            <th>Actions</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {

          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('commandes') }}",
              columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'reference', name: 'reference'},
            {data: 'quantite_produit', name: 'quantite_produit'},
            {data: 'reference', name: 'total_commande'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
        ]
          });

        });
      </script>
@endsection
