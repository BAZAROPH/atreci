<link href="https://fonts.googleapis.com/css?family=Dosis|Montserrat|Nunito|Open+Sans|Oxygen|PT+Sans|Poppins|Raleway|Ubuntu&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/design.css') }}">
<style>
    body{
        font-size: 12px
    }
    .table td, .table th {
        padding: 1px;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        font-size: 12px;
        align-items: center;
    }
    div{
        line-height: 14px;
    }
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Oxygen', sans-serif;
    }
</style>
<div style="position: absolute; right: 10px; z-index:10000000">
    <img height="80" src="{{ url($parametre->getMedia('logo')->first()->getUrl('thumb')) }}">
</div>
@include('celestadmin.commande.order')
