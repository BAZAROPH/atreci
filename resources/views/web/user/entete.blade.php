<div class="page-title-overlap bg-dark pt-4">
	<div class="container d-lg-flex justify-content-between py-2 py-lg-3">
		<div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
					<li class="breadcrumb-item">
                        <a class="text-nowrap" href="{{ url('/') }}"><i class="czi-home"></i>Accueil</a>
                    </li>
                    {!! $breadcrumb !!}
				</ol>
			</nav>
		</div>
		<div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 text-light mb-0">
                {{ $infosPage['title'] }}
                @isset ($client)
                    <div class="font-size-sm badge badge-info" style="white-space: normal;">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        Vous êtes en train de passer une une commande pour :
                        {{ $client->name.' '.$client->prenom }}
                        <a href="{{ url('commercial') }}" class="text-white">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </a>
                    </div>
                @endisset
            </h1>
		</div>
	</div>
</div>
