<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Session;
use App\User;
use Carbon\Carbon;
use Cron\DayOfWeekField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\default_user_agent;

class StatistiqueController extends Controller
{
    public  function commandes(){


        //Calcul du montant et du nombre total des commandes livrées
        $commandesLivrees=Commande::orderBy('created_at','desc')
        ->where('etat_id',110)
        ->get();
        $montantTotalComLiv=$commandesLivrees->sum('total_commande');
        $nombreTotalComLiv=$commandesLivrees->count('total_commande');

        //Calcul du montant et du nombre total des commandes en attentes
        $commandesAttentes=Commande::orderBy('created_at','desc')
        ->where('etat_id',111)
        ->get();
        $montantTotalComAtt=$commandesAttentes->sum('total_commande');
        $nombreTotalComAtt=$commandesAttentes->count('total_commande');


        //Calcul du montant et du nombre total des commandes annulées
        $commandesAnnulees=Commande::orderBy('created_at','desc')
        ->where('etat_id',112)
        ->get();
        $montantTotalComAnnu=$commandesAnnulees->sum('total_commande');
        $nombreTotalComAnnu=$commandesAnnulees->count('total_commande');
        //Calcul du montant et du nombre total des commandes annulées
        $commandesEnCours=Commande::orderBy('created_at','desc')
        ->where([
            'etat_id'=>361,
            'etat_id'=>357,
            'etat_id'=>355,
        ])
        ->get();
        $montantTotalComEnPaiement=$commandesEnCours->sum('total_commande');
        $nombreTotalComEnPaiement=$commandesEnCours->count('total_commande');

        //Les commandes en fonction du temps
        if (!request('reportrange')) {
            $last =  Carbon::now()->endOfDay();
            $first =  Carbon::now()->subDays(29)->startOfDay();
        }
        else{
            $date = request('reportrange');
            $first = substr($date, 0, 10);
            $first = Carbon::createFromDate($first)->startOfDay();
            $last = substr($date, 13, 10);
            $last = Carbon::createFromDate($last)->startOfDay();
            //dd($last);
        }
        $commandesByPeriod=Commande::orderBy('created_at','desc')
        ->whereIn('etat_id',[110,111,112])
        ->whereBetween('created_at',[$first,$last])
        ->get();
        $commande_periode=commande_periode($commandesByPeriod);

        //Récupérations des commandes filtrées selon un temps
        //Calcul du montant et du nombre total des commandes livrées selon le filtre
        $commandesLivreesFiltre=Commande::orderBy('created_at','desc')
        ->where('etat_id',110)
        ->whereBetween('created_at',[$first,$last])
        ->get();
        $montantTotalComLivFiltre=$commandesLivreesFiltre->sum('total_commande');
        $nombreTotalComLivFiltre=$commandesLivreesFiltre->count('total_commande');

        //Calcul du montant et du nombre total des commandes en attentes selon le filtre
        $commandesAttentesFiltre=Commande::orderBy('created_at','desc')
        ->where('etat_id',111)
        ->whereBetween('created_at',[$first,$last])
        ->get();
        $montantTotalComAttFiltre=$commandesAttentesFiltre->sum('total_commande');
        $nombreTotalComAttFiltre=$commandesAttentesFiltre->count('total_commande');

        //Calcul du montant et du nombre total des commandes annulées selon le filtre
        $commandesAnnuleesFiltre=Commande::orderBy('created_at','desc')
        ->where('etat_id',112)
        ->whereBetween('created_at',[$first,$last])
        ->get();
        $montantTotalComAnnuFiltre=$commandesAnnuleesFiltre->sum('total_commande');
        $nombreTotalComAnnuFiltre=$commandesAnnuleesFiltre->count('total_commande');

        //Calcul du montant et du nombre total des commandes annulées selon le filtre
        $commandesEnPaiementFiltre=Commande::orderBy('created_at','desc')
        ->where([
            'etat_id'=>355,
        ])
        ->whereBetween('created_at',[$first,$last])
        ->get();
        $montantTotalComEnPaiementFiltre=$commandesEnPaiementFiltre->sum('total_commande');
        $nombreTotalComEnPaiementFiltre=$commandesEnPaiementFiltre->count('total_commande');

        //Récupération des commandes filtrés par jours
        $commandesByDays=Commande::select(DB::raw("DISTINCT DAYOFWEEK(created_at) as day, COUNT(id) as nombre, SUM(total_commande) as montant"))
        ->where([
            'etat_id'=>110,
        ])
        ->whereBetween('created_at',[$first,$last])
        ->groupBy('day')
        ->orderBy('day')
        ->get();
        // $daysFrench = [
        //     0 => 'Lundi',
        //     1 => 'Mardi',
        //     2 => 'Mercredi',
        //     3 => 'Jeudi',
        //     4 => 'Vendredi',
        //     5 => 'Samedi',
        //     6 => 'Dimanche',
        // ];
        // if(count($commandesByDays)){
        //     for($i=0;$i<=6;$i++){
        //         $commandesByDays[$i]->day=$daysFrench[$i];
        //     }
        // }
        foreach ($commandesByDays as $key => $value) {
            switch ($value->day) {
                case 1:
                    $value->day = 'Lundi';
                    break;
                case 2:
                    $value->day = 'Mardi';
                    break;
                case 3:
                    $value->day = 'Mercredi';
                    break;
                case 4:
                    $value->day = 'Jeudi';
                    break;
                case 5:
                    $value->day = 'Vendredi';
                    break;
                case 6:
                    $value->day = 'Samedi';
                    break;
                case 7:
                    $value->day = 'Dimanche';
                    break;
                default:
                    # code...
                    break;
            }
        }

        //Récupération des commandes filtrés par Heures
        $commandesByHour=Commande::select(DB::raw("DATE_FORMAT(created_at, '%H') AS heure, COUNT(id) as nombre, SUM(total_commande) as montant"))
        ->where([
            'etat_id'=>110,
        ])
        ->whereBetween('created_at',[$first,$last])
        ->groupBy('heure')
        ->orderBy('heure')
        ->get();
        $i=0;
        while($i<count($commandesByHour)){
            $commandesByHour[$i]->heure=$commandesByHour[$i]->heure.' H';
            $i++;
        };
        //
        //Récupération des commandes par année par mois
        $commandes=array();
        for($i=2016;$i<=Carbon::now()->format('Y');$i++){
            $ordersPertime=Commande::select(DB::raw("DATE_FORMAT(created_at, '%m') AS mois,etat_id, COUNT(id)As nombre, SUM(total_commande) AS somme"))
            ->whereIn('etat_id',[110,112])
            ->whereBetween('created_at',[$i.'-01-01 00:00:00',$i.'-12-31 23:59:59]'])
            ->groupBy('mois')
            ->groupBy('etat_id')
            ->orderBy('mois')
            ->get();

            $ordersPertime=$ordersPertime->groupBy('mois');
            $commandes[''.$i]=$ordersPertime;
            $commandes=collect($commandes);
        }

        // dd($commandesByHour->toArray());
        activity()
            ->log('commandes statistique');
        // End journalisation
        return view('celestadmin.statistics.commandes')->with([

            'montantTotalComLiv'=>$montantTotalComLiv,
            'nombreTotalComLiv'=>$nombreTotalComLiv,
            'montantTotalComAtt'=>$montantTotalComAtt,
            'nombreTotalComAtt'=>$nombreTotalComAtt,
            'montantTotalComAnnu'=>$montantTotalComAnnu,
            'nombreTotalComAnnu'=>$nombreTotalComAnnu,
            'montantTotalComEnPaiement'=>$montantTotalComEnPaiement,
            'nombreTotalComEnPaiement'=>$nombreTotalComEnPaiement,
            'commande_periode'=>$commande_periode,
            'montantTotalComLivFiltre'=>$montantTotalComLivFiltre,
            'nombreTotalComLivFiltre'=>$nombreTotalComLivFiltre,
            'montantTotalComAttFiltre'=>$montantTotalComAttFiltre,
            'nombreTotalComAttFiltre'=>$nombreTotalComAttFiltre,
            'montantTotalComAnnuFiltre'=>$montantTotalComAnnuFiltre,
            'nombreTotalComAnnuFiltre'=>$nombreTotalComAnnuFiltre,
            'montantTotalComEnPaiementFiltre'=>$montantTotalComEnPaiementFiltre,
            'nombreTotalComEnPaiementFiltre'=>$nombreTotalComEnPaiementFiltre,
            'commandesParJour'=>$commandesByDays,
            'commandesParHeure'=>$commandesByHour,
            'commandes'=>$commandes,
            'infosPage' => array(
                'title' => 'Statistiques de commandes',
                'slug' => 'commandes/statistiques',
                'icon' => 'icofont-chart-bar-graph',
                'can' => '',
            ),
        ]);
    }
    public  function users(){
        //Le filtre
        if (!request('reportrange')) {
            $last =  Carbon::now()->endOfDay();
            $first =  Carbon::now()->subDays(29)->startOfDay();
        }
        else{
            $date = request('reportrange');
            $first = substr($date, 0, 10);
            $first = Carbon::createFromDate($first)->startOfDay();
            $last = substr($date, 13, 10);
            $last = Carbon::createFromDate($last)->startOfDay();
            //dd($last);
        }

        //nombre d'admin sur le site
        $nbrAdmin = User::role('admin')
        ->count();
        //nombre de grossistes sur le site
        $nbrGross=User::role('grossiste')
        ->count();
        //nombre de fournisseur sur le site
        $nbrFour=User::role('fournisseur')
        ->count();
        //nombre de detaillant sur le site
        $nbrDet=User::role('detaillant')
        ->count();

        //Nombre de commandes passé par les admin en fonction du temps
        $users = User::with([
            'commandes'
        ])
        ->role(['detaillant'])
        ->get();
        $users = $users->map(
            function ($q){
                return $q->commandes;
            }
        )->flatten();
        $commandes_periode=commande_periode($users->where('etat_id',110)->whereBetween('created_at',[$first,$last]));

        //Recupérationd des navigateurs par les sesssions
        $user_agent= Session::orderBy('last_activity')->get();
        $chrome=0;
        $firefox=0;
        $safari=0;
        $opera=0;
        $other=0;
        $internet_explorer=0;
        $nbrAgent=0;
        foreach ($user_agent as $elt) {
            if(get_user_agent($elt)[0]=='Google Chrome'){
                $chrome++;
            }elseif(get_user_agent($elt)[0]=='Mozilla Firefox'){
                $firefox++;
            }elseif(get_user_agent($elt)[0]=='Apple Safari'){
                $safari++;
            }elseif(get_user_agent($elt)[0]=='Internet Explorer'){
                $internet_explorer++;
            }elseif(get_user_agent($elt)[0]=='Opera'){
                $opera++;
            }else{
                $other++;
            }
            $nbrAgent++;
        }
        $browsers=array(
            'chrome'=>round(($chrome/$nbrAgent)*100,2),
            'firefox'=>round(($firefox/$nbrAgent)*100,2),
            'safari'=>round(($safari/$nbrAgent)*100,2),
            'opera'=>round(($opera/$nbrAgent)*100,2),
            'internet_explorer'=>round(($internet_explorer/$nbrAgent)*100,2),
            'other'=>round(($other/$nbrAgent)*100,2)
        );

        //Les utilisateurs qui sont  en ligne
        $usersConnected = Session::orderBy('last_activity')
        ->where('last_activity', '>', strtotime(duree_session()))
        ->whereNotNull('user_id')
        ->count();

        //Les utilisateurs qui sont en ligne et n'ont pas de comptes
        $usersNotConnected = Session::orderBy('last_activity')
        ->where('last_activity', '>', strtotime(duree_session()))
        ->whereNull('user_id')
        ->count();

        //Récupération du nombre de client
        $nbrUsers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['grossiste','detaillant','fournisseur']);
        })
        ->count();

        //récupérer le nombre nombre d'utilisateur non inscrits connectés par tranche d'heure
        $usersPerTime=Session::whereNull('user_id')
        ->orderBy('last_activity','desc')
        ->get();
        $usersWithoutAccount=array(
            1=>0,
            2=>0,
            3=>0,
            4=>0,
            5=>0,
            6=>0,
            7=>0,
            8=>0,
            9=>0,
            10=>0,
            11=>0,
            12=>0,
            13=>0,
            14=>0,
            15=>0,
            16=>0,
            17=>0,
            18=>0,
            19=>0,
            20=>0,
            21=>0,
            22=>0,
            23=>0,
            24=>0
        );
        $usersWithAccount=$usersWithoutAccount;
        $cpt=0;
        foreach ($usersPerTime as $elt) {
            // $minutes=intval(date('i',$elt->last_activity))/10;  +$minutes
            $elt->last_activity=intval(date('H',$elt->last_activity));
            $inter=$elt->last_activity;
            for($i=0;$i<count($usersPerTime);$i++){
                if($usersPerTime[$i]->last_activity==$inter){
                    $cpt++;
                }
            }
            $usersWithoutAccount[$inter]=$cpt;
            $cpt=0;
        }
        $usersWithoutAccount=collect($usersWithoutAccount);

        //Utilsateurs connectés en ligne en fonction du temps
        $userConnectedPerTime=Session::whereNotNull('user_id')
        ->orderBy('last_activity','desc')
        ->get();
        $cpt=0;
        foreach ($userConnectedPerTime as $elt) {
            // $minutes=intval(date('i',$elt->last_activity))/10;  +$minutes
            $elt->last_activity=intval(date('H',$elt->last_activity));
            $inter=$elt->last_activity;
            for($i=0;$i<count($userConnectedPerTime);$i++){
                if($userConnectedPerTime[$i]->last_activity==$inter){
                    $cpt++;
                }
            }
            $usersWithAccount[$inter]=$cpt;
            $cpt=0;
        }
        $usersWithAccount=collect($usersWithAccount);

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

        //  dd($usersPerTime->toArray());
        activity()
            ->log('users statistique');
        // End journalisation
        return view('celestadmin.statistics.users')->with([
            'nbrAdmin'=>$nbrAdmin,
            'nbrGrossiste'=>$nbrGross,
            'nbrFournisseur'=>$nbrFour,
            'nbrDetaillant'=>$nbrDet,
            'commande_periode'=>$commandes_periode,
            'browsers'=>$browsers,
            'usersConnected'=>$usersConnected,
            'usersNotConnected'=>$usersNotConnected,
            'nbrUsers'=>$nbrUsers,
            'usersWithoutAccount'=>$usersWithoutAccount,
            'usersWithAccount'=>$usersWithAccount,
            'clientPerforms'=>$clientPerforms,

            'infosPage' => array(
                'title' => 'Statistiques des utilisateurs',
                'slug' => 'utilisateurs/statistiques',
                'icon' => 'icofont-chart-bar-graph',
                'can' => '',
            ),
        ]);
    }
}

