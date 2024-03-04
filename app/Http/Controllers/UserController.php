<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Commande;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Rules\MatchOldPassword;

use App\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Cookie;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
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
        return view('celestadmin.user.datatable');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //User::find(2)->assignRole('superadmin');
        if(auth()->user()->hasRole('superadmin')){
            $totalUsers = User::with([
                'roles',
            ])
            ->get();
            $users = User::with([
                'childrens' => function($q){
                    $q -> with([
                        'childrens' => function($q){
                            $q->with([
                                'childrens' => function($q){
                                    $q->with([
                                        'childrens' => function($q){
                                            $q->with([
                                                'childrens' => function($q){
                                                    $q->with([
                                                        'childrens' => function($q){
                                                            $q->with([
                                                                'childrens' => function($q){
                                                                    $q->with([
                                                                        'childrens' => function($q){
                                                                            $q->with([
                                                                                'childrens' => function($q){
                                                                                    $q->with([
                                                                                        'childrens'
                                                                                    ]);
                                                                                }
                                                                            ]);
                                                                        }
                                                                    ]);
                                                                }
                                                            ]);
                                                        }
                                                    ]);
                                                }
                                            ]);
                                        }
                                    ]);
                                }
                            ]);
                        }]
                    );
                },
                'parent',
                'permissions',
                'roles',
                'session' => function ($q) {
                    $q->where('last_activity', '>=', duree_session());
                },
            ])
            ->withCount('commandes')
            /* ->withCount('commandes')
            ->having('commandes_count', '>', 0) */
            ->whereHas('roles', function ($q) {
                if (request('type')) {
                    $q->where('name', request('type'));
                }
            })
            /* ->whereHas('session', function ($q) {
                if (request('type')) {
                    $q->where('last_activity', '>=', duree_session());
                }
            }) */
            //->orderBy('commandes_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            //->paginate($limit);
        }
        else{
            $totalUsers = User::with([
                'roles',
            ])
            ->whereHas('roles', function ($q) {
                $q->where('name', '!=', 'superadmin');
            })
            ->get();
            $users = User::with([
                'childrens' => function($q){
                    $q -> with([
                        'childrens' => function($q){
                            $q->with([
                                'childrens' => function($q){
                                    $q->with([
                                        'childrens' => function($q){
                                            $q->with([
                                                'childrens' => function($q){
                                                    $q->with([
                                                        'childrens' => function($q){
                                                            $q->with([
                                                                'childrens' => function($q){
                                                                    $q->with([
                                                                        'childrens' => function($q){
                                                                            $q->with([
                                                                                'childrens' => function($q){
                                                                                    $q->with([
                                                                                        'childrens'
                                                                                    ]);
                                                                                }
                                                                            ]);
                                                                        }
                                                                    ]);
                                                                }
                                                            ]);
                                                        }
                                                    ]);
                                                }
                                            ]);
                                        }
                                    ]);
                                }
                            ]);
                        }]
                    );
                },
                'parent',
                'permissions',
                'roles',
                'session' => function ($q) {
                    $q->where('last_activity', '>=', duree_session());
                },
            ])
            ->withCount('commandes')
            ->orderBy('created_at', 'desc')
            ->whereHas('roles', function ($q) {
                $q->where('name', '!=', 'superadmin');
            })
            ->whereHas('roles', function ($q) {
                if (request('type')) {
                    $q->where('name', request('type'));
                }
            })
            ->get();
            //->paginate($limit);
        }
        //dd($users->toArray());
        /* if ($request->ajax()) {
            return datatables($users)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.url('').'" class="btn btn-primary btn-sm">Voir</a>';
                        return $btn;
                    })
                    ->addColumn('roles', function($row){
                        $roles = $row->roles->first()->name;
                        return $roles;
                    })
                    ->addColumn('status', function($row){
                        if ($row->isOnline())
                        {
                            return '<li class="text-success">
                                En ligne
                            </li>';
                        }
                        else{
                            return '<li class="text-muted">
                                Hors ligne
                            </li>';
                        }
                    })
                    ->editColumn('name', '<a href="'.route('user.show', $users).'">{{$name}}</a>')
                    ->make(true);
        } */

        // Journalisation
        activity()
            ->log('users index');
        // End journalisation
        $trashed = [];
        return view('celestadmin.user.index')->with([
            'trashed' => $trashed,
            'valeurs' => $users,
            'countUser' => countUser($totalUsers),
            'infosPage' => array(
                'title' => 'Utilisateurs',
                'slug' => 'users',
                'icon' => 'icofont-users-alt-2',
                'element' => 'Utilisateur',
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
        $roles = Role::whereNotIn('id', [1])
        ->get();
        // Journalisation
        activity()
            ->log('users create form');
        // End journalisation
        return view('celestadmin.user.create')->with([
            'type_valeurs' => $roles,
            'infosPage' => array(
                'title' => 'Creation utilisateur',
                'slug' => 'users',
                'icon' => 'icofont-users-alt-2',
                'element' => 'Utilisateurs',
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
            'name' => 'required',
            'role_id'=>'required',
            'prenom'=>'required',
            'adresse'=>'required',
            'telephone'=>'required',
            'sexe'=>'required',
            'email' => 'required|string|email|max:255|unique:users',
            'biograhie'=>'string',
        ]);

        $user=User::create([
            'name' => request('name'),
            'prenom' => request('prenom'),
            'telephone' => request('telephone'),
            'biographie' => request('biographie'),
            'adresse' => request('adresse'),
            'sexe' => request('sexe'),
            'email' => request('email'),
        ]);
        $user->assignRole(request('role_id'));
        flash()->overlay('Ajout effectué avec succès', 'Message')->success();

        // Journalisation
        activity()
            ->log('Formulaire de creation d\'ulisateurs');
        // End journalisation

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //$activities = auth()->user()->activities();
        //dd($activities);
        $activities = Activity::where([
            'causer_type' => 'App\User',
            'causer_id' => $user->id
        ])->get();
        //dd($activities->toArray());
        $first_commande = Commande::orderBy('created_at')->first();
        //dd($first_commande->toArray());
        if (!request('reportrange')) {
            //get_first_date_order($user->commandes);
            $last =  Carbon::today()->format('Y-m-d');
            $first =  New Carbon($first_commande->created_at);
            $first->format('Y-m-d');
            //dd($last);
        }
        else{
            $date = request('reportrange');
            $first = substr($date, 0, 10);
            $first = Carbon::createFromDate($first)->format('Y-m-d');
            $last = substr($date, 13, 10);
            $last = Carbon::createFromDate($last)->format('Y-m-d');
            //dd($last);
        }

        $user = User::with([
            'childrens' => function($q){
                $q -> with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens' => function($q){
                                $q->with([
                                    'childrens' => function($q){
                                        $q->with([
                                            'childrens' => function($q){
                                                $q->with([
                                                    'childrens' => function($q){
                                                        $q->with([
                                                            'childrens' => function($q){
                                                                $q->with([
                                                                    'childrens' => function($q){
                                                                        $q->with([
                                                                            'childrens' => function($q){
                                                                                $q->with([
                                                                                    'childrens'
                                                                                ]);
                                                                            }
                                                                        ]);
                                                                    }
                                                                ]);
                                                            }
                                                        ]);
                                                    }
                                                ]);
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    }]
                );
            },
            'parent',
            'commandes' => function($q) use ($first, $last){
                $q -> with([
                    'produits',
                    'mode_paiements',
                    'adresse',
                    'livraison_mode',
                    'etat',
                    'source',
                    'heure',
                    'commercial',
                ])
                ->whereBetween('created_at', [$first, $last]);
            },
            'permissions',
            'roles',
            'source',
            'adresses' => function($q){
                $q->with([
                    'commandes',
                    'parent',
                ]);
            },
        ])
        ->orderBy('id', 'desc')
        ->findOrFail($user->id);

        //dd(commande_periode($user->commandes));
        //$media = $parametre->getMedia('image');
        //dd(Carbon::now()->format('Y'));

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('show');
        // End journalisation
        return view('celestadmin.user.show')->with([
            'activities' => $activities,
            'valeur' => $user,
            'commande_periode' => commande_periode($user->commandes),
            'infosPage' => array(
                'title' => 'Détails utilisateur : "'.$user->name.' '.$user->prenom.'"',
                'slug' => 'users',
                'icon' => 'icofont-users-alt-2',
                'element' => 'Utilisateurs',
            ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user , $id)
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $admins = User::role('admin')->get();
        $user = User::findOrFail($id);
        // Journalisation

        activity()
            ->performedOn($user)
            ->log('users edit form');
        // End journalisation
        return view('celestadmin.user.edit')->with([
            'admins' => $admins,
            'type_valeurs' => $roles,
            'valeur' => $user,
            'infosPage' => array(
                'title' => 'Modification "'.$user->name.'"',
                'slug' => 'users',
                'icon' => 'icofont-fire-alt',
                'element' => 'Utilisateurs',
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $typeTaxonomie, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'role_id'=>'required',
            'prenom'=>'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = request('name');
        $user->prenom = request('prenom');
        $user->telephone = request('telephone');
        $user->biographie = request('biographie');
        $user->adresse = request('adresse');
        $user->sexe = request('sexe');
        $user->parent_id=request(('commercial'));
        $user->assignRole(request('role_id'));

        $user->save();

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('Formulaire de modification des utilisateurs');
        // End journalisation

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        if (request('status') == 'trashed') {
            $user = User::onlyTrashed()
            ->find($id);
            $user->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $user = User::findOrFail($id);
            $user->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function corbeille(User $user)
    {
        $user = User::onlyTrashed();
        $user->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restaurer(User $user, $id)
    {
        if (request('status') == 'trashed') {
            $user = User::onlyTrashed()
            ->find($id);
            $user->restore();
        }
        else{
            $user = User::onlyTrashed();
            $user->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validation(User $user, $id)
    {
        $user = User::findOrFail($id);
        $user->valide = 1;
        $user->save();

        flash()->overlay('Inscription validée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Page d'accueil
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profil()
    {
        $user = User::with([
            'childrens' => function($q){
                $q -> with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens' => function($q){
                                $q->with([
                                    'childrens' => function($q){
                                        $q->with([
                                            'childrens' => function($q){
                                                $q->with([
                                                    'childrens' => function($q){
                                                        $q->with([
                                                            'childrens' => function($q){
                                                                $q->with([
                                                                    'childrens' => function($q){
                                                                        $q->with([
                                                                            'childrens' => function($q){
                                                                                $q->with([
                                                                                    'childrens'
                                                                                ]);
                                                                            }
                                                                        ]);
                                                                    }
                                                                ]);
                                                            }
                                                        ]);
                                                    }
                                                ]);
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    }]
                );
            },
            'parent',
            'commandes',
            'adresses',
        ])
        ->find(auth()->user()->id);
        if (Cart::instance('shopping')->count() == 0) {
            $commande = panierCommande('reference', Cookie::get('invATR'), $user);
        }
        //$niveau1 = count($user)
        //$valeur = nombre_filleuls($user);
        //dd($valeur);
        //dd($user->toArray());
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('profil');
        // End journalisation
        return view('web.user.profil')->with([
            'parametre' => $parametre,
            'user' => $user,
            'infosPage' => array(
                'title' => 'Espace membre',
                'slug' => 'profil',
            ),
        ]);
    }

    public function commande()
    {
        $user = User::with([
            'childrens' => function($q){
                $q -> with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens' => function($q){
                                $q->with([
                                    'childrens' => function($q){
                                        $q->with([
                                            'childrens' => function($q){
                                                $q->with([
                                                    'childrens' => function($q){
                                                        $q->with([
                                                            'childrens' => function($q){
                                                                $q->with([
                                                                    'childrens' => function($q){
                                                                        $q->with([
                                                                            'childrens' => function($q){
                                                                                $q->with([
                                                                                    'childrens'
                                                                                ]);
                                                                            }
                                                                        ]);
                                                                    }
                                                                ]);
                                                            }
                                                        ]);
                                                    }
                                                ]);
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    }]
                );
            },
            'parent',
            'commandes' => function($q){
                $q->with([
                    'produits' => function($q){
                        $q->with([
                            'categories'
                        ]);
                    },
                    'etat',
                    'adresse',
                ])
                ->whereIn('etat_id', [110, 111, 112, 113, 355, 356]);
            },
            'adresses',
        ])
        /* ->whereHas('commandes', function ($q) {
            $q->whereIn('etat_id', [110, 111, 112, 113, 355, 356]);
        }) */
        ->find(auth()->user()->id);
        //dd($user->toArray());
        $parametre = parametre_web();
        return view('web.user.order')->with([
            'parametre' => $parametre,
            'user' => $user,
            'infosPage' => array(
                'title' => 'Commandes',
                'slug' => 'profil/commande',
            ),
        ]);
    }

    //fonction pour repasser des commandes déjà utilisés
    public function repasser($id){
        $order=Commande::where('id',$id)
        ->with(['produits' => function($q){
            $q->with([
                'categories'
                ]);
            },
        ])
        ->first();
        if($order){
            Cart::instance('shopping')->destroy();
            $commande = Commande::create([
                'quantite_produit' => $order->quantite_produit,
                'cout_commande' => $order->cout_commande,
                'cout_livraison' => $order->cout_livraison,
                'total_commande' => $order->total_commande,
                'type' => 'produit',
                'user_id' => $order->user_id,
                'etat_id' => 357,
                'livraison_mode_id' => 362,
                'source_id' => mobile_detect_devise(),
                'created_ip' => request()->ip(),
            ]);
            foreach($order->produits as $produit){
                foreach ($produit->categories as $subdivision) {
                    if ($subdivision->pivot->type == 'subdivision') {
                        break;
                    }
                }
                Cart::instance('shopping')->add(
                    $produit->reference,
                    $produit->libelle,
                    $subdivision->sous_titre,
                    $produit->prix_nouveau);
            }
            $commande->produits()->attach($produit->id, [
                'cout' => $produit->prix_nouveau,
                'quantite' => $produit->pivot->quantite,
                //'options' => null, //pas gérer
            ]);
        }
        if(!Cookie::get('invATR')){
            $cookie = Cookie::make('invATR', $commande->reference, dureeCookie());
        }else{
            $cookie = Cookie::get('invATR');
        }
        Alert::success('Panier', 'Bravo '.auth()->user()->prenom.' '.auth()->user()->nom.', vos produits ont été ajouté au panier avec succès!!!');
        return redirect('panier')->cookie($cookie);

    }
    public function adresse()
    {
        $user = User::with([
            'childrens' => function($q){
                $q -> with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens' => function($q){
                                $q->with([
                                    'childrens' => function($q){
                                        $q->with([
                                            'childrens' => function($q){
                                                $q->with([
                                                    'childrens' => function($q){
                                                        $q->with([
                                                            'childrens' => function($q){
                                                                $q->with([
                                                                    'childrens' => function($q){
                                                                        $q->with([
                                                                            'childrens' => function($q){
                                                                                $q->with([
                                                                                    'childrens'
                                                                                ]);
                                                                            }
                                                                        ]);
                                                                    }
                                                                ]);
                                                            }
                                                        ]);
                                                    }
                                                ]);
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    }]
                );
            },
            'parent',
            'commandes' => function($q){
                $q->with([
                    'produits',
                    'etat',
                    'adresse',
                ]);
            },
            'adresses' => function($q){
                $q->with([
                    'commandes',
                    'parent',
                ]);
            },
        ])
        ->find(auth()->user()->id);

        // Listing des pays
        $pays = Categorie::where([
            'taxonomie_id' => 4,
        ])
        ->orderBy('id', 'desc')
        ->get();

        //dd($user->adresses->toArray());

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('profil adresse');
        // End journalisation
        $parametre = parametre_web();
        return view('web.user.adresse')->with([
            'parametre' => $parametre,
            'user' => $user,
            'pays' => $pays,
            'infosPage' => array(
                'title' => 'Adresses de livraison',
                'slug' => 'profil/adresse',
            ),
        ]);
    }

    public function edit_member()
    {
        $user = User::with([
            'childrens' => function($q){
                $q -> with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens' => function($q){
                                $q->with([
                                    'childrens' => function($q){
                                        $q->with([
                                            'childrens' => function($q){
                                                $q->with([
                                                    'childrens' => function($q){
                                                        $q->with([
                                                            'childrens' => function($q){
                                                                $q->with([
                                                                    'childrens' => function($q){
                                                                        $q->with([
                                                                            'childrens' => function($q){
                                                                                $q->with([
                                                                                    'childrens'
                                                                                ]);
                                                                            }
                                                                        ]);
                                                                    }
                                                                ]);
                                                            }
                                                        ]);
                                                    }
                                                ]);
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    }]
                );
            },
            'parent',
            'commandes',
        ])
        ->find(auth()->user()->id);
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('profil edit');
        // End journalisation
        return view('web.user.edit')->with([
            'parametre' => $parametre,
            'user' => $user,
            'infosPage' => array(
                'title' => 'Profil utilisateur',
                'slug' => 'profil/edit',
            ),
        ]);
    }

    public function update_member(Request $request)
    {
        $request->validate([
            'prenom' => 'required',
            'name' => 'required',
            'date_naissance' => 'date|nullable',
            'adresse' => ['required', 'string', 'max:255'],
            'telephone' => 'required',
            'indicatif_telephone' => 'required',
            'type_piece' => ['required', 'string', 'max:255'],
            'numero_piece' => ['required', 'string', 'max:255'],
        ]);

        if(request('email')){
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);
            if(request('email') != auth()->user()->email){
                $request->validate([
                    'email' => ['unique:users'],
                ]);
            }
        }
        if (!empty(request('whatsapp'))) {
            $request->validate([
                'indicatif_whatsapp' => ['required', 'string'],
            ]);
        }
        $user = User::findOrFail(auth()->id());
        $user->name = request('name');
        $user->prenom = request('prenom');
        $user->sexe = request('sexe');
        $user->date_naissance = request('date_naissance');
        $user->biographie = request('biographie');
        $user->telephone = request('telephone');
        $user->indicatif_telephone = request('indicatif_telephone');
        $user->whatsapp = request('whatsapp');
        $user->indicatif_whatsapp = request('indicatif_whatsapp');
        $user->adresse = request('adresse');
        $user->type_piece = request('type_piece');
        $user->numero_piece = request('numero_piece');
        if (!empty(request('email'))) {
            $user->email = request('email');
        }
        $user->save();

        flash('Vos informations ont été mise à jour avec succès')->success();
        return back();
    }

    public function edit_password()
    {
        $user = User::with([
            'childrens' => function($q){
                $q -> with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens' => function($q){
                                $q->with([
                                    'childrens' => function($q){
                                        $q->with([
                                            'childrens' => function($q){
                                                $q->with([
                                                    'childrens' => function($q){
                                                        $q->with([
                                                            'childrens' => function($q){
                                                                $q->with([
                                                                    'childrens' => function($q){
                                                                        $q->with([
                                                                            'childrens' => function($q){
                                                                                $q->with([
                                                                                    'childrens'
                                                                                ]);
                                                                            }
                                                                        ]);
                                                                    }
                                                                ]);
                                                            }
                                                        ]);
                                                    }
                                                ]);
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    }]
                );
            },
            'parent'
        ])
        ->find(auth()->user()->id);
        $parametre = parametre_web();

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('profil edit password');
        // End journalisation
        return view('web.user.password')->with([
            'parametre' => $parametre,
            'user' => $user,
            'infosPage' => array(
                'title' => 'Modification de mot de passe',
                'slug' => 'profil',
            ),
        ]);
    }

    public function update_password(Request $request)
    {
        if(auth()->user()->password){
            $request->validate([
                'current_password' => [new MatchOldPassword],
            ]);
        }

        $request->validate([
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        $user = User::findOrFail(auth()->id());
        $user->password = request('new_password');
        $user->save();
        //echo request('new_password').' ------ '.Hash::make(request('new_password'));
        /* if (Hash::check(request('new_password'), Hash::make(request('new_password')))) {
            $resultat = '<br><br>' .request('new_password') . ' ------ ' . Hash::make(request('new_password')).' -------- '. $user->password;
        } */
        flash('Mot de passe changé avec succès ')->success();
        return back();
    }

    public function edit_picture()
    {
        $user = User::with([
            'childrens' => function($q){
                $q -> with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens' => function($q){
                                $q->with([
                                    'childrens' => function($q){
                                        $q->with([
                                            'childrens' => function($q){
                                                $q->with([
                                                    'childrens' => function($q){
                                                        $q->with([
                                                            'childrens' => function($q){
                                                                $q->with([
                                                                    'childrens' => function($q){
                                                                        $q->with([
                                                                            'childrens' => function($q){
                                                                                $q->with([
                                                                                    'childrens'
                                                                                ]);
                                                                            }
                                                                        ]);
                                                                    }
                                                                ]);
                                                            }
                                                        ]);
                                                    }
                                                ]);
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    }]
                );
            },
            'parent'
        ])
        ->find(auth()->user()->id);

        // Journalisation
        activity()
            ->performedOn($user)
            ->log('profil edit picture');
        // End journalisation
        return view('web.user.picture')->with([
            'user' => $user,
        ]);
    }

    public function update_picture(Request $request)
    {
        $request->validate([

        ]);
        $this->validate($request,[
            'photo' => 'required|image|max:11000',
        ]);
        $media = auth()->user()->getMedia('image')->first();
        if (!$media) {
            auth()->user()->addMediaFromRequest('photo')
            ->withManipulations([
                'thumb' => ['default' => '1'],
            ])
            ->toMediaCollection('image');
        }
        else {
            //dd($media->toArray());
            $media->delete();
            auth()->user()->addMediaFromRequest('photo')
            ->withManipulations([
                'thumb' => ['default' => '1'],
            ])
            ->toMediaCollection('image');
        }
        flash('Photo de profil mise à jour avec succès', 'Message')->success();
        return back();
    }
}
