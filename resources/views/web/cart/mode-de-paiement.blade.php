@extends('web.layouts.app', [
    'title' => $infosPage['title'],
    'page' => 'accueil',
])
@section('content')
    @include('web.user.entete', [
        'breadcrumb' => '<li class="breadcrumb-item text-nowrap active" aria-current="page">'.$infosPage['title'].'</li>',
    ])
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

                    <a class="step-item active" href="{{ url('adresse-de-livraison') }}">
                        <div class="step-progress">
                            <span class="step-count">2</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-google-map"></i>Adresse
                        </div>
                    </a>

                    <a class="step-item active" href="{{ url('date-de-livraison') }}">
                        <div class="step-progress">
                            <span class="step-count">3</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-ui-calendar"></i>Date & heure
                        </div>
                    </a>

                    <span class="step-item active current" href="{{ url('') }}">
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
                @if ($nombreCommandes == 0)
                    <div class="mt-3 alert alert-info">
                        @php($livraison = coutLivraison(Cart::instance('shopping')->subtotal()))
                        @if (Cart::instance('shopping')->total() + $livraison > 5000)
                            Cher client, atrê marché exige un acompte de <strong>5000 FCFA</strong> pour tous nouveaux clients.<br>Veuillez donc choisir votre moyen de paiement pour pouvoir faire valider votre commande.
                        @else
                            Cher client, atrê marché exige le paiement total des commandes de moins de <strong>5000 FCFA</strong> pour tous nouveaux clients.<br> Veuillez donc choisir votre moyen de paiement pour pouvoir faire valider votre commande.
                        @endif
                    </div>
                @endif
                <form method="post" action="">
                    @csrf
                    @php($i = 0)
                    @foreach ($moyenPaiement as $item)
                        @php($i++)
                        <div class="row pt-2">
                            <div class="col-md-12 mb-grid-gutter">
                                <div>
                                    <div class="custom-control custom-radio radio-toggle">
                                        <input name="mode" style="margin-top: 25px;" type="radio" value="{{ $item->id }}" class="toggle1" id="{{ ($i == 1) ? 'defaultUnchecked' : 'defaultChecked' }}" <?php if($i == 1) echo 'checked'; ?>>

                                        <label style="display: inline;" class="custom-control-label" for="{{ ($i == 1) ? 'defaultUnchecked' : 'defaultChecked' }}">
                                            @if(!empty($item->getMedia('image')->first()))
                                                <img class="float-left" width="100" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="Atrê marché">
                                            @endif

                                            <div style="text-align: center; font-weight: bold; font-size: 21px;">
                                                {{ $item->libelle }}
                                            </div>
                                            <i>
                                                {!! $item->description !!}
                                            </i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <p id="suivant">
                        <button type="submit" class="btn btn-lg btn-block btn-success">
                            Suivant
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        </button>
                    </p>

                    <div class="row" id="monAcompte" style="display: none;">
                        <div class="col-md-12">
                            <button type="submit" name="payer5000" class="btn btn-lg btn-success btn-block">PAYER UN ACOMPTE DE 5 000 FCFA &nbsp; <i class="fa fa-angle-double-right"></i></button>
                        </div>
                        <div class="col-md-12 text-center">OU</div>
                        <div class="col-md-12">
                            <button type="submit" name="payerTotalite" class="btn btn-lg btn-success btn-block">
                                PAYER LA TOTALITÉ DE VOTRE COMMANDE
                                @php($livraison = coutLivraison(Cart::instance('shopping')->subtotal()))
                                {{ number_format(Cart::instance('shopping')->total()+$livraison, 0, '.', ' ') }} Fcfa
                                &nbsp; <i class="fa fa-angle-double-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            @include('web.cart.recapitulatif')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('.toggle1').change(function() {
            var mode = $(this).val();
            var nbr_commande = $("#nbr_commande").val();
            var totalCommande = $("#totalCommande").val();

            if(mode == 351){
                if({{ $nombreCommandes }} == 0 && {{ Cart::instance('shopping')->total()+$livraison }} > 5000){
                    $('.Myfrais').show();
                    $('.totalAmount').show();
                    $('.totalCommande').hide();
                    $('.Myacompte').show();
                    $('.resteAPayer').show();
                    $('#suivant').hide();
                    $('#monAcompte').show();
                }
                else{
                    $('.Myfrais').show();
                    $('.totalAmount').show();
                    $('.totalCommande').hide();
                    $('.Myacompte').hide();
                    $('.resteAPayer').hide();
                    $('#suivant').show();
                    $('#monAcompte').hide();
                }
            }
            else{
                $('.Myfrais').hide();
                $('.totalAmount').hide();
                $('.totalCommande').show();
                $('.Myacompte').hide();
                $('.resteAPayer').hide();
                $('#suivant').show();
                $('#monAcompte').hide();
            }
        });
    </script>
@endsection
