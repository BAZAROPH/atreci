<?php

namespace App\Http\Controllers;

use App\Apparence;
use App\Categorie;
use App\Champ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use Illuminate\Support\Str;

class ApparenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* if (!auth()->user()->hasPermissionTo('apparences index')) {
            // Journalisation
            activity()
            ->log('apparences index 403');
            // End journalisation
            abort(403);
        } */
        /* $permissionsUnique = DB::select("SELECT DISTINCT SUBSTRING_INDEX(`name`, ' ', 1) as name FROM permissions HAVING name NOT IN ('-t', '-r')");
        //dd($permissionsUnique);
        $role = Role::findOrFail(1);
        foreach ($permissionsUnique as $key => $value) {
            Permission::create([
                'name' => $value->name.' index',
            ]);
            $role->givePermissionTo($value->name.' index');
        } */

        /* $permissionsUnique = DB::select("SELECT DISTINCT SUBSTRING_INDEX(`name`, ' ', 2) as name2, SUBSTRING_INDEX(`name`, ' ', 1) as name FROM permissions HAVING name IN ('-t', '-r')");
        //dd($permissionsUnique);
        $role = Role::findOrFail(1);
        foreach ($permissionsUnique as $key => $value) {
            Permission::create([
                'name' => $value->name2.' index',
            ]);
            $role->givePermissionTo($value->name2.' index');
        } */
        if (request('status') == 'trashed'){
            $apparences = Apparence::all();

            $trashed = Apparence::orderBy('id', 'desc')
            ->with([
                'type_apparence',
            ])
            ->onlyTrashed()
            ->get();
        }
        else {
            $apparences = Apparence::orderBy('id', 'desc')
            ->with([
                'type_apparence',
            ])
            ->get();

            $trashed = Apparence::onlyTrashed()
            ->get();
        }
        //dd($apparences->toArray());

        // Journalisation
        activity()
            ->log('apparences index');
        // End journalisation

        return view('celestadmin.apparence.index')->with([
            'trashed' => $trashed,
            'valeurs' => $apparences,
            'infosPage' => array(
                'title' => 'Apparences',
                'slug' => 'apparences',
                'icon' => 'icofont-brand-designfloat',
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
        $type_apparences = Categorie::where([
            'taxonomie_id' => 28
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        $champs = Champ::with([
            'type_champ'
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        $apparences = Apparence::orderBy('id', 'desc')
        ->get();
        //dd($apparences->toArray());

        // Journalisation
        activity()
            ->log('apparences create form');
        // End journalisation

        return view('celestadmin.apparence.create')->with([
            'type_valeurs' => $type_apparences,
            'apparences' => $apparences,
            'champs' => $champs,
            'infosPage' => array(
                'title' => 'Apparence',
                'slug' => 'apparences',
                'icon' => 'icofont-brand-designfloat',
                'element' => 'Apparence',
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
            'libelle' => 'required|max:255',
            'code' => 'required',
        ]);

        $apparence = Apparence::create([
            'libelle' => request('libelle'),
            'debut' => request('debut'),
            'fin' => request('fin'),
            'description' => request('code'),
            'parent_id' => request('parent_id'),
            'type_apparence_id' => request('type_apparence_id'),
            'user_id' => auth()->user()->id,
        ]);

        if($request->hasFile('image'))
        {
            $apparence->addMediaFromRequest('image')
            //->usingFileName($apparence->slug)
            //->withResponsiveImages()
            ->withManipulations([
                'thumb' => ['default' => '1'],
            ])
            ->toMediaCollection('image');

            //$apparence->getMedia('image')->first()->name = $
        }

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Apparence  $apparence
     * @return \Illuminate\Http\Response
     */
    public function show(Apparence $apparence)
    {
        //
        // Journalisation
        activity()
            ->performedOn($apparence)
            ->log('show');
        // End journalisation
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Apparence  $apparence
     * @return \Illuminate\Http\Response
     */
    public function edit(Apparence $apparence, $id)
    {
        $type_apparences = Categorie::where([
            'taxonomie_id' => 28
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        $champs = Champ::with([
            'type_champ'
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        $apparences = Apparence::orderBy('id', 'desc')
        ->get();
        $apparence = Apparence::findOrFail($id);

        //$media = $apparence->getMedia('image');
        //dd($media->toArray());


        // Journalisation
        activity()
            ->performedOn($apparence)
            ->log('apparences edit form');
        // End journalisation

        return view('celestadmin.apparence.edit')->with([
            'type_valeurs' => $type_apparences,
            'apparences' => $apparences,
            'champs' => $champs,
            'valeur' => $apparence,
            'infosPage' => array(
                'title' => 'Modification "'.$apparence->libelle.'"',
                'slug' => 'apparences',
                'icon' => 'icofont-brand-designfloat',
                'element' => 'Apparences',
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Apparence  $apparence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apparence $apparence, $id)
    {
        $this->validate($request,[
            'libelle' => 'required|max:255',
            'code' => 'required',
        ]);
        $apparence = Apparence::findOrFail($id);
        $apparence->libelle = request('libelle');
        $apparence->debut = request('debut');
        $apparence->fin = request('fin');
        $apparence->description = request('code');
        $apparence->type_apparence_id = request('type_apparence_id');
        $apparence->parent_id = request('parent_id');

        $apparence->save();

        if($request->hasFile('image'))
        {
            $media = $apparence->getMedia('image')->first();
            //dd($media->toArray());
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $name = $apparence->slug.'.'.$extension;
            if (!$media) {
                $apparence->addMediaFromRequest('image')
                ->usingFileName($name)
                ->withManipulations([
                    'thumb' => ['default' => '1'],
                ])
                ->toMediaCollection('image');
            }
            else {
                $media->delete();
                $apparence->addMediaFromRequest('image')
                ->withManipulations([
                    'thumb' => ['default' => '1'],
                ])
                ->toMediaCollection('image');
            }
        }

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Apparence  $apparence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apparence $apparence, $id)
    {
        if (request('status') == 'trashed') {
            $apparence = Apparence::onlyTrashed()
            ->find($id);
            $apparence->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $apparence = Apparence::findOrFail($id);
            $apparence->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Apparence  $apparence
     * @return \Illuminate\Http\Response
     */

    public function corbeille(Apparence $apparence)
    {
        $apparence = Apparence::onlyTrashed();
        $apparence->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Apparence  $apparence
     * @return \Illuminate\Http\Response
     */
    public function restaurer(Apparence $apparence, $id)
    {
        if (request('status') == 'trashed') {
            $apparence = Apparence::onlyTrashed()
            ->find($id);
            $apparence->restore();
        }
        else{
            $apparence = Apparence::onlyTrashed();
            $apparence->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }
}
