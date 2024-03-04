<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Session;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Récuperation des commandes en attente
        $commandeEnAttentes=Commande::orderBy('created_at','desc')
        ->where('etat_id','=','111')
        ->get();
        //Les commandes livrés today
        $recette = stat_commandes(110, 'montant', array(
            'first' => Carbon::today()->format('Y-m-d'.' 00:00:00'),
            'last' => Carbon::today()->format('Y-m-d'.' 23:59:59'),
        ));

        //Récupération des utilisateurs connectés
        $userConnect = Session::orderBy('last_activity')
        ->where('last_activity', '>', duree_session())
        ->whereNotNull('user_id')
        //->get();
        ->count();

        //Récupération du nombre de client
        $users = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['grossiste','detaillant','fournisseur']);
        })
        ->count();
        //dd($users);

        //Récupération des derniers clients inscrits
        $dernierClientRecInsc = User::orderBy('created_at','desc')->with([
            'roles',
            'permissions',
            'session' => function ($q) {
                $q->where('last_activity', '>=', duree_session());
            },
        ])
        ->withCount('commandes')
        ->whereHas('roles', function ($q) {
            $q->whereIn('name', ['grossiste','detaillant','fournisseur']);
        })
        ->whereBetween('created_at',[Carbon::now()->endOfDay()->subDays(8), Carbon::now()->endOfDay()])
        ->get();

        // //Récupération des clients les plus performants
        $clientPerforms=User::withCount([
            'commandes' => function ($q){
                $q->where([
                    'etat_id' => 110,
                ])
                ->whereBetween('created_at',[Carbon::now()->endOfDay()->subDays(30), Carbon::now()->endOfDay()]);
            }
        ])
        ->with([
            'commandes_sum' => function ($q){
                $q->where([
                    'etat_id' => 110,
                ])
                ->select('user_id', DB::raw('SUM(total_commande)'))->groupBy('user_id')
                ->whereBetween('created_at',[Carbon::now()->endOfDay()->subDays(30), Carbon::now()->endOfDay()]);
            },
            'session' => function ($q) {
                $q->where('last_activity', '>=', duree_session());
            },
        ])
        ->having('commandes_count', '>', 0)
        ->orderBy('commandes_count', 'desc')
        ->get();

        //Statistique des visites avec ou sans
        $totalPasco = Session::orderBy('last_activity')
        ->where('last_activity', '>', strtotime(Carbon::now())-86400)
        ->whereNull('user_id')
        //->get();
        ->count();

        $totalCo = Session::orderBy('last_activity')
        ->where('last_activity','>', strtotime(Carbon::now())-86400)
        ->whereNotNull('user_id')
        //->get();
        ->count();
        //dd($totalPasco);

        //Récupértion des commandes des 8 derniers jours
        $weekOrder=Commande::orderBy('created_at','desc')
        ->whereIn('etat_id', [110, 111, 112, 355])
        ->whereBetween('created_at', [Carbon::now()->endOfDay()->subDays(8), Carbon::now()->endOfDay()])
        ->get();
        $ordersByEtat=commande_periode($weekOrder);
        //dd($clientPerforms->toArray());

        //Calcul du montant et du nombre total des commandes livrées
        $montantTotalComLiv = stat_commandes(110, 'montant');
        $nombreTotalComLiv = stat_commandes(110, 'nombre');
        //Calcul du montant et du nombre total des commandes en attentes
        $montantTotalComAtt =  stat_commandes(111, 'montant');
        $montantTotalComAtt =  stat_commandes(111, 'montant');
        //Calcul du montant et du nombre total des commandes annulées
        $montantTotalComAnnu = stat_commandes(112, 'montant');
        $nombreTotalComAnnu = stat_commandes(112, 'nombre');

        // Journalisation
        activity()
            ->log('dashboard home');
        // End journalisation
        return view('celestadmin.accueil')->with([
            'nbrCommandeEnAttente'=>count($commandeEnAttentes),
            'recetteJournaliere'=>$recette,
            'nbrClient'=>$users,
            'commandesEnAttente'=>collect($commandeEnAttentes),
            'usersConnectes'=>$userConnect,
            'commande_periode'=>$ordersByEtat,
            'montantTotalCommandesLivrees'=>$montantTotalComLiv,
            'nombreTotalCommandesLivrees'=>$nombreTotalComLiv,
            'montantTotalCommandesAnnulees'=>$montantTotalComAnnu,
            'nombreTotalCommandesAnnulees'=>$nombreTotalComAnnu,
            'montantTotalCommandesAttentes'=>$montantTotalComAtt,
            'listeLastClientIns'=>$dernierClientRecInsc,
            'nbrClientIncritsRecen'=>count($dernierClientRecInsc),
            'nbrUsersligneNoConnect'=>$totalPasco,
            'nbrUsersligneConnect'=>$totalCo,
            'clientsPerforms'=>$clientPerforms,

            'infosPage' => array(
                'title' => 'Accueil',
                'slug' => '/',
            ),
        ]);
    }
}
