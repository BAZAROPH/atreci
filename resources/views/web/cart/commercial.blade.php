@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    {{--  <script type="text/javascript">
        $('#add-address').modal('show');
    </script>  --}}
    <form action="addUser" class="needs-validation modal fade" method="post" id="add-user" tabindex="-1" novalidate>
        @csrf
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Nouveau client
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name">
                                    Nom & prénoms <span class="text-danger">*</span>
                                </label>
                                <input value="{{ old('name') }}" name="name" class="form-control" type="text" id="name" required>
                                <div class="invalid-feedback">Veuillez renseigner le nom!</div>
                                @error('name')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email">
                                    Email
                                </label>
                                <input value="{{ old('email') }}" name="email" class="form-control" type="email" id="email">
                                @error('email')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="telephone">
                                    N°téléphone <span class="text-danger">*</span>
                                </label>
                                <input value="{{ old('telephone') }}" name="telephone" class="form-control" type="text" id="telephone" required>
                                <div class="invalid-feedback">Veuillez indiquer votre numéro de téléphone !</div>
                                @error('telephone')
                                    <div class="text-danger text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermer</button>
                    <button class="btn btn-primary btn-shadow" type="submit">Ajouter client</button>
                </div>
            </div>
        </div>
    </form>

    @foreach ($users as $user)
        <form action="/editUser/{{ $user->id }}" class="needs-validation modal fade" method="post" id="edit-user{{ $user->id }}" tabindex="-1" novalidate>
            @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                            Modifier ce client <strong>"{{ $user->name }}"</strong>
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">
                                        Nom & prénoms <span class="text-danger">*</span>
                                    </label>
                                    <input value="{{ $user->name }}" name="name" class="form-control" type="text" id="name" required>
                                    <div class="invalid-feedback">Veuillez renseigner le nom!</div>
                                    @error('name')
                                        <div class="text-danger text-center">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input value="{{ $user->email }}" name="email" class="form-control" type="email" id="email" required>
                                    @error('email')
                                        <div class="text-danger text-center">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="telephone">
                                        N°téléphone <span class="text-danger">*</span>
                                    </label>
                                    <input value="{{ $user->telephone }}" name="telephone" class="form-control" type="text" id="telephone" required>
                                    <div class="invalid-feedback">Veuillez indiquer votre numéro de téléphone !</div>
                                    @error('telephone')
                                        <div class="text-danger text-center">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermer</button>
                        <button class="btn btn-primary btn-shadow" type="submit">Modifier</button>
                    </div>
                </div>
            </div>
        </form>
    @endforeach

    @include('web.user.entete', [
        'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">'.$infosPage['title'].'</li>',
    ])
    {{--  <div class="page-title-overlap bg-dark pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ url('/') }}">
                                <i class="czi-home"></i>Accueil
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                <h1 class="h3 text-light mb-0">
                    Finalisation de la commande
                </h1>
            </div>
        </div>
    </div>  --}}
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <section class="col-lg-8">
                <!-- Steps-->
                <div class="steps steps-light pt-2 pb-3 mb-5">
                    <a class="step-item active" href="{{ url('/panier') }}">
                        <div class="step-progress">
                            <span class="step-count">1</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-cart"></i>Panier
                        </div>
                    </a>

                    <a class="step-item active current" href="#">
                        <div class="step-progress">
                            <span class="step-count">2</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-google-map"></i>Adresse
                        </div>
                    </a>

                    <span class="step-item" href="#">
                        <div class="step-progress">
                            <span class="step-count">3</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-ui-calendar"></i>Date & heure
                        </div>
                    </span>

                    <span class="step-item" href="{{ url('') }}">
                        <div class="step-progress">
                            <span class="step-count">4</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-card"></i>Paiement
                        </div>
                    </span>
                    <span class="step-item" href="{{ url('') }}">
                        <div class="step-progress">
                            <span class="step-count">5</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-check-circle"></i>Résumé
                        </div>
                    </span>
                </div>
                @include('flash::message')

                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger text-center">{{ $error }}</p>
                @endforeach
                <!-- Autor info-->
                {{--  <div class="d-sm-flex justify-content-between align-items-center bg-secondary p-4 rounded-lg mb-grid-gutter">
                    <div class="media align-items-center">
                        <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
                            <span class="badge badge-warning" data-toggle="tooltip" title="Reward points">384</span>
                            <img class="rounded-circle" src="img/shop/account/avatar.jpg" alt="Susan Gardner">
                        </div>
                        <div class="media-body pl-3">
                            <h3 class="font-size-base mb-0">Susan Gardner</h3>
                            <span class="text-accent font-size-sm">s.gardner@example.com</span>
                        </div>
                    </div>
                    <a class="btn btn-light btn-sm btn-shadow mt-3 mt-sm-0" href="account-profile.html">
                        <i class="czi-edit mr-2"></i>Edit profile
                    </a>
                </div>  --}}
                <div class="row pt-4">
                    <div class="col-lg-12 mb-grid-gutter">
                        <div class="text-sm-right">
                            <a class="btn btn-primary" href="#add-user" data-toggle="modal">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                Ajouter un nouveau client
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive font-size-md">
                        <table class="table table-hover mb-0" id="simpletable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 0)
                                @forelse ($users as $user)
                                    @php($i++)
                                    <tr>
                                        <td class="py-3 align-middle">
                                            {{ $i }}
                                        </td>
                                        <td class="py-3 align-middle font-size-xs">
                                            <div style="color:#fff; font-size:1px;">
                                                {{ $user->created_at->format('Y/m/d H:i') }}
                                            </div>
                                            {{ $user->created_at->diffForHumans() }}
                                        </td>
                                        <td class="py-3 align-middle">
                                            {{--  Modification de client  --}}
                                            <span class="font-weight-bold">{{ $user->name }}</span>
                                            : [{{ $user->telephone }} - {{ $user->email }}]
                                        </td>
                                        <td class="py-3 align-middle">
                                            <a class="nav-link-style mr-2" href="#edit-user{{ $user->id }}" data-toggle="modal">
                                                <i class="czi-edit"></i>
                                            </a>
                                            <a class="nav-link-style mr-2 btn btn-success btn-sm" href="{{ url('commercial?client='.$user->id) }}" data-toggle="tooltip" title="Commander pour {{ $user->name }}">
                                                <i class="icofont-bullseye"></i> Choisir
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="col-lg-12 mb-grid-gutter">
                                        <div class="alert alert-danger text-center">
                                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                            Vous n'avez pas de client associé à votre compte
                                        </div>
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            @include('web.cart.recapitulatif')
        </div>
    </div>
@endsection

@push('dataTable')
<!-- data-table js -->
<script src="https://cdn.qenium.com/bower/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.qenium.com/assets/plugins/data-table/js/jszip.min.js"></script>
<script src="https://cdn.qenium.com/assets/plugins/data-table/js/pdfmake.min.js"></script>
<script src="https://cdn.qenium.com/assets/plugins/data-table/js/vfs_fonts.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.qenium.com/bower/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('admin/pages/data-table.js') }}"></script>
@endpush
