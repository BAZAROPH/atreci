<?php

namespace App\Http\Controllers;

use App\Taxonomie;
use App\TypeTaxonomie;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class TaxonomieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('status') == 'trashed'){
            $taxonomies = Taxonomie::all();

            $trashed = Taxonomie::orderBy('id', 'desc')
            ->with([
                'type_taxonomie',
                'categories'
            ])
            ->onlyTrashed()
            ->get();
        }
        else {
            $taxonomies = Taxonomie::orderBy('id', 'desc')
            ->with([
                'type_taxonomie',
                'categories'
            ])
            ->get();

            $trashed = Taxonomie::onlyTrashed()
            ->get();
        }
        //dd(auth()->user()->getAllPermissions()->toArray());
        //dd($taxonomies->toArray());

    // Journalisation
    activity()
        ->log('taxonomies index');
    // End journalisation

        return view('celestadmin.taxonomie.index')->with([
            'trashed' => $trashed,
            'valeurs' => $taxonomies,
            'infosPage' => array(
                'title' => 'Taxonomies',
                'slug' => 'taxonomies',
                'icon' => 'icofont-fire-alt',
                'can' => '',
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
        $type_taxonomies = TypeTaxonomie::orderBy('libelle', 'desc')->get();
        // Journalisation
        activity()
            ->log('taxonomies create form');
        // End journalisation
        return view('celestadmin.taxonomie.create')->with([
            'type_valeurs' => $type_taxonomies,
            'infosPage' => array(
                'title' => 'Taxonomies',
                'slug' => 'taxonomies',
                'icon' => 'icofont-fire-alt',
                'element' => 'Taxonomie',
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'libelle' => 'required|string|max:255',
            'type_taxonomie_id' => 'required|integer',
        ]);

        $taxonomie = Taxonomie::create([
            'libelle' => request('libelle'),
            'sous_titre' => request('sous_titre'),
            'cout' => request('cout'),
            'description' => request('description'),
            'icon' => request('icon'),
            'type_taxonomie_id' => request('type_taxonomie_id'),
        ]);
        if(request('type_taxonomie_id')){
            create_permission('-t '.$taxonomie->slug);
        }

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Taxonomie  $taxonomie
     * @return \Illuminate\Http\Response
     */
    public function show(Taxonomie $taxonomie)
    {
        //
        // Journalisation
        activity()
            ->performedOn($taxonomie)
            ->log('show');
        // End journalisation

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Taxonomie  $taxonomie
     * @return \Illuminate\Http\Response
     */
    public function edit(Taxonomie $taxonomie, $id)
    {
        $type_taxonomies = TypeTaxonomie::orderBy('libelle', 'desc')->get() ;
        $taxonomie = Taxonomie::findOrFail($id);
        //dd($taxonomie->toArray());

        // Journalisation
        activity()
            ->performedOn($taxonomie)
            ->log('taxonomies edit form');
        // End journalisation

        return view('celestadmin.taxonomie.edit')->with([
            'type_valeurs' => $type_taxonomies,
            'valeur' => $taxonomie,
            'infosPage' => array(
                'title' => 'Modification "'.$taxonomie->libelle.'"',
                'slug' => 'taxonomies',
                'icon' => 'icofont-fire-alt',
                'element' => 'Taxonomies',
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Taxonomie  $taxonomie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Taxonomie $taxonomie, $id)
    {
        $this->validate($request,[
            'libelle' => 'required|string|max:255',
            'type_taxonomie_id' => 'required|integer',
        ]);
        $taxonomie = Taxonomie::findOrFail($id);
        $taxonomie->libelle = request('libelle');
        $taxonomie->sous_titre = request('sous_titre');
        $taxonomie->cout = request('cout');
        $taxonomie->description = request('description');
        $taxonomie->icon = request('icon');
        $taxonomie->type_taxonomie_id = request('type_taxonomie_id');

        $taxonomie->save();

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taxonomie  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taxonomie $taxonomie, $id)
    {
        if (request('status') == 'trashed') {
            $taxonomie = Taxonomie::onlyTrashed()
            ->find($id);
            //
            $permissions = Permission::where('name', 'like', '%-t '.$taxonomie->slug.'%');
            $permissions->forceDelete();
            $taxonomie->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $taxonomie = Taxonomie::findOrFail($id);
            $taxonomie->delete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taxonomie  $taxonomie
     * @return \Illuminate\Http\Response
     */
    public function corbeille(Taxonomie $taxonomie)
    {
        $taxonomie = Taxonomie::onlyTrashed();

        $taxonomies = $taxonomie->get();
        foreach ($taxonomies as $value) {
            $permissions = Permission::where('name', 'like', '%-t '.$value->slug.'%');
            //dd($permissions->toArray());
            $permissions->forceDelete();
        }
        $taxonomie->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Taxonomie  $taxonomie
     * @return \Illuminate\Http\Response
     */
    public function restaurer(Taxonomie $taxonomie, $id)
    {
        if (request('status') == 'trashed') {
            $taxonomie = Taxonomie::onlyTrashed()
            ->find($id);
            $taxonomie->restore();
        }
        else{
            $taxonomie = Taxonomie::onlyTrashed();
            $taxonomie->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }
}
