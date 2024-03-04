<?php

namespace App\Http\Controllers;

use App\Parametre;
use App\Categorie;
use Illuminate\Http\Request;

class ParametreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('status') == 'trashed'){
            $parametres = Parametre::all();

            $trashed = Parametre::orderBy('id', 'desc')
            ->with([
                'type_website',
            ])
            ->onlyTrashed()
            ->get();
        }
        else {
            $parametres = Parametre::orderBy('id', 'desc')
            ->with([
                'type_website',
            ])
            ->get();

            $trashed = Parametre::onlyTrashed()
            ->get();
        }
        // Journalisation
        activity()
            ->log('parametres index');
        // End journalisation

        //dd($parametres->toArray());
        return view('celestadmin.parametre.index')->with([
            'trashed' => $trashed,
            'valeurs' => $parametres,
            'infosPage' => array(
                'title' => 'Parametres du site',
                'slug' => 'parametres',
                'icon' => 'icofont-ui-settings',
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
        $type = Categorie::where([
            'taxonomie_id' => 31
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        // Journalisation
        activity()
            ->log('parametres create form');
        // End journalisation

        //dd($apparences->toArray());
        return view('celestadmin.parametre.create')->with([
            'type_valeurs' => $type,
            'infosPage' => array(
                'title' => 'Paramètres du site',
                'slug' => 'parametres',
                'icon' => 'icofont-ui-settings',
                'element' => 'Paramètre',
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
            'libelle' => 'required',
            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'url' => 'required',
            'email' => 'required',
            'type_id' => 'required|integer',
            'logo' => 'required|file|max:10240',
            'icon' => 'required|file|max:10240',
        ]);

        $parametre = Parametre::create([
            'libelle' => request('libelle'),
            'title' => request('title'),
            'sous_titre' => request('sous_titre'),
            'description' => request('description'),
            'keywords' => request('keywords'),
            'url' => request('url'),
            'email' => request('email'),
            'type_id' => request('type_id'),
        ]);

        if($request->hasFile('logo')){
            $parametre->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        if($request->hasFile('icon')){
            $parametre->addMediaFromRequest('icon')->toMediaCollection('icon');
        }

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function show(Parametre $parametre)
    {
        // Journalisation
        activity()
            ->performedOn($parametre)
            ->log('show');
        // End journalisation
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function edit(Parametre $parametre, $id)
    {
        $type_website = Categorie::where([
            'taxonomie_id' => 31
        ])
        ->orderBy('libelle', 'asc')
        ->get();

       $parametres = Parametre::orderBy('id', 'desc')
        ->get();
        $parametre = Parametre::findOrFail($id);

        // Journalisation
        activity()
            ->performedOn($parametre)
            ->log('parametres edit form');
        // End journalisation

        return view('celestadmin.parametre.create')->with([
            'type_valeurs' => $type_website,
            'para$parametres' =>$parametres,
            'valeur' => $parametre,
            'infosPage' => array(
                'title' => 'Modification "'.$parametre->libelle.'"',
                'slug' => 'parametres',
                'icon' => 'icofont-brand-designfloat',
                'element' => 'Paramètres du site',
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parametre $parametre, $id)
    {
        $this->validate($request,[
            'libelle' => 'required',
            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'url' => 'required',
            'email' => 'required',
            'type_id' => 'required|integer',
        ]);

        $parametre = Parametre::findOrFail($id);
        $parametre->libelle = request('libelle');
        $parametre->title = request('title');
        $parametre->sous_titre = request('sous_titre');
        $parametre->description = request('description');
        $parametre->keywords = request('keywords');
        $parametre->email = request('email');
        $parametre->url = request('url');
        $parametre->type_id = request('type_id');
        $parametre->save();

        if($request->hasFile('logo'))
        {
            $media = $parametre->getMedia('logo')->first();
            if (!$media) {
                $parametre->addMediaFromRequest('logo')->toMediaCollection('logo');
            }
            else {
                $media->delete();
                $parametre->addMediaFromRequest('logo')->toMediaCollection('logo');
            }
        }

        if($request->hasFile('icon'))
        {
            $media = $parametre->getMedia('icon')->first();
            if (!$media) {
                $parametre->addMediaFromRequest('icon')->toMediaCollection('icon');
            }
            else {
                $media->delete();
                $parametre->addMediaFromRequest('icon')->toMediaCollection('icon');
            }
        }

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parametre $parametre, $id)
    {
        if (request('status') == 'trashed') {
            $parametre = Parametre::onlyTrashed()
            ->find($id);
            $parametre->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $parametre = Parametre::findOrFail($id);
            $parametre->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function corbeille(Parametre $parametre)
    {
        $parametre = Parametre::onlyTrashed();
        $parametre->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function restaurer(Parametre $parametre, $id)
    {
        if (request('status') == 'trashed') {
            $parametre = Parametre::onlyTrashed()
            ->find($id);
            $parametre->restore();
        }
        else{
            $parametre = Parametre::onlyTrashed();
            $parametre->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }
}
