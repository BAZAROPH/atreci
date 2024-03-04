@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'profil',
])
@section('content')

@include('web.user.entete', [
    'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">Votre compte</li>',
])
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-3">
	<div class="row">
		@include('web.user.compte-user')
		<!-- Content  -->
		<section class="col-lg-8 mt-5 pt-5">
            @include('flash::message')
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header border-success">
                            Informations pardonnelles
                            <span class="float-right">
                                <a href="{{ url('profil/edit') }}"><i class="icofont-pen-alt-1"></i></a>
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="card-text font-size-sm">
                                <i class="icofont-check-circled"></i>
                                {!! auth()->user()->prenom.' '.auth()->user()->name !!}
                            </p>
                            <p class="card-text font-size-sm">
                                <i class="icofont-check-circled"></i>
                                {!! auth()->user()->email !!}
                            </p>
                            <p class="card-text font-size-sm">
                                <a href="{{ url('profil/password') }}">
                                    <i class="icofont-ui-lock"></i>
                                    Modidifier mot de passe
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header border-success">
                            Adresses de livraison
                            <span class="float-right">
                                <a href="{{ url('profil/adresses') }}"><i class="icofont-pen-alt-1"></i></a>
                            </span>
                        </div>
                        <div class="card-body">
                            @foreach ($user->adresses as $item)
                                <p class="card-text font-size-sm">
                                    <a href="{{ url('profil/adresses#') }}">
                                        <i class="icofont-pen-alt-1"></i>
                                        {{ $item->libelle }}
                                    </a>
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-6 mt-3">
                    <div class="card border-success">
                        <div class="card-header border-success">
                            Commandes <span class="badge badge-primary">5</span>
                            <span class="float-right">
                                <a href="{{ url('profil/adresses') }}"><i class="icofont-pen-alt-1"></i></a>
                            </span>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div> --}}
            </div>
		</section>
	</div>
</div>
@endsection
