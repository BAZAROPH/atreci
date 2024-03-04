<?php

namespace App\Http\Controllers;

use App\Champ;
use App\Categorie;
use App\Taxonomie;
use Illuminate\Http\Request;

class ChampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('status') == 'trashed'){
            $champs = Champ::all();
            $trashed = Champ::orderBy('id', 'desc')
            ->with([
                'type_champ',
            ])
            ->onlyTrashed()
            ->get();
        }
        else {
            $champs = Champ::orderBy('id', 'desc')
            ->with([
                'type_champ',
            ])
            ->get();
            $trashed = Champ::onlyTrashed()
            ->get();
        }

        //dd($taxonomies->toArray());

        // Journalisation
        activity()
            ->log('champs index');
        // End journalisation

        return view('celestadmin.champ.index')->with([
            'valeurs' => $champs,
            'trashed' => $trashed,
            'infosPage' => array(
                'title' => 'Champs d\'articles',
                'slug' => 'champs',
                'icon' => 'icofont icofont-law-document',
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
        $type_champs = Categorie::where([
            'taxonomie_id' => 7
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        $taxonomies = Taxonomie::orderBy('id', 'desc')
        ->get();
        //dd($taxonomies->toArray());

        // Journalisation
        activity()
            ->log('champs create form');
        // End journalisation

        return view('celestadmin.champ.create')->with([
            'type_valeurs' => $type_champs,
            'taxonomies' => $taxonomies,
            'infosPage' => array(
                'title' => 'Champs d\'articles',
                'slug' => 'champs',
                'icon' => 'icofont icofont-law-document',
                'element' => 'Champ',
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
            'libelle' => 'required|max:255|unique:champs',
            'titre' => 'required',
            'type_champ_id' => 'required|integer',
        ]);

        Champ::create([
            'libelle' => request('libelle'),
            'titre' => request('titre'),
            'description' => request('description'),
            'icon' => request('icon'),
            'requete' => request('requete'),
            'visible' => request('visible'),
            'type_champ_id' => request('type_champ_id'),
        ]);

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Champ  $champ
     * @return \Illuminate\Http\Response
     */
    public function show(Champ $champ)
    {
        //
        // Journalisation
        activity()
            ->performedOn($champ)
            ->log('show');
        // End journalisation

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Champ  $champ
     * @return \Illuminate\Http\Response
     */
    public function edit(Champ $champ, $id)
    {
        $type_champs = Categorie::where([
            'taxonomie_id' => 7
        ])
        ->orderBy('libelle', 'asc')
        ->get();
        $champ = Champ::findOrFail($id);

        //echo $occurences = PDO::query($champ->requete);
        $taxonomies = Taxonomie::orderBy('id', 'desc')
        ->get();
        //dd($occurences->toArray());

        // Journalisation
        activity()
            ->performedOn($champ)
            ->log('apparences edit form');
        // End journalisation

        return view('celestadmin.champ.edit')->with([
            'type_valeurs' => $type_champs,
            'taxonomies' => $taxonomies,
            'valeur' => $champ,
            'infosPage' => array(
                'title' => 'Modification "'.$champ->libelle.'"',
                'slug' => 'champs',
                'icon' => 'icofont icofont-law-document',
                'element' => 'Champ',
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Champ  $champ
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Champ $champ, $id)
    {
        $this->validate($request,[
            'libelle' => 'required|max:255',
            'titre' => 'required',
            'type_champ_id' => 'required|integer',
        ]);
        $champ = Champ::findOrFail($id);
        $champ->libelle = request('libelle');
        $champ->titre = request('titre');
        $champ->icon = request('icon');
        $champ->requete = request('requete');
        $champ->type_champ_id = request('type_champ_id');

        $champ->save();

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Champ  $champ
     * @return \Illuminate\Http\Response
     */
    public function destroy(Champ $champ, $id)
    {
        if (request('status') == 'trashed') {
            $champ = Champ::onlyTrashed()
            ->find($id);
            $champ->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $champ = Champ::findOrFail($id);
            $champ->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Champ  $champ
     * @return \Illuminate\Http\Response
     */
    public function corbeille(Champ $champ)
    {
        $champ = Champ::onlyTrashed();
        $champ->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Champ  $champ
     * @return \Illuminate\Http\Response
     */
    public function restaurer(Champ $champ, $id)
    {
        if (request('status') == 'trashed') {
            $champ = Champ::onlyTrashed()
            ->find($id);
            $champ->restore();
        }
        else{
            $champ = Champ::onlyTrashed();
            $champ->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }
}
