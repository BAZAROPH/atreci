<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeTaxonomie;
use App\Taxonomie;
class TypeTaxonomieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('status') == 'trashed'){
            $type_taxonomies = TypeTaxonomie::all();

            $trashed = TypeTaxonomie::orderBy('id', 'desc')
            ->with([
                'taxonomies'
            ])
            ->onlyTrashed()
            ->get();
        }
        else{
            $type_taxonomies = TypeTaxonomie::orderBy('id', 'desc')
            ->with([
                'taxonomies'
            ])
            ->get();

            $trashed = TypeTaxonomie::onlyTrashed()
            ->get();
        }
        //dd($type_taxonomies->toArray());

       // Journalisation
       activity()
          ->log('type-taxonomies index');
      // End journalisation

        return view('celestadmin.type-taxonomie.index')->with([
            'trashed' => $trashed,
            'valeurs' => $type_taxonomies,
            'infosPage' => array(
                'title' => 'Type de taxonomies',
                'slug' => 'type-taxonomies',
                'icon' => 'icofont-fountain-pen',
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
        // Journalisation
        activity()
            ->log('type-taxonomies create form');
        // End journalisation

        return view('celestadmin.type-taxonomie.create')->with([
            //'valeurs' => $type_taxonomies,
            'infosPage' => array(
                'title' => 'Ajout de type de taxonomies',
                'slug' => 'type-taxonomies',
                'icon' => 'icofont-fountain-pen',
                'element' => 'Type de taxonomies',
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
            'libelle' => 'required|max:255|unique:type_taxonomies',
        ]);

        TypeTaxonomie::create([
            'libelle' => request('libelle'),
            'description' => request('description'),
            'icon' => request('icon'),
        ]);

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TypeTaxonomie  $typeTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function show(TypeTaxonomie $typeTaxonomie)
    {
        //
        // Journalisation
        activity()
            ->performedOn($typeTaxonomie)
            ->log('show');
        // End journalisation
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TypeTaxonomie  $typeTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeTaxonomie $typeTaxonomie, $id)
    {
        $type_taxonomie = TypeTaxonomie::with('taxonomies')
        ->get()
        ->find($id);
        //dd($type_taxonomie->toArray());

       // Journalisation
        activity()
            ->performedOn($typeTaxonomie)
            ->log('type-taxonomies edit form');
       // End journalisation

        return view('celestadmin.type-taxonomie.edit')->with([
            'valeur' => $type_taxonomie,
            'infosPage' => array(
                'title' => 'Modification "'.$type_taxonomie->libelle.'"',
                'slug' => 'type-taxonomies',
                'icon' => 'icofont-fountain-pen',
                'element' => 'Type de taxonomies',
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TypeTaxonomie  $typeTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeTaxonomie $typeTaxonomie, $id)
    {
        $this->validate($request,[
            'libelle' => 'required|max:255',
        ]);
        $typeTaxonomie = TypeTaxonomie::findOrFail($id);
        $typeTaxonomie->libelle = request('libelle');
        $typeTaxonomie->description = request('description');
        $typeTaxonomie->icon = request('icon');

        $typeTaxonomie->save();

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TypeTaxonomie  $typeTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeTaxonomie $typeTaxonomie, $id)
    {
        if (request('status') == 'trashed') {
            $typeTaxonomie = TypeTaxonomie::onlyTrashed()
            ->find($id);
            $typeTaxonomie->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $typeTaxonomie = TypeTaxonomie::findOrFail($id);
            $typeTaxonomie->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TypeTaxonomie  $typeTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function corbeille(TypeTaxonomie $ty)
    {
        $typeTaxonomie = TypeTaxonomie::onlyTrashed();
        $typeTaxonomie->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\TypeTaxonomie  $typeTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function restaurer(TypeTaxonomie $typeTaxonomie, $id)
    {
        if (request('status') == 'trashed') {
            $typeTaxonomie = TypeTaxonomie::onlyTrashed()
            ->find($id);
            $typeTaxonomie->restore();
        }
        else{
            $typeTaxonomie = TypeTaxonomie::onlyTrashed();
            $typeTaxonomie->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }
}
