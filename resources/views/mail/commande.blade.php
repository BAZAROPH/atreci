@component('mail::message')
@php($created_at = new Carbon\Carbon($commande->created_at))
@php($date_livraison = new Carbon\Carbon($commande->date_livraison))
@php($date_user = new Carbon\Carbon($commande->user->created_at))
@php(Cart::instance('shopping')->setGlobalTax(0))
@php($livraison = coutLivraison(Cart::instance('shopping')->subtotal()))
@if ($type == 'administrateur')
<h1 style="text-align: center">Recapitulatif de la commande {{ $commande->reference }}</h1><br>
@else
<h1 style="text-align: center">Votre commande {{ $commande->reference }} a été confirmée</h1><br>
@endif
<div align="center">
<a href="https://www.atre.ci">
<img src="{{ asset('web/img/logo.png') }}" width="200">
</a>
</div>

{{--    --}}
@if ($type == 'administrateur')
<div style="text-align: center">
Nouvelle commande sur <a href="https://www.atre.ci">www.atre.ci</a> du client {{ $commande->user->prenom.' '.$commande->user->name }} du {{ $created_at->formatLocalized('%A %d %B %Y à %H:%M') }}
@if ($commande->commercial_id)
Passé par le commercial {{ $commande->commercial->prenom.' '.$commande->commercial->name }}
@endif
</div>
<div style="border: 1px solid #ccc; margin-top: 20px; padding: 20px; text-align: center; width:100%;">
<h3>Infos client</h3>
<table class="table" style="width: 100%;">
<tr>
<td>
{{ $commande->user->prenom.' '.$commande->user->name }}
</td>
<td>
{{ $commande->user->email }}
</td>
<td>
{{ $commande->adresse->lien }}
</td>
</tr>
</table>
</div>
@else
@if ($commande->commercial_id)
<div>Cher commercial {{ $commande->commercial->prenom.' '.$commande->commercial->name }},</div>
<div>Nous vous remercions d'avoir commandé pour votre client "{{ $commande->user->prenom.' '.$commande->user->name }}" sur Atrê marché!</div>
<div>La commande {{ $commande->reference }} a été confirmée avec succès.</div>
<div>Elle sera emballée et expédiée dès que possible. Votre client recevra une notification de notre part dès que les produits seront prêts à être livrés.</div>
@else
<div>Cher {{ $commande->user->prenom.' '.$commande->user->name }},</div>
<div>Nous vous remercions pour vos achat sur Atrê marché!</div>
<div>Votre commande {{ $commande->reference }} a été confirmée avec succès.</div>
<div>Elle sera emballée et expédiée dès que possible. Vous recevrez une notification de notre part dès que les produits seront prêts à être livrés.</div>
@endif
@endif

<div style="border: 1px solid #ccc; margin-top: 20px; padding: 20px; text-align: center; border-radius: 20px; width:100%;">
<table class="table" style="width: 100%;">
<thead>
<tr>
<th>Article</th>
<th>Quantité</th>
<th>Prix unitaire</th>
<th>Total</th>
</tr>
</thead>
<tbody>
@foreach (Cart::instance('shopping')->content() as $item)
<tr>
@php($post = detailPanier($item->id))
@php($capacite = traitementCategory($post, 'capacite'))
<td scope="row">
<a href="{{ url($post->slug) }}">
@if(!empty($post->getMedia('image')->first()))
<img style="margin-right:10px;float: left; width: 80px;" src="{{ url($post->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $post->name }}">
@endif
{{ $post->name }}
</a>
</td>
<td>{{ $item->qty.' '.$capacite->sous_titre }}</td>
<td>{{ number_format($post->prix_nouveau, 0, '.', ' ').' Fcfa' }}</td>
<td>{{ number_format(($post->prix_nouveau * $item->qty), 0, '.', ' ').' Fcfa' }}</td>
</tr>
@endforeach
</tbody>
</table>
<hr>
<table class="table" width="100%">
<tbody>
<tr>
<td style="text-align: right;">Sous total : </td>
<td style="text-align: left; width: 100px;">{{ Cart::instance('shopping')->subtotal(0, ',', ' ') }} Fcfa</td>
</tr>
<tr>
<td style="text-align: right;">Livraison : </td>
<td style="text-align: left; width: 100px;">{{ number_format($livraison, 0, '.', ' ') }} Fcfa</td>
</tr>
<tr>
<td style="text-align: right;">Total : </td>
<td style="text-align: left; width: 100px;">{{ number_format(($livraison + Cart::instance('shopping')->subtotal()), 0, '.', ' ') }} Fcfa</td>
</tr>
<tr>
<td style="text-align: right;">Date de livraison : </td>
<td style="text-align: left; width: 100px;">{{ $date_livraison->formatLocalized('%A %d %B %Y') }} entre {{ $commande->heure->libelle }}</td>
</tr>
@if ($commande->adresse)
<tr>
<td style="text-align: right;">Adresse de livraison : </td>
<td style="text-align: left; width: 100px;">{{ $commande->adresse->libelle }} - {{ $commande->adresse->lien }}</td>
</tr>
@endif

@if (count($commande->mode_paiements))
<tr>
<td style="text-align: right;">Moyen de paiement : </td>
<td style="text-align: left; width: 100px;">{{ $commande->mode_paiements->first()->libelle }}</td>
</tr>
@endif
</tbody>
</table>
<p style="text-align: right;">
<a href="{{ url('celestadmin/commandes') }}">Plus de détails</a>
</p>
</div>
@endcomponent
