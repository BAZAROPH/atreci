<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Commande;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Contracts\DataTable;

class CommandeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('celestadmin.commande.datatable');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request('status') == 'trashed'){
            $commandes = Commande::all();

            $trashed = Commande::orderBy('id', 'desc')
            ->with([
                'produits',
                'mode_paiements' => function($q){
                    $q->where([
                        'type' => 'choix',
                    ]);
                }, // Tous les modes de paiement
                'mode_paiement', // Le premier mode de paiement
                'user', //
                'adresse',
                'livraison_mode',
                'etat',
                'source',
                'heure',
                'commercial',
            ])
            ->onlyTrashed()
            ->get();
        }
        else {
            if (!request('reportrange')) {
                $last =  Carbon::now()->format('Y-m-d 23:59:59');
                $fisrt =  Carbon::now()->subDays(29)->format('Y-m-d 00:00:00');
            }
            else{
                $date = request('reportrange');
                $fisrt = substr($date, 0, 10);
                $fisrt = Carbon::createFromDate($fisrt)->format('Y-m-d 00:00:00');
                $last = substr($date, 13, 10);
                $last = Carbon::createFromDate($last)->format('Y-m-d 23:59:59');
                //dd($last);
            }

            //dd($today);
            $commandes = Commande::orderBy('created_at', 'desc')
            ->whereIn('etat_id', [110, 111, 112, 113, 355, 356])
            ->whereBetween('created_at', [$fisrt, $last])
            ->with([
                'produits',
                'mode_paiements' => function($q){
                    $q->where([
                        'type' => 'choix',
                    ]);
                }, // Tous les modes de paiement
                'mode_paiement', // Le premier mode de paiement
                'user', //
                'adresse',
                'livraison_mode',
                'etat',
                'source',
                'heure',
                'commercial',
            ])
            ->get();

            $trashed = Commande::onlyTrashed()
            ->get();
            //dd($commandes->toArray());
        }
        /* if ($request->ajax()) {
            //$data = User::latest()->get();
            return datatables($commandes)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.url('').'" class="edit btn btn-primary btn-sm">Voir</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } */
        //dd($commandes->toArray());

        // Journalisation
        activity()
            ->log('commandes index');
        // End journalisation
        return view('celestadmin.commande.index')->with([
            'trashed' => $trashed,
            'valeurs' => $commandes,
            'commande_periode' => commande_periode($commandes),
            'infosPage' => array(
                'title' => 'Commandes',
                'slug' => 'commandes',
                'icon' => 'icofont-food-basket',
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
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        $commande = Commande::with([
            'produits' => function($q){
                $q->with([
                    'categories' => function ($q){
                        $q->with([
                            'parent' => function($q){
                                $q->with([
                                    'parent'
                                ]);
                            }
                        ]);
                    },
                ]);
            },
            'mode_paiements', // Tous les modes de paiement
            'mode_paiement', // Le premier mode de paiement
            'user', //
            'adresse'  => function($q){
                $q->with([
                    'parent'
                ]);
            },
            'livraison_mode',
            'etat',
            'source',
            'heure',
            'commercial',
        ])
        ->findOrFail($commande->id);

        $parametre = parametre_web();

        $categories = Categorie::with([
            'childrens',
        ])
        ->where([
            'taxonomie_id' => 21,
        ])
        ->whereIn('categories.id', [110, 111, 112, 355, 356],)
        ->orderBy('id', 'desc')
        ->get();

        $dejaVerser = 0;
        foreach ($commande->mode_paiements as $key => $value) {
            if ($value->pivot->type == 'paiement' and $value->pivot->valide == 1) {
                $dejaVerser += $value->pivot->cout;
            }
        }
        $resteAPayer = $commande->total_commande - $dejaVerser;

        //dd($commande->toArray());
        /* if(request('download')){
            // Journalisation
                activity()
                ->performedOn($commande)
                ->log('print');
            // End journalisation
            $pdf = PDF::loadView('celestadmin.commande.show', [
                'valeur' => $commande,
                'parametre' => $parametre,
                'categories' => $categories,
                'dejaVerser' => $dejaVerser,
                'resteAPayer' => $resteAPayer,
                'infosPage' => array(
                    'title' => 'Détails de la Commande "'.$commande->reference.'"',
                    'slug' => 'commandes',
                    'icon' => 'icofont-food-basket',
                    'element' => 'Commandes',
                ),
            ]);
            return $pdf->download('pdfview.pdf');
        } */

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('show');
        // End journalisation
        $activities = Activity::where([
            'subject_type' => 'App\Commande',
            'subject_id' => $commande->id
        ])->get();
        return view('celestadmin.commande.show')->with([
            'activities' => $activities,
            'parametre' => $parametre,
            'categories' => $categories,
            'valeur' => $commande,
            'dejaVerser' => $dejaVerser,
            'resteAPayer' => $resteAPayer,
            'infosPage' => array(
                'title' => 'Détails de la Commande "'.$commande->reference.'"',
                'slug' => 'commandes',
                'icon' => 'icofont-food-basket',
                'element' => 'Commandes',
            ),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function print(Commande $commande, $download)
    {
        $commande = Commande::with([
            'produits',
            'mode_paiements', // Tous les modes de paiement
            'mode_paiement', // Le premier mode de paiement
            'user', //
            'adresse'  => function($q){
                $q->with([
                    'parent'
                ]);
            },
            'livraison_mode',
            'etat',
            'source',
            'heure',
            'commercial',
        ])
        ->findOrFail($commande->id);

        $parametre = parametre_web();

        $categories = Categorie::with([
            'childrens',
        ])
        ->where([
            'taxonomie_id' => 21,
        ])
        ->whereIn('categories.id', [110, 111, 112, 355, 356],)
        ->orderBy('id', 'desc')
        ->get();

        $dejaVerser = 0;
        foreach ($commande->mode_paiements as $key => $value) {
            if ($value->pivot->type == 'paiement' and $value->pivot->valide == 1) {
                $dejaVerser += $value->pivot->cout;
            }
        }
        $resteAPayer = $commande->total_commande - $dejaVerser;

        // Journalisation
            activity()
            ->performedOn($commande)
            ->log('print');
        // End journalisation
        $pdf = PDF::loadView('celestadmin.commande.print', [
            'valeur' => $commande,
            'parametre' => $parametre,
            'categories' => $categories,
            'dejaVerser' => $dejaVerser,
            'resteAPayer' => $resteAPayer,
            'infosPage' => array(
                'title' => 'Détails de la Commande "'.$commande->reference.'"',
                'slug' => 'commandes',
                'icon' => 'icofont-food-basket',
                'element' => 'Commandes',
            ),
        ]);
        return $pdf->download('Commande-'.$commande->reference.'.pdf');

        /* return view('celestadmin.commande.print')->with([
            'parametre' => $parametre,
            'categories' => $categories,
            'valeur' => $commande,
            'dejaVerser' => $dejaVerser,
            'resteAPayer' => $resteAPayer,
            'infosPage' => array(
                'title' => 'Détails de la Commande "'.$commande->reference.'"',
                'slug' => 'commandes',
                'icon' => 'icofont-food-basket',
                'element' => 'Commandes',
            ),
        ]); */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function versementCommande(Request $request, Commande $commande)
    {
        $commande = Commande::with([
            'produits',
            'mode_paiements', // Tous les modes de paiement
            'mode_paiement', // Le premier mode de paiement
            'user', //
            'adresse'  => function($q){
                $q->with([
                    'parent'
                ]);
            },
            'livraison_mode',
            'etat',
            'source',
            'heure',
            'commercial',
        ])
        ->findOrFail($commande->id);

        $dejaVerser = 0;
        foreach ($commande->mode_paiements as $key => $value) {
            if ($value->pivot->type == 'paiement' and $value->pivot->valide == 1) {
                $dejaVerser += $value->pivot->cout;
            }
        }
        $resteAPayer = $commande->total_commande - $dejaVerser;

        $this->validate($request,[
            'etat_id' => 'required',
        ]);

        if ($request->etat_id == 110 or $request->etat_id == 113) {
            $commande->mode_paiements()->attach(352, [
                'cout' => $resteAPayer,
                'total' => $resteAPayer,
                'type' => 'paiement',
                'valide' => 1,
                'user_id' => auth()->user()->id,
            ]);
        }
        $commande->etat_id = $request->etat_id;
        $commande->save();

        flash()->overlay('Changement de statut effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande, $id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();
        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    public function pdfview(Commande $commande, Request $request)
    {
        $commande = Commande::with([
            'produits',
            'mode_paiements', // Tous les modes de paiement
            'mode_paiement', // Le premier mode de paiement
            'user', //
            'adresse'  => function($q){
                $q->with([
                    'parent'
                ]);
            },
            'livraison_mode',
            'etat',
            'source',
            'heure',
            'commercial',
        ])
        ->findOrFail($commande->id);

        $dejaVerser = 0;
        foreach ($commande->mode_paiements as $key => $value) {
            if ($value->pivot->type == 'paiement' and $value->pivot->valide == 1) {
                $dejaVerser += $value->pivot->cout;
            }
        }
        $resteAPayer = $commande->total_commande - $dejaVerser;

        //view()->share('items', $items);
        $categories = Categorie::with([
            'childrens',
        ])
        ->where([
            'taxonomie_id' => 21,
        ])
        ->whereIn('categories.id', [110, 111, 112, 355, 356],)
        ->orderBy('id', 'desc')
        ->get();

        $parametre = parametre_web();
        if(request('download')){
            $pdf = PDF::loadView('celestadmin.commande.pdfview', [
                'valeur' => $commande,
                'parametre' => $parametre,
                'categories' => $categories,
                'dejaVerser' => $dejaVerser,
                'resteAPayer' => $resteAPayer,
                'infosPage' => array(
                    'title' => 'Détails de la Commande "'.$commande->reference.'"',
                    'slug' => 'commandes',
                    'icon' => 'icofont-food-basket',
                    'element' => 'Commandes',
                ),
            ]);
            // Journalisation
                activity()
                ->performedOn($commande)
                ->log('print');
            // End journalisation
            return $pdf->download('pdfview.pdf');
        }
        return view('celestadmin.commande.pdfview')->with([
            'valeur' => $commande,
            'parametre' => $parametre,
            'categories' => $categories,
            'dejaVerser' => $dejaVerser,
            'resteAPayer' => $resteAPayer,
            'infosPage' => array(
                'title' => 'Détails de la Commande "'.$commande->reference.'"',
                'slug' => 'commandes',
                'icon' => 'icofont-food-basket',
                'element' => 'Commandes',
            ),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function panier(Request $request)
    {
        if (request('status') == 'trashed'){
            $commandes = Commande::all();

            $trashed = Commande::orderBy('id', 'desc')
            ->with([
                'produits',
                'mode_paiements', // Tous les modes de paiement
                'mode_paiement', // Le premier mode de paiement
                'user', //
                'adresse',
                'livraison_mode',
                'etat',
                'source',
                'heure',
                'commercial',
            ])
            ->onlyTrashed()
            ->get();
        }
        else {
            if (!request('reportrange')) {
                $last =  Carbon::now()->format('Y-m-d');
                $fisrt =  Carbon::now()->subDays(2)->format('Y-m-d');
            }
            else{
                $date = request('reportrange');
                $fisrt = substr($date, 0, 10);
                $fisrt = Carbon::createFromDate($fisrt)->format('Y-m-d');
                $last = substr($date, 13, 10);
                $last = Carbon::createFromDate($last)->format('Y-m-d');
                //dd($last);
            }

            //dd($today);
            $commandes = Commande::orderBy('created_at', 'desc')
            ->whereIn('etat_id', [355, 356, 357, 361])
            ->whereBetween('created_at', [$fisrt, $last])
            ->with([
                'produits',
                'mode_paiements', // Tous les modes de paiement
                'mode_paiement', // Le premier mode de paiement
                'user', //
                'adresse',
                'livraison_mode',
                'etat',
                'source',
                'heure',
                'commercial',
            ])
            ->get();

            $trashed = Commande::onlyTrashed()
            ->get();
            //dd($commandes->toArray());
        }
        /* if ($request->ajax()) {
            //$data = User::latest()->get();
            return datatables($commandes)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.url('').'" class="edit btn btn-primary btn-sm">Voir</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } */
        //dd($commandes->toArray());

        // Journalisation
        activity()
            ->log('commandes en cours');
        // End journalisation
        return view('celestadmin.commande.panier')->with([
            'trashed' => $trashed,
            'valeurs' => $commandes,
            'commande_periode' => commande_periode($commandes),
            'infosPage' => array(
                'title' => 'Commandes en cours sur atre.ci',
                'slug' => 'commandes',
                'icon' => 'icofont-food-basket',
                'can' => '',
            ),
        ]);
    }
}
