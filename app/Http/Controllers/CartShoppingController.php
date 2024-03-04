<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Commande;
use App\Mail\CommandeMail;
use App\Post;
use App\User;
use Carbon\Carbon;
use DateTime;
use Detection\MobileDetect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

//use Illuminate\Support\Facades\Cookie;
//use Symfony\Component\HttpFoundation\Cookie;

class CartShoppingController extends Controller
{
    function addCart($id)
    {
        $post = Post::with([
            'categories'/* => function($q){
                $q->wherePivot('type', 'subdivision');
            }*/,
        ])
        ->findOrFail($id);
        foreach ($post->categories as $subdivision) {
            if ($subdivision->pivot->type == 'subdivision') {
                break;
            }
        }
        //dd($subdivision->toArray());
        /*$cart = Cart::instance('shopping')->content();
        $cart->search(function ($cartItem, $rowId) use($post) {
            return $cartItem->id === $post->reference;
        });*/
        //dd($cart->toArray());
        Cart::instance('shopping')->add($post->reference, $post->libelle, $subdivision->sous_titre, $post->prix_nouveau);
        //Cart::instance('shopping')->store('username');
        //dd(Cart::instance('shopping')->count());

        //flash()->overlay('Ajout de <strong>"'.$post->libelle.'"</strong> panier effectué avec succès', 'Panier')->success();
        Alert::success('Panier', 'Ajout de "'.$post->libelle.'" au panier effectué avec succès');

        $quantite_produit = Cart::instance('shopping')->count();
        //dd($quantite_produit);
        $cout_commande = Cart::instance('shopping')->subtotal();
        $cout_livraison = coutLivraison($cout_commande);
        $total_commande = $cout_commande + $cout_livraison;
        $user_id = (auth()->user()) ? auth()->user()->id : null;

        if (!Cookie::get('invATR')) {
            //dd($total_commande);
            $commande = Commande::create([
                'quantite_produit' => $quantite_produit,
                'cout_commande' => $cout_commande,
                'cout_livraison' => $cout_livraison,
                'total_commande' => $total_commande,
                'type' => 'produit',
                'user_id' => $user_id,
                'etat_id' => 357,
                'livraison_mode_id' => 362,
                'source_id' => mobile_detect_devise(),
                'created_ip' => request()->ip(),
            ]);
            foreach (Cart::instance('shopping')->content() as $item){
                $post = detailPanier($item->id);
                $commande->produits()->attach($post->id, [
                    'cout' => $post->prix_nouveau,
                    'quantite' => $item->qty,
                    //'options' => null, //pas gérer
                ]);
            }
            $cookie = Cookie::make('invATR', $commande->reference, dureeCookie());
            return back()->cookie($cookie);
        }
        else {
            if (!Cookie::get('invATR')) {
                $commande = Commande::create([
                    'quantite_produit' => $quantite_produit,
                    'cout_commande' => $cout_commande,
                    'cout_livraison' => $cout_livraison,
                    'total_commande' => $total_commande,
                    'type' => 'produit',
                    'user_id' => $user_id,
                    'etat_id' => 357,
                    'livraison_mode_id' => 362,
                    'source_id' => mobile_detect_devise(),
                ]);
                foreach (Cart::instance('shopping')->content() as $item){
                    $post = detailPanier($item->id);
                    $commande->produits()->attach($post->id, [
                        'cout' => $post->prix_nouveau,
                        'quantite' => $item->qty,
                        //'options' => null, //pas gérer
                    ]);
                }
                $cookie = Cookie::make('invATR', $commande->reference, dureeCookie());
                return back()->cookie($cookie);
            }
            $commande = Commande::with([
                'produits'
            ])
            ->where('reference', Cookie::get('invATR'))
            ->first();
            if ($commande->etat_id == 110 or $commande->etat_id == 111 or $commande->etat_id == 112 or $commande->etat_id == 355 or $commande->etat_id == 356) {
                # code...
            }
            //dd(Cookie::get('invATR'));
            $commande->quantite_produit = $quantite_produit;
            $commande->cout_commande = $cout_commande;
            $commande->cout_livraison = $cout_livraison;
            $commande->total_commande = $total_commande;
            $commande->save();
            //dd($commande->toArray());
            foreach (Cart::instance('shopping')->content() as $item){
                $post = detailPanier($item->id);
                $commande->produits()->detach($post->id, [
                    'cout' => $post->prix_nouveau,
                    'quantite' => $item->qty,
                    //'options' => null, //pas gérer
                ]);
                $commande->produits()->attach($post->id, [
                    'cout' => $post->prix_nouveau,
                    'quantite' => $item->qty,
                    //'options' => null, //pas gérer
                ]);
            }
            return back();
        }
    }

    function addWishlist($id)
    {
        $post = Post::with([
            'categories'/* => function($q){
                $q->wherePivot('type', 'subdivision');
            }*/,
        ])
        ->findOrFail($id);
        foreach ($post->categories as $subdivision) {
            if ($subdivision->pivot->type == 'subdivision') {
                break;
            }
        }
        //dd($subdivision->toArray());
        /*$cart = Cart::instance('shopping')->content();
        $cart->search(function ($cartItem, $rowId) use($post) {
            return $cartItem->id === $post->reference;
        });*/
        //dd($cart->toArray());
        Cart::instance('wishlist')->add($post->reference, $post->libelle, $subdivision->sous_titre, $post->prix_nouveau);
        //Cart::instance('wishlist')->store('username');
        //dd(Cart::content()->toArray());

        flash()->overlay('Ajout de <strong>"'.$post->libelle.'"</strong> à la liste d‘envie effectué avec succès', 'Liste d‘envie')->success();
        return back();
    }

    function panier()
    {
        $user_id = (auth()->user()) ? auth()->user()->id : null;
        $commande = detailCommande('reference', Cookie::get('invATR'));
        //dd($commande);
        if ($commande) {
            //dd($commande->toArray());
            // Modifier la quantité d'un produit dans le panier
            foreach (Cart::instance('shopping')->content() as $item) {
                if (request($item->id)) {
                    Cart::instance('shopping')->update($item->rowId, request($item->id)); // Will update the quantity
                }
                $post = detailPanier($item->id);
                $commande->produits()->detach($post->id, [
                    'cout' => $post->prix_nouveau,
                    'quantite' => $item->qty,
                    //'options' => null, //pas gérer
                ]);
                $commande->produits()->attach($post->id, [
                    'cout' => $post->prix_nouveau,
                    'quantite' => $item->qty,
                    //'options' => null, //pas gérer
                ]);
            }

            // Après modification des quantités du panier mise à jour dans la commande
            $quantite_produit = Cart::instance('shopping')->count();
            $cout_commande = Cart::instance('shopping')->subtotal();
            $cout_livraison = coutLivraison($cout_commande);
            $total_commande = $cout_commande + $cout_livraison;
            if ($commande->quantite_produit != $cout_commande) {
                $commande->quantite_produit = $quantite_produit;
                $commande->cout_commande = $cout_commande;
                $commande->cout_livraison = $cout_livraison;
                $commande->total_commande = $total_commande;
                $commande->save();
            }


            // Vider panier
            if (request('clean') == 1) {
                //dd('uhjbn');
                Cart::instance('shopping')->destroy();
                $cookie = Cookie::forget('invATR');
                if ($commande) {
                    $commande->etat_id = 361;
                    $commande->save();
                }

                flash('Panier vider avec succès')->success();
                return redirect('panier')->cookie($cookie);
            }

            // Supprimer élément du panier
            if (request('rowId')) {
                //dd(Cart::instance('shopping')->content());
                foreach (Cart::instance('shopping')->content() as $item){
                    $post = detailPanier($item->id);
                    $commande->produits()->detach($post->id, [
                        'cout' => $post->prix_nouveau,
                        'quantite' => $item->qty,
                        //'options' => null, //pas gérer
                    ]);
                }
                Cart::instance('shopping')->remove(request('rowId'));
                foreach (Cart::instance('shopping')->content() as $item){
                    $post = detailPanier($item->id);
                    $commande->produits()->attach($post->id, [
                        'cout' => $post->prix_nouveau,
                        'quantite' => $item->qty,
                        //'options' => null, //pas gérer
                    ]);
                }
                // Après suppression d'une ligne du panier mise à jour de la commande
                $quantite_produit = Cart::instance('shopping')->count();
                $cout_commande = Cart::instance('shopping')->subtotal();
                $cout_livraison = coutLivraison($cout_commande);
                $total_commande = $cout_commande + $cout_livraison;
                $commande->quantite_produit = $quantite_produit;
                $commande->cout_commande = $cout_commande;
                $commande->cout_livraison = $cout_livraison;
                $commande->total_commande = $total_commande;
                $commande->save();
                flash('Elément supprimé avec succès')->success();
                return redirect('panier');
            }

            // Commande commercial
            if (request('commercial') == 'atre' and (auth()->user()->getRoleNames()->first() == 'admin' or auth()->user()->getRoleNames()->first() == 'superadmin')) {
                //$cookie = Cookie::make('commercial', auth()->user()->id, dureeCookie());
                $commande->commercial_id = auth()->user()->id;
                $commande->save();
                //dd($commande->toArray());
                flash('Vous passez une commande pour vos clients')->success();
                return redirect('commercial');
            }
            if(request('commercial') == 1) {
                if ($commande->commercial_id) {
                    $commande->commercial_id = null;
                    $commande->save();
                }
                return redirect('adresse-de-livraison');
            }
        }
        //dd(Cart::instance('shopping')->content()->toArray());
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->log('show cart');
        // End journalisation
        return view('web.cart.panier')->with([
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Panier',
                'slug' => 'panier',
            ),
        ]);
    }

    // Liste d'envie
    function wishlist()
    {
        if (request('clean') == 1) {
            Cart::instance('wishlist')->destroy();
            return redirect('wishlist');
        }
        if (request('rowId')) {
            Cart::instance('wishlist')->remove(request('rowId'));
            flash('Elément supprimé avec succès')->success();
            return redirect('wishlist');
        }
        $parametre = parametre_web();
        // Journalisation
        activity()
            ->log('show wishlist');
        // End journalisation
        return view('web.cart.wishlist')->with([
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Wishlist',
                'slug' => 'wishlist',
            ),
        ]);
    }

    // Compte commercial
    function compteCommercial()
    {
        return_panier();
        $commande = detailCommande('reference', Cookie::get('invATR'));
        //dd($commande->toArray());
        /* if (!$commande) {
            $commande = panierCommande('reference', Cookie::get('invATR'), auth()->user());
        } */
        // Listing des users d'un commercial
        if(auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin')){
            $users = User::orderBy('id', 'desc')
            ->with([
                'childrens',
                'roles',
                'permissions',
            ])
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['detaillant', 'grossiste', 'fournisseur']);
            })
            ->get();
        }
        else{
            $users = User::where([
                'parent_id' => auth()->user()->id,
            ])
            ->with([
                'childrens',
                'roles',
                'permissions',
            ])
            ->orderBy('id', 'desc')
            ->get();
        }
        //dd($users->toArray());

        if ($commande->commercial_id) {
            $user_id = $commande->user_id;
            $client = User::find($user_id);
        }
        else{
            $user_id = auth()->user()->id;
            $client = null;
        }

        // Commande commercial
        if (request('client')) {
            //$cookie = Cookie::make('client_id', request('client'), dureeCookie());
            $commande->user_id = request('client');
            $commande->save();
            //dd($commande->toArray());
            flash('Vous passez une commande pour vos clients')->success();
            return redirect('adresse-de-livraison')/* ->cookie($cookie) */;
        }
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout listing user-commercial');
        // End journalisation
        return view('web.cart.commercial')->with([
            'client' => $client,
            'parametre' => $parametre,
            'users' => $users,
            'infosPage' => array(
                'title' => 'Compte commercial',
                'slug' => 'commercial',
            ),
        ]);
    }

    // Ajouter un client pour un commercial
    function addUser(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'email|nullable|max:255|string|unique:users',
            'telephone' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'telephone' => request('telephone'),
            'parent_id' => auth()->user()->id,
            'user_id' => auth()->user()->id,
        ]);
        $user->assignRole('detaillant');
        if(request('email')){
            //Mail::to($data['email'])->send(new InscriptionMail($data));
        }
        flash('Ajout effectué avec succès')->success();
        return back();
    }

    // Modifier un client d'un commercial
    function editUser(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'email|nullable|max:255|string',
            'telephone' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->telephone = request('telephone');
        $user->save();
        flash('Modification effectuée avec succès')->success();
        return back();
    }

    // Adresse de livraison
    function adresseLivraison()
    {
        return_panier();
        $commande = detailCommande('reference', Cookie::get('invATR'));
        //dd($commande->toArray());
        /* if (!$commande) {
            $commande = panierCommande('reference', Cookie::get('invATR'), auth()->user());
        } */

        if ($commande->commercial_id) {
            $user_id = $commande->user_id;
            $client = User::find($user_id);
        }
        else{
            $user_id = auth()->user()->id;
            $client = null;
            if (!$commande->user_id) {
                $commande->user_id = $user_id;
                $commande->save();
            }
        }
        // Les adresses de livraison d'un user
        $adresses = Categorie::with([
            'parent'
        ])
        ->where([
            'user_id' => $user_id,
            'taxonomie_id' => 33,
        ])
        ->orderBy('id', 'desc')
        ->get();

        // Listing des pays
        $pays = Categorie::where([
            'taxonomie_id' => 4,
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        //dd($adresses->toArray());
        if (!count(Cart::instance('shopping')->content())){
            return redirect('panier');
        }

        // Vérification adresse de livraison avant de passer à date de livraison
        if (request('address_id')) {
            $adresse = Categorie::where([
                'user_id' => $user_id,
                'taxonomie_id' => 33,
                'id' => request('address_id'),
            ])->first();
            //dd($adresse);
            if ($adresse) {
                //$cookie = Cookie::make('adresse', request('address_id'), dureeCookie());
                $commande->adresse_id = request('address_id');
                $commande->save();
                return redirect('date-de-livraison')/* ->cookie($cookie) */;
            }
            else {
                flash('Cette de adresse de livraison est inconnue !!')->error();
                return redirect('adresse-de-livraison');
            }
        }
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout listing user-adresse');
        // End journalisation
        return view('web.cart.adresse-de-livraison')->with([
            'client' => $client,
            'pays' => $pays,
            'parametre' => $parametre,
            'adresses' => $adresses,
            'infosPage' => array(
                'title' => 'Adresse de livraison',
                'slug' => 'adresse-de-livraison',
            ),
        ]);
    }

    // Ajouter une adresse de livraison d'un user
    function addAddress(Request $request)
    {
        $this->validate($request,[
            'pays_id' => 'required|integer',
            'ville' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
        ]);

        $commande = detailCommande('reference', Cookie::get('invATR'));
        if ($commande->commercial_id) {
            $user_id = $commande->user_id;
        }
        else{
            $user_id = auth()->user()->id;
        }
        $adresse = Categorie::create([
            'libelle' => request('adresse'),
            'sous_titre' => request('ville'),
            'lien' => request('telephone'),
            'parent_id' => request('pays_id'),
            'taxonomie_id' => 33,
            'user_id' => $user_id,
        ]);
        flash('Ajout effectué avec succès')->success();
        return back();
    }

    // Modifier adresse de livraison d'un user
    function editAddress(Request $request, $id)
    {
        $this->validate($request,[
            'pays_id' => 'required|integer',
            'ville' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
        ]);

        $adresse = Categorie::findOrFail($id);
        $adresse->parent_id = request('pays_id');
        $adresse->libelle = request('adresse');
        $adresse->sous_titre = request('ville');
        $adresse->lien = request('telephone');
        $adresse->save();
        flash('Modification effectuée avec succès')->success();
        return back();
    }

    // Ajouter une adresse de livraison d'un user
    function deleteAddress(Request $request, $id)
    {
        $adresse = Categorie::findOrFail($id);
        $adresse->delete();
        flash('Suppression effectuée avec succès')->success();
        return back();
    }

    // Page de choix de la date de livraison
    function dateLivraison()
    {
        $commande = detailCommande('reference', Cookie::get('invATR'));
        //dd($adresses->toArray());
        if (!count(Cart::instance('shopping')->content())){
            return redirect('panier');
        }
        if (!$commande->adresse_id){
            return redirect('adresse-de-livraison');
        }
        if ($commande->commercial_id) {
            $user_id = $commande->user_id;
            $client = User::find($user_id);
        }
        else{
            $user_id = auth()->user()->id;
            $client = null;
            if (!$commande->user_id) {
                $commande->user_id = $user_id;
                $commande->save();
            }
        }


        // Vérification adresse de livraison avant de passer à date de livraison
        if (request('date') == 'tomorrow') {
            //$resultDate = dateLivraison($date);
            //$cookie = Cookie::make('dateLivraison', $date, dureeCookie());
            $commande->date_livraison = Carbon::tomorrow();
            $commande->save();
            return redirect('heure-de-livraison')/* ->cookie($cookie) */;
        }
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout date-de-livraison');
        // End journalisation
        return view('web.cart.date-de-livraison')->with([
            'client' => $client,
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Date & heure de livraison',
                'slug' => 'date-de-livraison',
            ),
        ]);
    }

    // Choisir une date livraison
    function choixDate(Request $request)
    {
        $this->validate($request,[
            'date' => 'required|date',
        ]);
        $commande = detailCommande('reference', Cookie::get('invATR'));
        //$cookie = Cookie::make('dateLivraison', request('date'), dureeCookie());
        $commande->date_livraison = request('date');
        $commande->save();
        //flash('Ajout effectué avec succès')->success();
        return redirect('heure-de-livraison')/* ->cookie($cookie) */;
    }

    // Page de choix de l'heure de de livraison
    function heureLivraison()
    {
        if (!count(Cart::instance('shopping')->content())){
            return redirect('panier');
        }
        $commande = detailCommande('reference', Cookie::get('invATR'));
        //dd($commande->toArray());
        if (!$commande->adresse_id){
            return redirect('adresse-de-livraison');
        }
        if (!$commande->date_livraison){
            return redirect('date-de-livraison');
        }
        if ($commande->date_livraison <= Carbon::today()){
            return redirect('date-de-livraison');
        }
        if ($commande->commercial_id) {
            $user_id = $commande->user_id;
            $client = User::find($user_id);
        }
        else{
            $user_id = auth()->user()->id;
            $client = null;
        }

        $resultDate = dateLivraison(new Carbon($commande->date_livraison), $commande->commercial_id);
        $commande->date_livraison = $resultDate['date'];
        $commande->save();
        flash($resultDate['message'])->success();

        // Listing des tranches d'heure de livraison
        $heures = Categorie::where([
            'taxonomie_id' => 34,
        ])
        ->orderBy('id', 'asc')
        ->limit(5)
        ->get();
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout heure-de-livraison');
        // End journalisation
        return view('web.cart.heure-de-livraison')->with([
            'heures' => $heures,
            'client' => $client,
            'parametre' => $parametre,
            'resultDate' => $resultDate,
            'infosPage' => array(
                'title' => 'Date & heure de livraison',
                'slug' => 'heure-de-livraison',
            ),
        ]);
    }

    // Choisir une heure de livraison
    function choixHeure(Request $request)
    {
        $this->validate($request,[
            'heure' => 'required|string',
        ]);
        $commande = detailCommande('reference', Cookie::get('invATR'));
        //$heure = Cookie::make('heureLivraison', request('heure'), dureeCookie());
        $commande->heure_id = request('heure');
        $commande->save();

        //$resultDate = dateLivraison(new Carbon($commande->date_livraison), $commande->commercial_id);
        //$date = Cookie::make('dateLivraison', $resultDate['date'], dureeCookie());
        //flash('Ajout effectué avec succès')->success();
        return redirect('mode-de-paiement')/* ->cookie($heure)->cookie($date) */;
    }

    // Page de choix du mode de paiement
    function modePaiement()
    {
        if (!count(Cart::instance('shopping')->content())){
            return redirect('panier');
        }
        $commande = detailCommande('reference', Cookie::get('invATR'));
        //dd($commande->toArray());
        if (!$commande->adresse_id){
            return redirect('adresse-de-livraison');
        }
        if (!$commande->date_livraison){
            return redirect('date-de-livraison');
        }
        if (!$commande->heure_id){
            return redirect('heure-de-livraison');
        }
        if ($commande->date_livraison <= Carbon::today()){
            return redirect('date-de-livraison');
        }

        $resultDate = dateLivraison(new Carbon($commande->date_livraison), $commande->commercial_id);
        $commande->date_livraison = $resultDate['date'];
        $commande->save();
        flash($resultDate['message'].' entre <strong class="font-size-lg">'.$commande->heure->libelle.'</strong>')->success();

        if ($commande->commercial_id) {
            $user_id = $commande->user_id;
            $client = User::with([
                'commandes' => function($q){
                    $q->whereIn('etat_id', [110, 111, 113]);
                },
            ])
            ->find($user_id);
            $nombreCommandes = count($client->commandes);
            //dd($client->toArray());
        }
        else{
            $user_id = auth()->user()->id;
            $client = null;
            $nombreCommandes = User::with([
                'commandes' => function($q){
                    $q->whereIn('etat_id', [110, 111, 113]);
                },
            ])
            ->find($user_id);
            $nombreCommandes = count($nombreCommandes->commandes);
        }
        // Listing des modes de paiement
        $retVal = ($nombreCommandes == 0) ? [350, 351] : [351, 352] ;
        $moyenPaiement = Categorie::where([
            'taxonomie_id' => 35,
        ])
        ->whereIn('id', $retVal)
        ->orderBy('id', 'asc')
        ->get();
        //dd($moyenPaiement->toArray());


        $quantite_produit = Cart::instance('shopping')->count();
        $cout_commande = Cart::instance('shopping')->subtotal();
        $cout_livraison = coutLivraison($cout_commande);
        $total_commande = $cout_commande + $cout_livraison;

        $fraisPaiement = ceil($total_commande * 0.03) + 100;
        $fraisPaiement = ceil($fraisPaiement * 0.03) + $fraisPaiement + 10;
        $commandeAvecFraisPaiement = $fraisPaiement + $total_commande;

        // En cas d'annulation de paiement
        if (request('annulation') == 'paiement') {
            //flash('Paiement annulé')->error();
            $ids = $commande->mode_paiements()
            ->where('token', request('token'))
            ->update([
                'valide' => 2
            ]);
            //->first();
            //dd($ids->pivot->toArray());
            //$ids->pivot->valide = 2;
            //$ids->pivot->save();
            Alert::warning('Paiement', 'Paiement annulé');
            //dd(DB::getQueryLog());
        }
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout mode-de-paiement');
        // End journalisation
        return view('web.cart.mode-de-paiement')->with([
            'fraisPaiement' => $fraisPaiement,
            'commandeAvecFraisPaiement' => $commandeAvecFraisPaiement,
            'nombreCommandes' => $nombreCommandes,
            'moyenPaiement' => $moyenPaiement,
            'client' => $client,
            'parametre' => $parametre,
            'resultDate' => $resultDate,
            'infosPage' => array(
                'title' => 'Mode de paiement',
                'slug' => 'mode-de-paiement',
            ),
        ]);
    }

    // Redirection après choix du mode de paiement
    function moyenPaiement(Request $request)
    {
        $this->validate($request,[
            'mode' => 'required|integer',
        ]);
        $mode = request('mode');
        //$cookieMode = Cookie::make('modePaiement', $mode, dureeCookie());
        $commande = detailCommande('reference', Cookie::get('invATR'));
        if ($mode == 351) {
            /* \Paydunya\Setup::setMasterKey("gp0eHJIe-iUS3-JHJS-QR7m-Etf7oOIQczm2");
            \Paydunya\Setup::setPublicKey("live_public_XB7b9jFVl2VnbaWM93JepctHd6I");
            \Paydunya\Setup::setPrivateKey("live_private_yUQABej2UNR2nvrsIYSrDpKe2q2");
            \Paydunya\Setup::setToken("Bv0nVZo7ty7WyadnGj6l");
            \Paydunya\Setup::setMode("live"); */

            \Paydunya\Setup::setMasterKey("p8n1mYJy-RPaj-Iy2S-g2QG-h3EKLUnhXEai");
            \Paydunya\Setup::setPublicKey("live_public_HvjtIK3Upy87yJHe2t6vTfONyFR");
            \Paydunya\Setup::setPrivateKey("live_private_OGK6mRLe9F5uMbqKd8wzyIlMxQY");
            \Paydunya\Setup::setToken("jP5qkNMWDLuPaDNkGQiY");
            \Paydunya\Setup::setMode("live");

            //Configuration des informations de votre service/entreprise
            \Paydunya\Checkout\Store::setName("atrê marché"); // Seul le nom est requis
            \Paydunya\Checkout\Store::setTagline("Votre marché chez vous");
            \Paydunya\Checkout\Store::setPhoneNumber("+225 07 09 09 65 51");
            \Paydunya\Checkout\Store::setPostalAddress("Abidjan, Cocody riviéra 2");
            \Paydunya\Checkout\Store::setWebsiteUrl(url('/'));
            \Paydunya\Checkout\Store::setLogoUrl('https://atre.ci/img/logo2.png');

            \Paydunya\Checkout\Store::setCallbackUrl(url('payment'));
            \Paydunya\Checkout\Store::setCancelUrl(url('mode-de-paiement?annulation=paiement'));
            \Paydunya\Checkout\Store::setReturnUrl(url('status-payment'));
            $invoice = new \Paydunya\Checkout\CheckoutInvoice();
            foreach (Cart::instance('shopping')->content() as $item){
                $post = detailPanier($item->id);
                $invoice->addItem($post->libelle, $item->qty, $post->prix_nouveau, ($item->qty * $post->prix_nouveau), '');
            }

            $quantite_produit = Cart::instance('shopping')->count();
            $cout_commande = Cart::instance('shopping')->subtotal();
            $cout_livraison = coutLivraison($cout_commande);
            $total_commande = $cout_commande + $cout_livraison;
            $user_id = (auth()->user()) ? auth()->user()->id : null;

            if (isset($_POST['payer5000'])) {
                $acompte = 5000;
                $fraisPaiement = ceil($acompte * 0.03) + 100;
                $fraisPaiement = ceil($fraisPaiement * 0.03) + $fraisPaiement + 8;
                $commandeAvecFraisPaiement = $acompte + $fraisPaiement;

                //$invoice->addTax("Coût total de la commande", $totalCommande + $fraisPaiement);
                //$invoice->addTax("Acompte", $commandeAvecFraisPaiement);
                $invoice->setDescription("Paiement d'un acompte de 5000 FCFA pour tous nouveaux clients");
                $invoice->addTax("Frais Paydunya", $fraisPaiement);
                $invoice->setTotalAmount($commandeAvecFraisPaiement);
                $invoice->addTax("Reste à payer", $total_commande - $acompte);
                $cout_versement = $acompte;
            }
            else {
                $fraisPaiement = ceil($total_commande * 0.03) + 100;
                $fraisPaiement = ceil($fraisPaiement * 0.03) + $fraisPaiement + 10;
                $commandeAvecFraisPaiement = $fraisPaiement + $total_commande;

                $invoice->addTax("Sous Total", $total_commande);
                $invoice->addTax("Frais de livrason", $cout_livraison);
                $invoice->addTax("Frais Paydunya", $fraisPaiement);
                $invoice->setDescription('Commande de produits vivriers');
                $invoice->setTotalAmount($commandeAvecFraisPaiement);
                $cout_versement = $total_commande;
            }
            $invoice->addCustomData("invATR", Cookie::get('invATR'));
            //$cookieFrais = Cookie::make('fraisPaiement', $fraisPaiement, dureeCookie());
            if($invoice->create()) {
                foreach (Cart::instance('shopping')->content() as $item){
                    $post = detailPanier($item->id);
                    $commande->produits()->detach($post->id, [
                        'cout' => $post->prix_nouveau,
                        'quantite' => $item->qty,
                        //'options' => null, //pas gérer
                    ]);
                    $commande->produits()->attach($post->id, [
                        'cout' => $post->prix_nouveau,
                        'quantite' => $item->qty,
                        //'options' => null, //pas gérer
                    ]);
                }
                $paiementArray = array(
                    'status' => $invoice->getStatus(),
                    'name' => null,
                    'email' => null,
                    'phone' => null,
                    'pdf' => $invoice->getReceiptUrl(),
                    'response_code' => $invoice->response_code,
                    'response_text' => $invoice->response_text,
                    'token' => $invoice->token,
                    'transaction_id' => $invoice->transaction_id,
                );
                $commande->token = $invoice->token;
                $commande->save();
                $commande->mode_paiements()->attach($mode, [
                    'cout' => $cout_versement,
                    'frais' => $fraisPaiement,
                    'total' => $commandeAvecFraisPaiement,
                    'type' => 'paiement',
                    'token' => $invoice->token,
                    'valide' => 0,
                    'user_id' => auth()->user()->id,
                    'paiement' => json_encode($paiementArray),
                ]);

                // Vérifier qui'il n'y ai pas de plusieurs choix de versement identiques
                $ids = $commande->mode_paiements()
                ->where('type', 'choix')
                ->get();
                //dd($ids);
                if (count($ids) == 0) {
                    $commande->mode_paiements()->attach($mode, [
                        'type' => 'choix',
                        'user_id' => auth()->user()->id,
                    ]);
                }
                return redirect($invoice->getInvoiceUrl());
            }
            else{
                echo $invoice->response_text;
            }
            //flash('Ajout effectué avec succès')->success();
            //return redirect('heure-de-livraison')->cookie($cookie);
        }
        else {
            //flash('Ajout effectué avec succès')->success();
            $commande->mode_paiement_id = $mode;
            $commande->save();
            return redirect('confirmation');
        }
    }

    // Page du résumé de la commande
    function confirmation()
    {
        if (!count(Cart::instance('shopping')->content())){
            return redirect('panier');
        }
        $commande = detailCommande('reference', Cookie::get('invATR'));
        //dd($commande->toArray());
        if (!$commande->adresse_id){
            return redirect('adresse-de-livraison');
        }
        if (!$commande->date_livraison){
            return redirect('date-de-livraison');
        }
        if (!$commande->heure_id){
            return redirect('heure-de-livraison');
        }
        if (!$commande->mode_paiement_id){
            return redirect('mode-de-paiement)');
        }
        if ($commande->date_livraison <= Carbon::today()){
            return redirect('date-de-livraison');
        }
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout confirmation');
        // End journalisation
        return view('web.cart.confirmation')->with([
            'commande' => $commande,
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Résumé de la commande',
                'slug' => 'confirmation',
            ),
        ]);

    }

    function validation(Request $request)
    {
        $commande = Commande::with([
            'produits',
            'user',
            'adresse',
            'livraison_mode',
            'etat',
            'source',
            'heure',
            'mode_paiement',
            'mode_paiements',
            'commercial',
        ])
        ->where('reference', Cookie::get('invATR'))
        ->first();
        //dd($commande->toArray());
        foreach (Cart::instance('shopping')->content() as $item){
            $post = detailPanier($item->id);
            $commande->produits()->detach($post->id, [
                'cout' => $post->prix_nouveau,
                'quantite' => $item->qty,
                //'options' => null, //pas gérer
            ]);
            $commande->produits()->attach($post->id, [
                'cout' => $post->prix_nouveau,
                'quantite' => $item->qty,
                //'options' => null, //pas gérer
            ]);
        }

        if ($commande->mode_paiement_id == 350) {
            $commande->etat_id = 356;
            $commande->created_at = Carbon::now();
            $commande->save();
        }
        else {
            $commande->etat_id = 111;
            $commande->created_at = Carbon::now();
            $commande->save();
        }

        // Vérifier qui'il n'y ai pas de plusieurs choix de versement identiques
        $ids = $commande->mode_paiements()
        ->where('type', 'choix')
        ->get();
        //dd($ids);
        if (count($ids) == 0) {
            $commande->mode_paiements()->attach($commande->mode_paiement_id, [
                'type' => 'choix',
                'user_id' => auth()->user()->id,
            ]);
        }

        Alert::success('Paiement', 'Bravo '.auth()->user()->prenom.' '.auth()->user()->nom.', votre commande a été validée !!!');
        // Notifier l'adminitrateur
        foreach (['developpeur@qenium.com', 'info@atre.ci'] as $recipient) {
            Mail::to($recipient)->send(new CommandeMail($commande, 'administrateur'));
        }
        // Notifier le client
        Mail::to(auth()->user()->email)->send(new CommandeMail($commande, 'client'));
        Cart::instance('shopping')->destroy();
        $cookie = Cookie::forget('invATR');
        return redirect('felicitation/'.$commande->reference)->cookie($cookie);
    }

    public function statusPayment()
    {
        /* \Paydunya\Setup::setMasterKey("gp0eHJIe-iUS3-JHJS-QR7m-Etf7oOIQczm2");
        \Paydunya\Setup::setPublicKey("live_public_XB7b9jFVl2VnbaWM93JepctHd6I");
        \Paydunya\Setup::setPrivateKey("live_private_yUQABej2UNR2nvrsIYSrDpKe2q2");
        \Paydunya\Setup::setToken("Bv0nVZo7ty7WyadnGj6l");
        \Paydunya\Setup::setMode("live"); */
        \Paydunya\Setup::setMasterKey("p8n1mYJy-RPaj-Iy2S-g2QG-h3EKLUnhXEai");
        \Paydunya\Setup::setPublicKey("live_public_HvjtIK3Upy87yJHe2t6vTfONyFR");
        \Paydunya\Setup::setPrivateKey("live_private_OGK6mRLe9F5uMbqKd8wzyIlMxQY");
        \Paydunya\Setup::setToken("jP5qkNMWDLuPaDNkGQiY");
        \Paydunya\Setup::setMode("live");

        //Configuration des informations de votre service/entreprise
        \Paydunya\Checkout\Store::setName("atrê marché"); // Seul le nom est requis
        \Paydunya\Checkout\Store::setTagline("Votre marché chez vous");
        \Paydunya\Checkout\Store::setPhoneNumber("+225 07 09 09 65 51");
        \Paydunya\Checkout\Store::setPostalAddress("Abidjan, Cocody riviéra 2");
        \Paydunya\Checkout\Store::setWebsiteUrl(url('/'));
        \Paydunya\Checkout\Store::setLogoUrl('https://atre.ci/img/logo2.png');

        \Paydunya\Checkout\Store::setCallbackUrl(url('payment'));
        \Paydunya\Checkout\Store::setCancelUrl(url('mode-de-paiement?annulation=paiement'));
        \Paydunya\Checkout\Store::setReturnUrl(url('status-payment'));

        $invoice = new \Paydunya\Checkout\CheckoutInvoice();
        //dd($invoice);
        $token = request('token');
        $commande = Commande::with([
            'produits', 'user', 'adresse', 'livraison_mode', 'etat', 'source', 'heure', 'mode_paiements', 'commercial'
        ])
        ->where([
            'token' => $token,
        ])
        ->first();
        //dd($commande->toArray());
        if ($invoice->confirm($token)) {
            //dd($invoice);
            if($invoice->getStatus() == 'completed'){
                $commande->etat_id = 111;
                $commande->created_at = Carbon::now();
                $commande->save();

                $paiementArray = array(
                    'status' => $invoice->getStatus(),
                    'name' => $invoice->getCustomerInfo('name'),
                    'email' => $invoice->getCustomerInfo('email'),
                    'phone' => $invoice->getCustomerInfo('phone'),
                    'pdf' => $invoice->getReceiptUrl(),
                    'response_code' => $invoice->response_code,
                    'response_text' => $invoice->response_text,
                    'token' => $token,
                    'transaction_id' => $invoice->transaction_id,
                );
                $commande->mode_paiements()
                ->where('token', request('token'))
                ->update([
                    'valide' => 1,
                    'paiement' => $paiementArray,
                ]);

                Alert::success('Paiement', 'Bravo '.auth()->user()->prenom.' '.auth()->user()->nom.', votre commande a été validée !!!');

                // Notifier l'adminitrateur
                foreach (['developpeur@qenium.com', 'info@atre.ci'] as $recipient) {
                    Mail::to($recipient)->send(new CommandeMail($commande, 'administrateur'));
                }
                // Notifier le client
                Mail::to(auth()->user()->email)->send(new CommandeMail($commande, 'client'));
                Cart::instance('shopping')->destroy();
                $cookie = Cookie::forget('invATR');
                return redirect('felicitation/'.$commande->reference)->cookie($cookie);
            }
        }
        else{
            $commande->mode_paiements()
            ->where('token', request('token'))
            ->update([
                'valide' => 3
            ]);
            $invoice->getStatus();
            $invoice->response_text;
            $invoice->response_code;
            //flash('Echec du paiement')->warning();
            Alert::warning('Paiement', 'Echec du paiement');
            return redirect('mode-de-paiement');
        }
    }

    // Page de choix du mode de paiement
    function felicitation($reference)
    {
        $commande = Commande::with([
            //'produits',
            //'user',
            //'adresse',
            //'livraison_mode',
            'etat',
            //'source',
            'heure',
            'mode_paiements',
            'mode_paiement',
            //'commercial',
        ])
        ->where([
            'reference' => $reference,
        ])
        ->when(auth()->user(), function($q){
            return $q->where([
                'user_id' => auth()->user()->id,
            ])
            ->orWhere([
                'commercial_id' => auth()->user()->id,
            ]);
        })
        ->first();
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout felicitation');
        // End journalisation
        return view('web.cart.felicitation')->with([
            'commande' => $commande,
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Commande validée',
                'slug' => 'felicitation',
            ),
        ]);
    }
}
