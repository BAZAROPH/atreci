<?php

namespace App\Http\Controllers;

use App\Post;
use App\Categorie;
use App\Taxonomie;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Filesystem\Filesystem;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use DB;
use Image;
use Hashids\Hashids;
use Validator;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        if (!auth()->user()->hasPermissionTo('-r '.$slug.' index')) {
            // Journalisation
            activity()
            ->log('-r '.$slug.' index 403');
            // End journalisation
            abort(403);
        }
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
            'champs',
            'apparences'
        ])
        ->where([
            'slug' => $slug,
            'taxonomie_id' => 1,
        ])
        /* ->whereHas('taxonomie', function ($q) {
            $q->where([
                'type_taxonomie_id' => 1,
            ]);
        }) */
        ->firstOrFail();

        if (request('status') == 'trashed'){
            $posts = Post::whereHas('categories', function ($q) use($slug) {
                $q->where([
                    'slug' => $slug,
                ]);
            })
            ->get();

            $trashed = Post::with([
                'categories',
                'user',
            ])
            ->whereHas('categories', function ($q) use($slug) {
                $q->where([
                    'slug' => $slug,
                ]);
            })
            ->orderBy('id', 'desc')
            ->onlyTrashed()
            ->get();
        }
        else{
            $posts = Post::with([
                'categories',
                'user',
                'commandes'  => function($q){
                    $q->whereHas('etat', function ($q) {
                        $q->where([
                            'id' => 110,
                        ]);
                    });
                }
            ])
            ->whereHas('categories', function ($q) use($slug) {
                $q->where([
                    'slug' => $slug,
                ]);
            })
            ->orderBy('id', 'desc')
            ->get();

            $trashed = Post::onlyTrashed()
            ->get();
        }
        //dd($posts->toArray());

        // Journalisation
        activity()
            ->log('posts-'.$slug.' index');
        // End journalisation

        return view('celestadmin.post.index')->with([
            'trashed' => $trashed,
            'categorie' => $categorie,
            'valeurs' => $posts,
            'infosPage' => array(
                'title' => $categorie->libelle,
                'slug' => 'p/'.$slug,
                'url' => $slug,
                'icon' => $categorie->icon,
                'element' => $categorie->libelle,
                'can' => '-r ',
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        if (!auth()->user()->hasPermissionTo('-r '.$slug.' create')) {
            // Journalisation
            activity()
            ->log('-r '.$slug.' create 403');
            // End journalisation
            abort(403);
        }
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
                ])
                ->orderBy('categories_champs.rang', 'asc');
            },
            'parent'
        ])
        ->where([
            'slug' => $slug,
            'taxonomie_id' => 1,
            'corbeille' => 1
        ])
        ->firstOrFail();

        $posts = Post::with([
            'categories',
            'user',
        ])
        ->where([
            'corbeille' => 1,
        ])
        ->whereHas('categories', function ($q) use($slug) {
            $q->where([
                'slug' => $slug,
            ]);
        })
        ->orderBy('libelle', 'asc')
        ->get();
        //dd($categorie->toArray());

        // Journalisation
        activity()
            ->log('posts-'.$slug.' create form');
        // End journalisation
        return view('celestadmin.post.create')->with([
            'categorie' => $categorie,
            'valeurs' => $posts,
            'infosPage' => array(
                'title' => $categorie->libelle,
                'slug' => 'p/'.$slug,
                'icon' => $categorie->icon,
                'element' => $categorie->libelle,
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        if (!auth()->user()->hasPermissionTo('-r '.$slug.' create')) {
            // Journalisation
            activity()
            ->log('-r '.$slug.' create 403');
            // End journalisation
            abort(403);
        }
        //set_time_limit(0);
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
            'parent'
        ])
        ->where([
            'slug' => $slug,
            'taxonomie_id' => 1,
            //'corbeille' => 1
        ])
        ->firstOrFail();

        foreach ($categorie->champs as $champ) {
            if ($champ->pivot->obligatoire == 1 and $champ->type_champ->libelle != 'checkbox' and $champ->type_champ->libelle != 'file') {
                $this->validate($request,[
                    $champ->libelle => 'required',
                ]);
            }
        }

        /* if(empty(request('date_planification'))){
            $date_planification = null;
        }
        else{
            $date_planification = Carbon::parse(request('date_planification'));
            $date_planification = $date_planification->format('Y-m-d');
        } */
        $date_planification = conversion_date('date_planification');
        $date = conversion_date('date');
        $date_debut = conversion_date('date_debut');
        $date_fin = conversion_date('date_fin');
        $antidater = conversion_date('antidater');
        $post = Post::create([
            //'reference' => $id,
            //'reference' => str_pad(Auth::user->id, 8, "0", STR_PAD_LEFT),
            'libelle' => request('libelle'),
            'sous_titre' => request('sous_titre'),
            'description' => request('description'),
            'resume' => request('resume'),
            'caracteristique' => request('caracteristique'),
            'lien' => request('lien'),
            'fonction' => request('fonction'),
            'localisation' => request('localisation'),
            'prix_nouveau' => request('prix_nouveau'),
            'prix_ancien' => request('prix_ancien'),
            'poids' => request('poids'),
            'x_produit' => request('x_produit'),
            'x_utilisation' => request('x_utilisation'),
            'icon' => request('icon'),
            'date_debut' => request('date_debut'),
            'date_fin' => request('date_fin'),
            'nom' => request('nom'),
            'prenom' => request('prenom'),
            'telephone' => request('telephone'),
            'email' => request('email'),
            'surface' => request('surface'),
            'piece' => request('piece'),
            'salle_bain' => request('salle_bain'),
            'etage' => request('etage'),
            'annee' => request('annee'),
            'kilometrage' => request('kilometrage'),
            'x_place' => request('x_place'),
            'date_planification' => $date_planification,
            'date' => $date,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'antidater' => $antidater,
            'user_id' => auth()->id(),
            'date_action' => request('date_action'),
            'quantite' => request('quantite'),
            'variete' => request('variete'),
            'technique' => request('technique'),
            'intrant' => request('intrant'),
            'certification' => request('certification'),
            'fournisseur_id' => request('fournisseur_id'),
        ]);
        $hashids = new Hashids('', 12);
        $reference = $hashids->encode($post->id); // VolejRejNmUt
        $post->reference = $reference;
        $post->save();
        //dd($post->toArray());
        foreach ($request->input('document', []) as $file) {
            $post->addMedia(storage_path('app/public/'.$file))->toMediaCollection('image', 'public');
        }

        $post->categories()->attach($categorie->id,[
            'user_id' => auth()->id(),
            'type' => 'rubrique',
        ]);

        foreach ($categorie->champs as $champ) {
            switch ($champ->type_champ->libelle) {
                case 'fileWeb':
                    $field = request($champ->libelle);
                    if ($field) {
                        $taxonomie = Taxonomie::where('libelle', $champ->libelle)->first();
                        $fileWeb = Categorie::create([
                            'libelle' => $field,
                            'lien' => request('lien'),
                            'taxonomie_id' => $taxonomie->id,
                            'user_id' => auth()->id(),
                        ]);
                        //dd($fileWeb->toArray());
                        $post->categories()->attach($fileWeb->id, [
                            'user_id' => auth()->id(),
                            'type' => $champ->libelle,
                        ]);
                    }
                    break;
                case 'select':
                    $field = request($champ->libelle);
                    if ($field != 'fournisseur') {
                        if(!empty($field)){
                            $post->categories()->attach($field,[
                                'user_id' => auth()->id(),
                                'type' => $champ->libelle,
                            ]);
                        }
                    }
                    break;
                case 'checkbox':
                    $occurences = checkbox($champ->slug);
                    $i = 0;
                    foreach ($occurences as $occurence){
                        $i++;
                        $field = request($champ->libelle.$i);
                        if(!empty($field)){
                            $post->categories()->attach($field,[
                                'user_id' => auth()->id(),
                                'type' => $champ->libelle,
                            ]);
                        }
                    }
                    break;
            }
        }
        //dd($post->toArray());

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $slug)
    {
        if (!auth()->user()->hasPermissionTo('-r '.$slug.' show')) {
            // Journalisation
            activity()
            ->performedOn($post)
            ->log('-r '.$slug.' show 403');
            // End journalisation
            abort(403);
        }
        // Journalisation
        activity()
            ->performedOn($post)
            ->log('show');
        // End journalisation
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, $slug, $id)
    {
        if (!auth()->user()->hasPermissionTo('-r '.$slug.' edit')) {
            // Journalisation
            activity()
            ->performedOn($post)
            ->log('-r '.$slug.' edit 403');
            // End journalisation
            abort(403);
        }
        // Détails du avec ses categories, son user ...
        $post = Post::with([
            'categories',
            'user',
        ])
        ->get()
        ->find($id);
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
                ])
                ->orderBy('categories_champs.rang', 'asc');
            },
            'parent'
        ])
        ->where([
            'slug' => $slug,
            'taxonomie_id' => 1,
            'corbeille' => 1
        ])
        ->firstOrFail();

        $posts = Post::with([
            'categories',
            'user',
        ])
        ->where([
            'corbeille' => 1,
        ])
        ->whereHas('categories', function ($q) use($slug) {
            $q->where([
                'slug' => $slug,
            ]);
        })
        ->orderBy('libelle', 'asc')
        ->get();
        //dd($post->toArray());

        // Journalisation
        activity()
            ->performedOn($categorie)
            ->log('posts-'.$slug.' edit form');
        // End journalisation
        return view('celestadmin.post.create')->with([
            'categorie' => $categorie,
            'valeurs' => $posts,
            'valeur' => $post,
            'infosPage' => array(
                'title' => $categorie->libelle,
                'slug' => 'p/'.$slug,
                'icon' => $categorie->icon,
                'element' => $categorie->libelle,
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, $slug, $id)
    {
        if (!auth()->user()->hasPermissionTo('-r '.$slug.' edit')) {
            // Journalisation
            activity()
            ->performedOn($post)
            ->log('-r '.$slug.' edit 403');
            // End journalisation
            abort(403);
        }
        //set_time_limit(0);
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
            'parent'
        ])
        ->where([
            'slug' => $slug,
            'taxonomie_id' => 1,
            //'corbeille' => 1
        ])
        ->firstOrFail();

        foreach ($categorie->champs as $champ) {
            if ($champ->pivot->obligatoire == 1 and $champ->type_champ->libelle != 'checkbox' and $champ->type_champ->libelle != 'file') {
                $this->validate($request,[
                    $champ->libelle => 'required',
                ]);
            }
        }

        if(empty(request('date_planification'))){
            $date_planification = null;
        }
        else{
            $date_planification = Carbon::parse(request('date_planification'));
            $date_planification = $date_planification->format('Y-m-d');
        }
        $post = Post::findOrFail($id);
        $post->libelle = request('libelle');
        $post->sous_titre = request('sous_titre');
        $post->description = request('description');
        $post->resume = request('resume');
        $post->caracteristique = request('caracteristique');
        $post->lien = request('lien');
        $post->fonction = request('fonction');
        $post->localisation = request('localisation');
        $post->prix_nouveau = request('prix_nouveau');
        $post->prix_ancien = request('prix_ancien');
        $post->poids = request('poids');
        $post->x_produit = request('x_produit');
        $post->x_utilisation = request('x_utilisation');
        $post->icon = request('icon');
        $post->date_debut = request('date_debut');
        $post->date_fin = request('date_fin');
        $post->nom = request('nom');
        $post->prenom = request('prenom');
        $post->telephone = request('telephone');
        $post->email = request('email');
        $post->surface = request('surface');
        $post->piece = request('piece');
        $post->salle_bain = request('salle_bain');
        $post->etage = request('etage');
        $post->annee = request('annee');
        $post->kilometrage = request('kilometrage');
        $post->x_place = request('x_place');
        $post->date_planification = $date_planification;
        $post->antidater = request('antidater');
        $post->date_action = request('date_action');
        $post->quantite = request('quantite');
        $post->variete = request('variete');
        $post->technique = request('technique');
        $post->intrant = request('intrant');
        $post->certification = request('certification');
        $post->fournisseur_id = request('fournisseur');

        $post->save();
        //dd($post->toArray());
        foreach ($request->input('document', []) as $file) {
            $post->addMedia(storage_path('app/public/'.$file))->toMediaCollection('image', 'public');
        }

        foreach ($categorie->champs as $champ) {
            switch ($champ->type_champ->libelle) {
                case 'fileWeb':
                    $field = request($champ->libelle);
                    $taxonomie = Taxonomie::where('libelle', $champ->libelle)->first();
                    $fileWeb = Categorie::create([
                        'libelle' => $field,
                        'lien' => request('lien'),
                        'taxonomie_id' => $taxonomie->id,
                        'user_id' => auth()->id(),
                    ]);
                    //dd($fileWeb->toArray());
                    $post->categories()->detach($fileWeb->id);
                    $post->categories()->attach($fileWeb->id, [
                        'user_id' => auth()->id(),
                        'type' => $champ->libelle,
                    ]);
                    break;
                case 'select':
                    $field = request($champ->libelle);
                    if ($field != 'fournisseur') {
                        if(!empty($field)){
                            $post->categories()->detach($field);
                            $post->categories()->attach($field,[
                                'user_id' => auth()->id(),
                                'type' => $champ->libelle,
                            ]);
                        }
                    }
                    $arrayName[] = $field;
                    //dd($arrayName);
                    break;
                case 'checkbox':
                    $field = request($champ->libelle);
                    if(!empty($field)){
                        $post->categories()->detach($field);
                        $post->categories()->attach($field,[
                            'user_id' => auth()->id(),
                            'type' => $champ->libelle,
                        ]);
                    }
                    /* $occurences = checkbox($champ->slug);
                    $i = 0;
                    foreach ($occurences as $occurence){
                        $i++;
                        $field = request($champ->libelle.$i);
                        if(!empty($field)){
                            $post->categories()->attach($field,[
                                'user_id' => auth()->id(),
                                'type' => $champ->libelle,
                            ]);
                        }
                    } */
                    break;
            }
        }
        //dd($arrayName);

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, $slug, $id)
    {
        if (request('status') == 'trashed') {
            $post = Post::onlyTrashed()
            ->find($id);
            $post->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $post = Post::findOrFail($id);
            $post->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function corbeille(Post $post, $slug, $id)
    {
        $post = Post::whereHas('categories', function ($q) use($slug) {
            $q->where([
                'slug' => $slug,
            ]);
        })
        ->onlyTrashed();
        //$post->clearMediaCollection();
        $post->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function restaurer(Post $post, $slug, $id)
    {
        if (request('status') == 'trashed') {
            $post = Post::onlyTrashed()
            ->find($id);
            $post->restore();
        }
        else{
            $post = Post::whereHas('categories', function ($q) use($slug) {
                $q->where([
                    'slug' => $slug,
                ]);
            })
            ->onlyTrashed();
            $post->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }

    public function storeMedia(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $name = uniqid('iMQ_').'_'.Str::random(30).'.'.$extension;

        $path = storage_path('app/public/');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        //$img = Image::make($file);
        //$img->insert(public_path('admin/image/watermark.png'), 'bottom-right', 10, 10);
        $file->move($path, $name);
        //$img->save(storage_path('app/public/'.$name));



        // Journalisation
        /* activity()
            ->log('Upload d\'image via dropzone'); */
        // End journalisation

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy_media(Post $post, $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
    }
}
