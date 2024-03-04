<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('status') == 'trashed'){
            $pages = Page::all();

            $trashed = Page::orderBy('id', 'desc')
            ->with([
                'type_apparence',
            ])
            ->onlyTrashed()
            ->get();
        }
        else {
            $pages = Page::orderBy('id', 'desc')
            ->with([
                'type_apparence',
            ])
            ->get();

            $trashed = Page::onlyTrashed()
            ->get();
        }
        //dd($apparences->toArray());

           // Journalisation
            activity()
               ->log('Listing des pages');
          // End journalisation

        return view('celestadmin.apparence.index')->with([
            'trashed' => $trashed,
            'valeurs' => $pages,
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
        //
        // Journalisation
        activity()
            ->log('Formulaire de creation de page');
        // End journalisation

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
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //

         // Journalisation
         activity()
               ->performedOn($page)
               ->log('Détail d\une page ');
         // End journalisation

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
            //
           // Journalisation
                activity()
                ->performedOn($page)
                ->log('Formulaire de modification de page');
            // End journalisation

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page, $id)
    {
        if (request('status') == 'trashed') {
            $page = Page::onlyTrashed()
            ->find($id);
            $page->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $page = Page::findOrFail($id);
            $page->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function corbeille(Page $page)
    {
        $page = Page::onlyTrashed();
        $page->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function restaurer(Page $page, $id)
    {
        if (request('status') == 'trashed') {
            $page = Page::onlyTrashed()
            ->find($id);
            $page->restore();
        }
        else{
            $page = Page::onlyTrashed();
            $page->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }
}
