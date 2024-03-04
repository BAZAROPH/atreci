<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Taxonomie;
use App\Champ;
use App\Apparence;
use Illuminate\Http\Request;

//use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        if (!auth()->user()->hasPermissionTo('-t '.$slug.' index')) {
            // Journalisation
            activity()
            ->log('-t '.$slug.' index 403');
            // End journalisation
            abort(403);
        }
        $taxonomie = Taxonomie::where('slug', $slug)->firstOrFail();
        if (request('status') == 'trashed') {
            $categories = Categorie::where([
                'taxonomie_id' => $taxonomie->id,
            ])
            ->get();

            $trashed = Categorie::with([
                'childrens' => function($q){
                    $q->with([
                        'childrens' => function($q){
                            $q->with('childrens');
                        }]
                    );
                },
                'champs',
                'apparences',
                'parent',
            ])
            ->where([
                'taxonomie_id' => $taxonomie->id,
            ])
            ->orderBy('libelle', 'asc')
            ->onlyTrashed()
            ->get();

        }
        else{
            $categories = Categorie::with([
                'childrens' => function($q){
                    $q->with([
                        'childrens' => function($q){
                            $q->with('childrens');
                        }]
                    );
                },
                'champs',
                'apparences',
                'parent',
            ])
            ->where([
                'taxonomie_id' => $taxonomie->id,
            ])
            ->orderBy('id', 'desc')
            ->get();

            $trashed = Categorie::where([
                'taxonomie_id' => $taxonomie->id,
            ])
            ->onlyTrashed()
            ->get();
        }
        //$media = $categories->getFirstMedia();
        //dd($categories->toArray());

        // Journalisation
        activity()
            ->log('categories-'.$slug.' index');
        // End journalisation

        return view('celestadmin.categorie.index')->with([
            'trashed' => $trashed,
            'taxonomie' => $taxonomie,
            'valeurs' => $categories,
            'infosPage' => array(
                'title' => $taxonomie->sous_titre,
                'slug' => $slug,
                'icon' => $taxonomie->icon,
                'element' => $taxonomie->sous_titre,
                'can' => '-t ',
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
        if (!auth()->user()->hasPermissionTo('-t '.$slug.' create')) {
            // Journalisation
            activity()
            ->log('-t '.$slug.' create 403');
            // End journalisation
            abort(403);
        }
        $taxonomie = Taxonomie::where('slug', $slug)->firstOrFail();
        if($slug == 'ville'){
            $id_taxonomie = 4;
        }
        elseif($slug == 'quartier'){
            $id_taxonomie = 5;
        }
        else {
            $id_taxonomie = $taxonomie->id;
        }
        $categories = Categorie::with([
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
            'taxonomie_id' => $id_taxonomie,
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        $champs = Champ::where([
            'visible' => 1
        ])
        ->orderBy('libelle', 'asc')
        ->with([
            'type_champ',
        ])
        ->get();

        $apparences = Apparence::orderBy('libelle', 'asc')
        ->with([
            'type_apparence',
        ])
        ->get();
        //dd($categories->toArray());

        // Journalisation
        activity()
            ->log('categories-'.$slug.' create form');
        // End journalisation

        return view('celestadmin.categorie.create')->with([
            'taxonomie' => $taxonomie,
            'type_valeurs' => $categories,
            'apparences' => $apparences,
            'champs' => $champs,
            'infosPage' => array(
                'title' => $taxonomie->sous_titre,
                'slug' => $slug,
                'icon' => $taxonomie->icon,
                'element' => $taxonomie->sous_titre,
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
        if (!auth()->user()->hasPermissionTo('-t '.$slug.' create')) {
            // Journalisation
            activity()
            ->log('-t '.$slug.' create 403');
            // End journalisation
            abort(403);
        }
        //dd(request('obligatoire'));
        $taxonomie = Taxonomie::where('slug', $slug)->firstOrFail();
        $this->validate($request,[
            'libelle' => 'required|max:255',
        ]);

        /* $random = Str::random(3);
        $id = IdGenerator::generate(['table' => 'categorie', 'length' => 10, 'prefix' =>date('s')]).$random; */
        $categorie = Categorie::create([
            //'reference' => $id,
            'libelle' => request('libelle'),
            'sous_titre' => request('sous_titre'),
            'description' => request('description'),
            'lien' => request('lien'),
            'requete' => request('requete'),
            'cout' => request('cout'),
            'icon' => request('icon'),
            'indicateur' => request('indicateur'),
            'parent_id' => request('parent_id'),
            'taxonomie_id' => $taxonomie->id,
            'user_id' => auth()->id(),
        ]);

        if($request->hasFile('image'))
        {
            $categorie->addMediaFromRequest('image')
            ->withManipulations([
                'thumb' => ['default' => '1'],
            ])
            ->toMediaCollection('image');
        }

        $champs = Champ::where([
            'visible' => 1
        ])
        ->orderBy('libelle', 'asc')
        ->with([
            'type_champ',
        ])
        ->get();

        for ($i = 1; $i <= count($champs); $i++) {
            $categorie->champs()->attach(request('champs'.$i),[
                'obligatoire' => request('obligatoire'.$i)
            ]);
        }
        if(request('apparences')){
            $categorie->apparences()->sync([
                request('apparences') => ['default' => 1]
            ]);
        }

        if ($slug == 'rubrique') {
            create_permission('-r '.$categorie->slug);
        }/*
        else {
            create_permission('-t '.$categorie->slug);
        } */

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie, $slug)
    {
        if (!auth()->user()->hasPermissionTo('-t '.$slug.' show')) {
            // Journalisation
            activity()
            ->performedOn($categorie)
            ->log('-t '.$slug.' show 403');
            // End journalisation
            abort(403);
        }
        // Journalisation
        activity()
            ->performedOn($categorie)
            ->log('show');
        // End journalisation
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie, $slug, $id)
    {
        if (!auth()->user()->hasPermissionTo('-t '.$slug.' edit')) {
            // Journalisation
            activity()
            ->performedOn($categorie)
            ->log('-t '.$slug.' edit 403');
            // End journalisation
            abort(403);
        }
        // Détails de la catégorie avec ses champs, apparences ...
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
            'parent',
            'apparences',
            'taxonomie',
        ])
        ->get()
        ->find($id);

        $taxonomie = Taxonomie::where('slug', $slug)->firstOrFail();
        if($slug == 'ville'){
            $id_taxonomie = 4;
        }
        elseif($slug == 'quartier'){
            $id_taxonomie = 5;
        }
        else {
            $id_taxonomie = $taxonomie->id;
        }

        $categories = Categorie::with([
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
            'taxonomie_id' => $id_taxonomie,
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        $champs = Champ::where([
            'visible' => 1
        ])
        ->orderBy('libelle', 'asc')
        ->with([
            'type_champ',
        ])
        ->get();

        $apparences = Apparence::orderBy('libelle', 'asc')
        ->with([
            'type_apparence',
        ])
        ->get();
        //$media = $categorie->getFirstMedia();
        //dd($categorie->toArray());

        // Journalisation
        activity()
            ->performedOn($categorie)
            ->log('categories-'.$slug.' edit form');
        // End journalisation

        return view('celestadmin.categorie.create')->with([
            'taxonomie' => $taxonomie,
            'type_valeurs' => $categories,
            'valeur' => $categorie,
            'apparences' => $apparences,
            'champs' => $champs,
            'infosPage' => array(
                'title' => 'Modification "'.$taxonomie->libelle.'"',
                'slug' => $slug,
                'icon' => $taxonomie->icon,
                'element' => $taxonomie->sous_titre,
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorie $categorie, $slug, $id)
    {
        if (!auth()->user()->hasPermissionTo('-t '.$slug.' edit')) {
            // Journalisation
            activity()
            ->performedOn($categorie)
            ->log('-t '.$slug.' edit 403');
            // End journalisation
            abort(403);
        }
        $this->validate($request,[
            'libelle' => 'required|max:255',
        ]);
        $categorie = Categorie::with([
            'champs'
        ])
        ->findOrFail($id);
        $champsDeCategorie = $categorie;
        $categorie->libelle = request('libelle');
        $categorie->sous_titre = request('sous_titre');
        $categorie->description = request('description');
        $categorie->lien = request('lien');
        $categorie->requete = request('requete');
        $categorie->cout = request('cout');
        $categorie->icon = request('icon');
        $categorie->indicateur = request('indicateur');
        $categorie->parent_id = request('parent_id');
        $categorie->save();

        if($request->hasFile('image'))
        {
            $media = $categorie->getMedia('image')->first();
            //dd($media->toArray());
            if (empty($media)) {
                $categorie->addMediaFromRequest('image')
                ->withManipulations([
                    'thumb' => ['default' => '1'],
                ])
                ->toMediaCollection('image');
            }
            else {
                $media->delete();
                $categorie->addMediaFromRequest('image')
                ->withManipulations([
                    'thumb' => ['default' => '1'],
                ])
                ->toMediaCollection('image');
            }
        }

        $champs = Champ::where([
            'visible' => 1
        ])
        ->orderBy('libelle', 'asc')
        ->with([
            'type_champ',
        ])
        ->get();

        for ($i = 1; $i <= count($champs); $i++) {
            $categorie->champs()->detach(request('champs'.$i),[
                'obligatoire' => request('obligatoire'.$i)
            ]);
        }

        //dd($champsDeCategorie->toArray());
        for ($i = 1; $i <= count($champs); $i++) {
            $rang = null;
            foreach ($champsDeCategorie->champs as $key => $value) {
                if ($value->id == request('champs'.$i)) {
                    $rang = $value->pivot->rang;
                }
            }
            $categorie->champs()->attach(request('champs'.$i),[
                'obligatoire' => request('obligatoire'.$i),
                'rang' => $rang,
            ]);
        }

        $categorie->apparences()->sync(request('apparences'));

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        if ($id == 229 or $id == 629 or $id == 2140) {
            return redirect('celestadmin/rubrique/filter/'.$id);
        }
        else {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie, $slug, $id)
    {
        if (request('status') == 'trashed') {
            $categorie = Categorie::onlyTrashed()
            ->find($id);
            $permissions = Permission::where('name', 'like', '%-r '.$categorie->slug.'%')
            ->delete();
            Categorie::onlyTrashed()->forceDelete();
            flash()->overlay('Suppression definitive effectuée avec succès', 'Message')->success();
        }
        else {
            $categorie = Categorie::findOrFail($id);
            $categorie->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function corbeille(Categorie $categorie, $slug, $id)
    {
        $categorie = Categorie::where([
            'taxonomie_id' => $id,
        ])
        ->onlyTrashed();
        foreach ($categorie as $value) {
            $permissions = Permission::where('name', 'like', '%-r '.$value->slug.'%')
            ->delete();
        }
        $categorie->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Resraure the specified resource from storage.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function restaurer(Categorie $categorie, $slug, $id)
    {
        if (request('status') == 'trashed') {
            $categorie = Categorie::onlyTrashed()
            ->find($id);
            //dd($categorie->toArray());
            $categorie->restore();
        }
        else{
            $categorie = Categorie::where([
                'taxonomie_id' => $id,
            ])
            ->onlyTrashed();
            $categorie->restore();
        }

        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function filter(Categorie $categorie, $slug, $id)
    {
        // Détails de la catégorie avec ses champs, apparences ...
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
            'parent',
            'apparences',
            'taxonomie',
        ])
        ->get()
        ->find($id);

        $taxonomie = Taxonomie::where('slug', $slug)->firstOrFail();
        //$media = $categorie->getFirstMedia();
        //dd($categorie->toArray());

        // Journalisation
        activity()
            ->performedOn($categorie)
            ->log('categorie-'.$slug.' filter');
        // End journalisation

        return view('celestadmin.categorie.filter')->with([
            'taxonomie' => $taxonomie,
            'valeur' => $categorie,
            'infosPage' => array(
                'title' => 'Tri des champs de "'.$categorie->libelle.'"',
                'slug' => $slug,
                'icon' => $taxonomie->icon,
                'element' => $taxonomie->sous_titre,
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function filter_update(Request $request, Categorie $categorie, $slug, $id)
    {
        $categorie = Categorie::with([
            'champs',
        ])
        ->get()
        ->find($id);
        //dd($categorie->toArray());


        for ($i = 1; $i <= count($categorie->champs); $i++) {
            $categorie->champs()->updateExistingPivot(
                request('champs'.$i),
                array('rang' => request('rang'.$i)), false
            );
        }
        flash()->overlay('Tri effectué avec succès', 'Message')->success();
        return back();
    }
}
