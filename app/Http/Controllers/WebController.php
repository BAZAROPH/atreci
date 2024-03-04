<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Commande;
use App\Post;
use Illuminate\Http\Request;
use App\User;
use Hashids\Hashids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parametre = parametre_web();
        //dd($produits->toArray());
        // Journalisation
        activity()
            ->log('home');
        // End journalisation
        return view('web.index')->with([
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Faites votre marché en ligne',
                'slug' => '/',
            ),
        ]);
    }
    public function all(){

        $elementDeTri = Categorie::with([
            'parent'
        ])
        ->where([
            'taxonomie_id' => 38,
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        $parametre = parametre_web();
        //dd($produits->toArray());
        // Journalisation
        activity()
            ->log('home');
        // End journalisation
        return view('web.all')->with([
            'elementDeTri' => $elementDeTri,
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Tous les produits',
                'slug' => '/',
            ),
        ]);



    }
    public function advanced_search(){
        $elementDeTri = Categorie::with([
            'parent'
        ])
        ->where([
            'taxonomie_id' => 38,
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        $parametre = parametre_web();
        //dd($produits->toArray());
        // Journalisation
        activity()
            ->log('home');
        // End journalisation
        return view('web.advanced-search')->with([
                'elementDeTri' => $elementDeTri,
                'parametre' => $parametre,
                'infosPage' => array(
                    'title' => 'Recherches avancées',
                    'slug' => '/',
                ),
        ]);

    }
    public function categories(){

        $elementDeTri = Categorie::with([
            'parent'
        ])
        ->where([
            'taxonomie_id' => 38,
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        $parametre = parametre_web();
        //dd($produits->toArray());
        // Journalisation
        activity()
            ->log('home');
        // End journalisation
        return view('web.categories')->with([
                'elementDeTri' => $elementDeTri,
                'parametre' => $parametre,
                'infosPage' => array(
                    'title' => 'Toutes les catégories',
                    'slug' => '/',
                ),
        ]);




    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_produit()
    {
        $parametre = parametre_web();
        // Journalisation
        activity()
            ->log('home');
        // End journalisation
        return view('web.index')->with([
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Tous les produits',
                'slug' => '/',
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Sign with matricule
     *
     * @return \Illuminate\Http\Response
     */
    public function registerMatricule($matricule)
    {
        $user = User::where([
            'matricule' => $matricule,
        ])
        ->first();
        if (!auth()->user()) {
            return view('auth.register')->with([
                'user' => $user,
            ]);
        }
        else {
            flash('Vous êtes déjà inscrit. Vous ne pouvez pas vous inscrire encore')->warning();
            return redirect('profil');
        }
    }

    /**
     * find matricule user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findMatricule(Request $request)
    {
        $this->validate($request,[
            'matricule' => 'required|max:255',
        ]);

        $user = User::with([
            'childrens'
        ])
        ->where([
            'matricule' => request('matricule'),
        ])
        ->first();
        //dd($user->toArray());
        if ($user) {
            if (count($user->childrens) < 5) {
                //flash('Ajout effectué avec succès')->success();
                return redirect('parrain/'.request('matricule'));
            }
            else {
                flash('Ce membre "'.request('matricule').'" a déjà parrainer 5 personnes. Il ne peut plus parrainer. <br> <a href="'.url('register?default=1').'">Cliquez ici pour s\'inscrire sans parrain</a>')->warning();
                return back();
                //strtotime();
            }
        }
        else {
            flash('Ce matricule "'.request('matricule').'" n\'existe pas dans la base de données ')->error();
            return redirect('register');
        }
    }

    public function connaitre()
    {
        return view('web.connaitre')->with([]);
    }

    public function comment()
    {
        return view('web.comment')->with([]);
    }

    public function avantage()
    {
        return view('web.avantage')->with([]);
    }

    public function faq()
    {
        return view('web.faq')->with([]);
    }

    public function boutique()
    {
        return view('web.boutique')->with([]);
    }

    public function service()
    {
        return view('web.service')->with([]);
    }

    public function contact()
    {
        return view('web.contact')->with([]);
    }

    /* public function contactEnvoyer(Request $request)
    {
        $this->validate($request, [
            'libelle' => 'required',
            'email' => 'required|email',
            'description' => 'required',
        ]);
        $article = Article::create([
            'libelle' => request('libelle'),
            'description' => request('description'),
            'email' => request('email'),
            'telephone' => request('telephone'),
            'rubrique_id' => 66,
        ]);
        Mail::to('developpeur@qenium.com')->send(new ContactMail($article));
        flash('Votre message a bien été envoyé')->success();
        return redirect('/contact');
    } */

    /* public function newsletter(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        $article = Article::create([
            'email' => request('email'),
            'rubrique_id' => 142,
        ]);
        Mail::to('developpeur@qenium.com')->send(new ContactMail($article));
        //flash('Votre message a bien été envoyé')->success();
        flash()->overlay('Vous avez souscri au newsletter avec succès', 'Message')->success();
        return back();
    } */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCategorie($slug)
    {
        $categorie = Categorie::with([
            'childrens' => function($q){
                $q->with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens'
                        ]);
                    }]
                );
            },
            'champs' => function($q){
                $q->with([
                    'type_champ'
                ]);
            },
            'parent' => function($q){
                $q->with([
                    'parent'
                ]);
            },
            'apparences',
            'taxonomie',
        ])
        ->where([
            'slug' => $slug,
            //'taxonomie_id' => 1
        ])
        ->firstOrFail();

        $elementDeTri = Categorie::with([
            'parent'
        ])
        ->where([
            'taxonomie_id' => 38,
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        $parametre = parametre_web();
        //dd($elementDeTri->toArray());

        // Journalisation
        activity()
            ->performedOn($categorie)
            ->log('web categories-'.$slug.' show');
        // End journalisation
        if ($categorie->taxonomie_id == 2) {
            return view('web.cart.category-produit')->with([
                'elementDeTri' => $elementDeTri,
                'parametre' => $parametre,
                'categorie' => $categorie,
                'infosPage' => array(
                    'title' => $categorie->libelle,
                    'slug' => $slug,
                ),
            ]);
        }
        else{
            return view('web.category')->with([
                'parametre' => $parametre,
                'categorie' => $categorie,
                'infosPage' => array(
                    'title' => $categorie->libelle,
                    'slug' => $slug,
                ),
            ]);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPost($slug)
    {
        $post = Post::with([
            'categories' => function ($q){
                $q->with([
                    'parent' => function($q){
                        $q->with([
                            'parent'
                        ]);
                    }
                ]);
            },
            'user',
            'fournisseur',
        ])
        ->where([
            'slug' => $slug,
        ])
        ->firstOrFail();

        //dd($post->toArray());

        $rubrique = traitementCategory($post, 'rubrique');
        $categorie = traitementCategory($post, 'categorie');
        $capacite = traitementCategory($post, 'capacite');
        //dd($capacite->toArray());
        $disponibilite = traitementCategory($post, 'disponibilite');
        $gestion_stock = traitementCategory($post, 'gestion_stock');
        $subdivision = traitementCategory($post, 'subdivision');
        $videoWeb = traitementCategory($post, 'videoWeb');
        $parametre = parametre_web();

        //dd($rubrique->toArray());

        // Journalisation
        activity()
            ->performedOn($post)
            ->log('web posts-'.$slug.' show');
        // End journalisation

        if ($rubrique->id == 229) {
            return view('web.cart.detail-produit')->with([
                'rubrique' => $rubrique,
                'categorie' => $categorie,
                'capacite' => $capacite,
                'disponibilite' => $disponibilite,
                'parametre' => $parametre,
                'post' => $post,
                'infosPage' => array(
                    'title' => $post->libelle,
                    'slug' => $slug,
                ),
            ]);
        }
        else {
            return view('web.detail')->with([
                'rubrique' => $rubrique,
                'categorie' => $categorie,
                'capacite' => $capacite,
                'disponibilite' => $disponibilite,
                'parametre' => $parametre,
                'post' => $post,
                'infosPage' => array(
                    'title' => $post->libelle,
                    'slug' => $slug,
                ),
            ]);
        }
    }

    public function findChildrens($id)
    {
        $childrens = Categorie::where([
            'parent_id' => $id,
            //'option_id' => 2
        ])->get();
        //dd($quartier->toArray());
        return response()->json($childrens);
    }



    // Migrer les categories
    public function migration_categorie()
    {
        //phpinfo();
        $db2 = DB::connection("mysql2");
        $old_grande_categorie = $db2->table("grande_categorie")->get();
        //dd($old_grande_categorie->toArray());

        // Ajout de categorie de produit
        foreach ($old_grande_categorie as $key => $value) {
            $valeur = Categorie::where([
                'original_id' => $value->id_grande_categorie,
                'original_table' => 'grande_categorie',
            ])->first();
            //dd($valeur->toArray());
            if (!$valeur) {
                $original = array(
                    'id_grande_categorie' => $value->lib_grande_categorie,
                    'img_grande_categorie' => $value->img_grande_categorie,
                    'creation_grande_categorie' => $value->creation_grande_categorie,
                    'modif_grande_categorie' => $value->modif_grande_categorie,
                    'id_creation_user' => $value->id_creation_user,
                    'id_modif_user' => $value->id_modif_user,
                    'url_grande_categorie' => $value->url_grande_categorie,
                    'id_langue' => $value->id_langue,
                    'id_type_compte' => $value->id_type_compte,
                    'id_megamenu' => $value->id_megamenu,
                );
                $categorie = Categorie::create([
                    'libelle' => $value->lib_grande_categorie,
                    'description' => $value->descrip_grande_categorie,
                    'created_at' => $value->creation_grande_categorie,
                    'updated_at' => $value->modif_grande_categorie,
                    'taxonomie_id' => 2,
                    'user_id' => auth()->id(),
                    'parent_id' => 321,
                    'original' => json_encode($original),
                    'original_id' => $value->id_grande_categorie,
                    'original_table' => 'grande_categorie',
                ]);
                if($value->img_grande_categorie)
                {
                    $client = new \GuzzleHttp\Client();
                    $img_grande_categorie = str_replace(' ', '%20', $value->img_grande_categorie);
                    $img_grande_categorie = 'https://atre.ci/upload/'.$img_grande_categorie;

                    /* $imageName = $categorie->slug;
                    $tempImage = tempnam(sys_get_temp_dir(), 'my_app_');
                    $client->request('GET', $img_grande_categorie, ['sink' => $tempImage]);

                    $categorie->addMedia($tempImage)
                    ->usingName($imageName)
                    ->usingFileName($imageName)
                    ->withManipulations([
                        'thumb' => ['default' => '1'],
                    ])
                    ->toMediaCollection('image'); */

                    $categorie->addMediaFromUrl($img_grande_categorie)
                    ->withManipulations([
                        'thumb' => ['default' => '1'],
                    ])
                    ->toMediaCollection('image');
                }

                $old_categorie = $db2->table("categorie")->where('id_grande_categorie', $value->id_grande_categorie)->get();
                foreach ($old_categorie as $key => $valueCategorie) {
                    $valeur = Categorie::where([
                        'original_id' => $valueCategorie->id_categorie,
                        'original_table' => 'categorie',
                    ])->first();
                    //dd($valeur->toArray());
                    if (!$valeur) {
                        $original = array(
                            'id_categorie' => $valueCategorie->id_categorie,
                            'img_categorie' => $valueCategorie->img_categorie,
                            'creation_categorie' => $valueCategorie->creation_categorie,
                            'modif_categorie' => $valueCategorie->modif_categorie,
                            'id_creation_user' => $valueCategorie->id_creation_user,
                            'id_modif_user' => $valueCategorie->id_modif_user,
                            'url_categorie' => $valueCategorie->url_categorie,
                            'id_grande_categorie' => $valueCategorie->id_grande_categorie,
                            'id_langue' => $valueCategorie->id_langue,
                        );
                        $categorieNiveau1 = Categorie::create([
                            'libelle' => $valueCategorie->lib_categorie,
                            'description' => $valueCategorie->descrip_categorie,
                            'created_at' => $valueCategorie->creation_categorie,
                            'updated_at' => $valueCategorie->modif_categorie,
                            'taxonomie_id' => 2,
                            'user_id' => auth()->id(),
                            'parent_id' => $categorie->id,
                            'original' => json_encode($original),
                            'original_id' => $valueCategorie->id_categorie,
                            'original_table' => 'categorie',
                        ]);
                        if($valueCategorie->img_categorie)
                        {
                            $img_categorie = str_replace(' ', '%20', $valueCategorie->img_categorie);
                            /* $categorieNiveau1->addMediaFromUrl('https://atre.ci/upload/'.$img_categorie)
                            ->withManipulations([
                                'thumb' => ['default' => '1'],
                            ])
                            ->toMediaCollection('image'); */
                        }

                        $old_produit = $db2->table("produit")->where('id_categorie', $valueCategorie->id_categorie)->get();
                        foreach ($old_produit as $key => $valueProduit) {
                            $valeur = Post::where('original_id', $valueProduit->id_produit)->first();
                            //dd($valeur->toArray());
                            if (!$valeur) {
                                $original = array(
                                    'id_produit' => $valueProduit->id_produit,
                                    'reference_produit' => $valueProduit->reference_produit,
                                    'video_produit' => $valueProduit->video_produit,
                                    'creation_produit' => $valueProduit->creation_produit,
                                    'modif_produit' => $valueProduit->modif_produit,
                                    'vue_produit' => $valueProduit->vue_produit,
                                    'url_produit' => $valueProduit->url_produit,
                                    'id_creation_user' => $valueProduit->id_creation_user,
                                    'id_modif_user' => $valueProduit->id_modif_user,
                                    'id_disponibilite' => $valueProduit->id_disponibilite,
                                    'id_grande_categorie' => $valueProduit->id_grande_categorie,
                                    'id_categorie' => $valueProduit->id_categorie,
                                    'id_sous_categorie' => $valueProduit->id_sous_categorie,
                                    'id_langue' => $valueProduit->id_langue,
                                    'rang_produit' => $valueProduit->rang_produit,
                                    'lib_division' => $valueProduit->lib_division,
                                    'lib_capacite' => $valueProduit->lib_capacite,
                                    'pub_produit' => $valueProduit->pub_produit,
                                );
                                $produit = Post::create([
                                    'libelle' => $valueProduit->lib_produit,
                                    'description' => $valueProduit->descrip_produit,
                                    'prix_nouveau' => $valueProduit->prixnouveau_produit,
                                    'prix_ancien' => $valueProduit->prixancien_produit,
                                    'est_nouveau' => $valueProduit->nouveau_produit,
                                    'visibilite' => $valueProduit->visible_produit,
                                    'rang' => $valueProduit->rang_produit,
                                    'poids' => $valueProduit->poids_produit,
                                    'created_at' => $valueProduit->creation_produit,
                                    'updated_at' => $valueProduit->modif_produit,
                                    'user_id' => auth()->id(),
                                    'original' => json_encode($original),
                                    'original_id' => $valueProduit->id_produit,
                                ]);
                                $hashids = new Hashids('', 12);
                                $reference = $hashids->encode($produit->id); // VolejRejNmUt
                                $produit->reference = $reference;
                                $produit->save();
                                $old_photo = $db2->table("photo")->where('id_produit', $valueProduit->id_produit)->get();
                                foreach ($old_photo as $key => $valuePhoto) {
                                    $img_photo = str_replace(' ', '%20', $valuePhoto->lib_photo);
                                    if ($key == 0) {
                                        $produit->addMediaFromUrl('https://atre.ci/upload/'.$img_photo)
                                        ->withManipulations([
                                            'thumb' => ['default' => '1'],
                                        ])
                                        ->toMediaCollection('image');
                                    }
                                    else {
                                        $produit->addMediaFromUrl('https://atre.ci/upload/'.$img_photo)
                                        ->withManipulations([
                                            'thumb',
                                        ])
                                        ->toMediaCollection('image');
                                    }
                                }

                                // Association Rubrique dans ce cas c'est produit donc 229
                                $produit->categories()->attach(229,[
                                    'user_id' => auth()->id(),
                                    'type' => 'rubrique',
                                ]);
                                // Association de grande categorie
                                $produit->categories()->attach($categorie->id,[
                                    'user_id' => auth()->id(),
                                    'type' => 'categorie',
                                ]);
                                // Association de categorie
                                $produit->categories()->attach($categorieNiveau1->id,[
                                    'user_id' => auth()->id(),
                                    'type' => 'categorie',
                                ]);
                                // Association de capacité
                                switch ($valueProduit->lib_capacite) {
                                    case 'Kg':
                                        $produit->categories()->attach(108, [
                                            'user_id' => auth()->id(),
                                            'type' => 'capacite',
                                        ]);
                                        break;
                                    case 'L':
                                        $produit->categories()->attach(107, [
                                            'user_id' => auth()->id(),
                                            'type' => 'capacite',
                                        ]);
                                        break;
                                    case 'Plaquette':
                                        $produit->categories()->attach(434, [
                                            'user_id' => auth()->id(),
                                            'type' => 'capacite',
                                        ]);
                                        break;
                                    case 'Unité':
                                        $produit->categories()->attach(109, [
                                            'user_id' => auth()->id(),
                                            'type' => 'capacite',
                                        ]);
                                        break;
                                    default:
                                        # code...
                                        break;
                                }

                                // Association de subdivision
                                switch ($valueProduit->lib_division) {
                                    case '1':
                                        $produit->categories()->attach(126, [
                                            'user_id' => auth()->id(),
                                            'type' => 'subdivision',
                                        ]);
                                        break;
                                    case '2':
                                        $produit->categories()->attach(127, [
                                            'user_id' => auth()->id(),
                                            'type' => 'subdivision',
                                        ]);
                                        break;
                                    case 'demi':
                                        $produit->categories()->attach(128, [
                                            'user_id' => auth()->id(),
                                            'type' => 'subdivision',
                                        ]);
                                        break;
                                    case 'quart':
                                        $produit->categories()->attach(129, [
                                            'user_id' => auth()->id(),
                                            'type' => 'subdivision',
                                        ]);
                                        break;
                                    default:
                                        # code...
                                        break;
                                }

                                // Association de disponibilité
                                switch ($valueProduit->id_disponibilite) {
                                    case '1':
                                        $produit->categories()->attach(130, [
                                            'user_id' => auth()->id(),
                                            'type' => 'disponibilite',
                                        ]);
                                        break;
                                    case '2':
                                        $produit->categories()->attach(131, [
                                            'user_id' => auth()->id(),
                                            'type' => 'disponibilite',
                                        ]);
                                        break;
                                    case '3':
                                        $produit->categories()->attach(132, [
                                            'user_id' => auth()->id(),
                                            'type' => 'disponibilite',
                                        ]);
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // Migrer les clients
    public function migration_user()
    {
        $db2 = DB::connection("mysql2");
        $old_client = $db2->table("client")->get();
        //var_dump($old_client);
        // Ajout des clients
        foreach ($old_client as $key => $value) {
            $valeur = User::where('original_id', $value->id_client)->get();
            if (count($valeur) == 0) {
                //dd($valeur->toArray());
                $original = array(
                    'id_client' => $value->id_client,
                    'mdp_client' => $value->mdp_client,
                    'nbr_connexion' => $value->nbr_connexion,
                    'last_connexion' => $value->last_connexion,
                    'last_deconnexion' => $value->last_deconnexion,
                    'creation_client' => $value->creation_client,
                    'modif_client' => $value->modif_client,
                    'caracteristique_client' => $value->caracteristique_client,
                    'id_langue' => $value->id_langue,
                    'type_client' => $value->type_client,
                    'id_type_compte' => $value->id_type_compte,
                    'id_source' => $value->id_source,
                );
                $user = User::create([
                    'name' => $value->nom_client,
                    'prenom' => $value->prenom_client,
                    'sexe' => $value->sexe_client,
                    'date_naissance' => $value->naissance_client,
                    'email' => $value->mail_client,
                    'password' => Hash::make($value->caracteristique_client),
                    'valide' => 1,
                    'created_at' => $value->creation_client,
                    'updated_at' => $value->modif_client,
                    'source_id' => ($value->id_source == 1) ? 360 : 354,
                    'parent_id' => ($value->type_client == 'client') ? null : 4,
                    'original' => json_encode($original),
                    'original_id' => $value->id_client,
                ]);
                // Journalisation
                    activity()
                    ->causedByAnonymous()
                    ->performedOn($user)
                    ->log('created');
                // End journalisation
                $user->assignRole('detaillant');

                $old_adresse = $db2->table("adresse")->where('id_client', $value->id_client)->get();
                //dd($old_adresse);
                foreach ($old_adresse as $key => $valueAdresse) {
                    $valeur = Categorie::where([
                        'original_id' => $valueAdresse->id_adresse,
                        'original_table' => 'adresse'
                    ])->first();
                    //dd($valeur);
                    // Ajout des adresses de livraison d'un client
                    if (!$valeur) {
                        $pays = Categorie::where([
                            'original_id' => $valueAdresse->id_pays,
                            //'taxonomie_id' => 4,
                            'original_table' => 'pays'
                        ])->first();
                        //dd($pays);
                        $original = array(
                            'id_adresse' => $valueAdresse->id_adresse,
                            'ville_adresse' => $valueAdresse->ville_adresse,
                            'defaut_adresse' => $valueAdresse->defaut_adresse,
                            'id_pays' => $valueAdresse->id_pays,
                            'id_client' => $valueAdresse->id_client,
                            'creation_adresse' => $valueAdresse->creation_adresse,
                            'modif_adresse' => $valueAdresse->modif_adresse,
                            'id_source' => $valueAdresse->id_source,
                        );
                        $adresse = Categorie::create([
                            'libelle' => $valueAdresse->lib_adresse,
                            'sous_titre' => $valueAdresse->ville_adresse,
                            'lien' => $valueAdresse->tel_adresse,
                            'created_at' => $valueAdresse->creation_adresse,
                            'updated_at' => $valueAdresse->modif_adresse,
                            'user_id' => $user->id,
                            'taxonomie_id' => 33,
                            'parent_id' => $pays->id,
                            'source_id' => ($value->id_source == 1) ? 360 : 354,
                            'original' => json_encode($original),
                            'original_id' => $valueAdresse->id_adresse,
                            'original_table' => 'adresse',
                        ]);
                        // Journalisation
                        activity()
                        ->causedBy($user)
                        ->performedOn($adresse)
                        ->log('created');
                        // End journalisation
                    }
                }

                // Ajout des commandes d'un client
                $old_commande = $db2->table("commande")->where('id_client', $value->id_client)->get();
                foreach ($old_commande as $key => $valueCommande) {
                    $valeur = Commande::where([
                        'original_id' => $valueCommande->id_commande,
                    ])->first();
                    //dd($valeur->toArray());
                    if (!$valeur) {
                        $adresse_commande = Categorie::where([
                            'original_id' => $valueCommande->id_adresse,
                            'original_table' => 'adresse'
                        ])->first();
                        //dd($adresse_commande->toArray());

                        // Determiner état de la commande
                        if ($valueCommande->etat_commande == 'livrée') {
                            $etat = 110;
                        }
                        elseif ($valueCommande->etat_commande == 'annulée') {
                            $etat = 112;
                        }
                        else {
                            $etat = 111;
                        }

                        // Déterminer l'heure de la commande
                        if (!$valueCommande->heure_livraison) {
                            $valueCommande->heure_livraison = "12h-14h";
                        }
                        $heure = Categorie::where([
                            'libelle' => $valueCommande->heure_livraison,
                            'taxonomie_id' => 34,
                        ])->first();
                        //dd($valueCommande);

                        $original = array(
                            'id_commande' => $valueCommande->id_commande,
                            'reference_commande' => $valueCommande->reference_commande,
                            'etat_commande' => $valueCommande->etat_commande,
                            'nbr_produit' => $valueCommande->nbr_produit,
                            'montant_commande' => $valueCommande->montant_commande,
                            'cout_livraison' => $valueCommande->cout_livraison,
                            'totale_commande' => $valueCommande->totale_commande,
                            'id_client' => $valueCommande->id_client,
                            'creation_commande' => $valueCommande->creation_commande,
                            'modif_commande' => $valueCommande->modif_commande,
                            'id_adresse' => $valueCommande->id_adresse,
                            'id_type_livraison' => $valueCommande->id_type_livraison,
                            'id_langue' => $valueCommande->id_langue,
                            'id_agence_livraison' => $valueCommande->id_agence_livraison,
                            'livraison_oui' => $valueCommande->livraison_oui,
                            'date_livraison' => $valueCommande->date_livraison,
                            'heure_livraison' => $valueCommande->heure_livraison,
                            'id_modif_user' => $valueCommande->id_modif_user,
                            'source_commande' => $valueCommande->source_commande,
                            'id_source' => $valueCommande->id_source,
                            'frais_paiement' => $valueCommande->frais_paiement,
                        );
                        $commande = Commande::create([
                            'reference' => 'ATR0'.$valueCommande->reference_commande,
                            'quantite_produit' => $valueCommande->nbr_produit,
                            'cout_commande' => $valueCommande->montant_commande,
                            'cout_livraison' => $valueCommande->cout_livraison,
                            'total_commande' => $valueCommande->totale_commande,
                            'date_livraison' => $valueCommande->date_livraison,
                            'type' => 'produit',
                            'user_id' => $user->id,
                            'adresse_id' => $adresse_commande->id,
                            'livraison_mode_id' => 362,
                            'etat_id' => $etat,
                            'created_at' => $valueCommande->creation_commande,
                            'updated_at' => $valueCommande->modif_commande,
                            'source_id' => ($value->id_source == 1) ? 360 : 354,
                            'heure_id' => $heure->id,
                            'original' => json_encode($original),
                            'original_id' => $valueCommande->id_commande,
                        ]);
                        // Journalisation
                        activity()
                        ->causedBy($user)
                        ->performedOn($commande)
                        ->log('created');
                        // End journalisation

                        // Reccupération des produits d'une commande
                        $produits_commande = $db2
                        ->table("produit")
                        ->join('commande_produit', 'produit.id_produit', '=', 'commande_produit.id_produit')
                        ->where([
                            'id_commande' => $valueCommande->id_commande,
                        ])
                        ->get();
                        /* $produits_commande = Post::where([
                            'original_id' => $valueCommande->produit_id,
                        ])->get(); */
                        foreach ($produits_commande as $key => $post) {
                            $mon_post = Post::where([
                                'original_id' => $post->id_produit,
                            ])->first();
                            //dd($mon_post->toArray());
                            $commande->produits()->attach($mon_post->id, [
                                'cout' => $post->prix_commande_produit,
                                'quantite' => $post->quantite_commande_produit,
                                'created_at' => $post->creation_commande_produit,
                                'updated_at' => $post->modif_commande_produit,
                            ]);
                        }

                        $versements = $db2
                        ->table("versement")
                        ->where([
                            'id_commande' => $valueCommande->id_commande,
                        ])
                        ->get();
                        foreach ($versements as $key => $versement) {
                            // Determiner le mode de paiement de la commande
                            if ($versement->id_paiement == 1) {
                                $paiement_id = 352;
                            }
                            elseif ($versement->id_paiement == 2) {
                                $paiement_id = 351;
                            }
                            else {
                                $paiement_id = 350;
                            }
                            $original = array(
                                'id_versement' => $versement->id_versement,
                                'type_versement' => $versement->type_versement,
                                'id_commande' => $versement->id_commande,
                                'id_paiement' => $versement->id_paiement,
                                'id_creation_user' => $versement->id_creation_user,
                                'id_modif_user' => $versement->id_modif_user,
                                'id_client' => $versement->id_client,
                                'montant_versement' => $versement->montant_versement,
                                'frais_versement' => $versement->frais_versement,
                                'total_versement' => $versement->total_versement,
                                'creation_versement' => $versement->creation_versement,
                                'modif_versement' => $versement->modif_versement,
                                'status_versement' => $versement->status_versement,
                                'name_versement' => $versement->name_versement,
                                'email_versement' => $versement->email_versement,
                                'phone_versement' => $versement->phone_versement,
                                'pdf_versement' => $versement->pdf_versement,
                                'response_code' => $versement->response_code,
                                'response_text' => $versement->response_text,
                                'token_versement' => $versement->token_versement,
                                'valide_versement' => $versement->valide_versement,
                            );
                            $paiementArray = array(
                                'status' => $versement->status_versement,
                                'name' => $versement->name_versement,
                                'email' => $versement->email_versement,
                                'phone' => $versement->phone_versement,
                                'pdf' => $versement->pdf_versement,
                                'response_code' => $versement->response_code,
                                'response_text' => $versement->response_text,
                                'token' => $versement->token_versement,
                                'transaction_id' => null,
                            );
                            $commande->mode_paiements()->attach($paiement_id, [
                                'cout' => $versement->montant_versement,
                                'frais' => $versement->frais_versement,
                                'total' => $versement->total_versement,
                                'type' => $versement->type_versement,
                                'token' => $versement->token_versement,
                                'valide' => $versement->valide_versement,
                                'user_id' => $user->id,
                                'created_at' => $versement->creation_versement,
                                'updated_at' => $versement->modif_versement,
                                'paiement' => json_encode($paiementArray),
                                'original' => json_encode($original),
                                'original_id' => $versement->id_versement,
                            ]);
                        }
                    }
                }
            }
        }
    }

    // Migrer les pays
    public function migration_pays()
    {
        $db2 = DB::connection("mysql2");
        $old_pays = $db2->table("pays")->get();
        //dd($old_pays->toArray());

        // Ajout de categorie de produit
        foreach ($old_pays as $key => $value) {
            $valeur = Categorie::where([
                'original_id' => $value->id_pays,
                'original_table' => 'pays'
            ])->first();
            //dd($value);
            if (!$valeur) {
                $original = array(
                    'id_pays' => $value->id_pays,
                    'code' => $value->code,
                    'alpha2' => $value->alpha2,
                    'alpha3' => $value->alpha3,
                    'nom_en_gb' => $value->nom_en_gb,
                    'nom_fr_fr' => $value->nom_fr_fr,
                );
                $pays = Categorie::create([
                    'libelle' => $value->nom_fr_fr,
                    'sous_titre' => $value->nom_en_gb,
                    'description' => $value->alpha3,
                    'taxonomie_id' => 4,
                    'user_id' => auth()->id(),
                    'original' => json_encode($original),
                    'original_id' => $value->id_pays,
                    'original_table' => 'pays',
                ]);
            }
        }
    }

    // Supprimer migrations ajoutées
    public function migration_delete()
    {
        if (request('migration')) {
            $migration = request('migration');
            switch ($migration) {
                case 'categorie':
                    $valeurs = Categorie::where([
                        'taxonomie_id' => 2
                    ])->whereNotNull('original_id')->get()->each->forceDelete();
                    break;
                case 'pays':
                    $valeurs = Categorie::where([
                        'taxonomie_id' => 4
                    ])->whereNotNull('original_id')->get()->each->forceDelete();
                    break;
                case 'adresse':
                    $valeurs = Categorie::where([
                        'taxonomie_id' => 33
                    ])->whereNotNull('original_id')->get()->each->forceDelete();
                    break;
                case 'produit':
                    $valeurs = Post::whereNotNull('original_id')->get()->each->forceDelete();
                    break;
                case 'user':
                    $valeurs = User::whereNotNull('original_id')->get()->each->forceDelete();
                    break;
                case 'commande':
                    $valeurs = Commande::whereNotNull('original_id')->get()->each->forceDelete();
                    break;

                default:
                    # code...
                    break;
            }
            return 'Suppression effectuée avec succès';
        }
    }
}
