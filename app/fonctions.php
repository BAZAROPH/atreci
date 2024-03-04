<?php
use App\Post;
use App\Categorie;
use App\Taxonomie;
use App\Parametre;
use App\Apparence;
use App\Champ;
use App\Commande;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

// Montrer qu'un champ est obligatoire
function champ_obligatoire($valeur)
{
    $return = null;
    if ($valeur == 1) {
        $return = '<i class="text-danger">*</i>';
    }
    return $return;
}

// Afficher les valeurs des checkbox
function checkbox($slug)
{
    $taxonomie = Taxonomie::where('slug', $slug)->firstOrFail();
    if($slug == 'ville'){
        $taxonomie_id = 4;
    }
    elseif($slug == 'quartier'){
        $taxonomie_id = 5;
    }
    else {
        $taxonomie_id = $taxonomie->id;
    }

    $categories = Categorie::with([
        'childrens' => function($q){
            $q->with([
                'childrens' => function($q){
                    $q->with([
                        'childrens'
                    ]);
                }]
            );
        },
        'champs' => function($q){
            $q->with([
                'type_champ'
            ]);
        },
        'parent'
    ])
    ->where([
        'taxonomie_id' => $taxonomie_id,
        'corbeille' => 1,
    ])
    ->orderBy('libelle', 'asc')
    ->get();
    //dd($categories->toArray());
    return $categories;
}


// Create permissions defaults
function create_permission($libelle)
{
    $role = Role::findOrFail(1);
    Permission::create([
        'name' => $libelle.' index',
    ]);
    $role->givePermissionTo($libelle.' index');

    Permission::create([
        'name' => $libelle.' show',
    ]);
    $role->givePermissionTo($libelle.' show');

    Permission::create([
        'name' => $libelle.' create',
    ]);
    $role->givePermissionTo($libelle.' create');

    Permission::create([
        'name' => $libelle.' edit',
    ]);
    $role->givePermissionTo($libelle.' edit');

    Permission::create([
        'name' => $libelle.' delete',
    ]);
    $role->givePermissionTo($libelle.' delete');

    Permission::create([
        'name' => $libelle.' restore',
    ]);
    $role->givePermissionTo($libelle.' restore');

    Permission::create([
        'name' => $libelle.' trash',
    ]);
    $role->givePermissionTo($libelle.' trash');
}


// Get menu of table categorie
function menu($taxonomie_id)
{
    $categories = Categorie::with([
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
                }]
            );
        },
        'parent',
    ])
    ->where([
        'taxonomie_id' => $taxonomie_id, // id taxonomie of menu_admin
        'corbeille' => 1,
    ])
    ->orderBy('created_at', 'asc')
    ->get();
    //dd($categories->toArray());
    return $categories;
}

// class css active menu
function menu_active()
{

}

// Recursive function of filleuls or childrens of user
function recursive_childrens($user, $nombreDeFilleul)
{
    if (count($user->childrens)) {
        foreach ($user->childrens as $value) {
            $nombreDeFilleul++;
            recursive_childrens($value, $nombreDeFilleul);
        }
    }
    else {
        echo 'jkkj';
        return $nombreDeFilleul;
    }
}

function nombre_filleuls($user)
{
    $nombreDeFilleul = 0;
    $nombreDeNiveau = 0;
    $niveau1 = 0;
    $niveau2 = 0;
    $niveau3 = 0;
    $niveau4 = 0;
    $niveau5 = 0;
    $niveau6 = 0;
    $niveau7 = 0;
    $niveau8 = 0;
    $niveau9 = 0;
    $niveau10 = 0;
    foreach ($user->childrens as $value1) {
        $nombreDeFilleul++;
        $niveau1++;
        echo $niveau1.'----'.count($value1->childrens).'<br>';
        if ($niveau1 == count($value1->childrens)) {
            $nombreDeNiveau++;
        }
        if (count($value1->childrens)) {
            foreach ($value1->childrens as $value2) {
                $nombreDeFilleul ++;
                $niveau2++;
                //echo $niveau2.'----'.count($value2->childrens).'<br>';
                if ($niveau2 == count($value2->childrens)) {
                    $nombreDeNiveau++;
                }
                if (count($value2->childrens)) {
                    foreach ($value2->childrens as $value3) {
                        $nombreDeFilleul ++;
                        if (count($value3->childrens)) {
                            foreach ($value3->childrens as $value4) {
                                $nombreDeFilleul ++;
                                if (count($value4->childrens)) {
                                    foreach ($value4->childrens as $value5) {
                                        $nombreDeFilleul ++;
                                        if (count($value5->childrens)) {
                                            foreach ($value5->childrens as $value6) {
                                                $nombreDeFilleul ++;
                                                if (count($value6->childrens)) {
                                                    foreach ($value6->childrens as $value7) {
                                                        $nombreDeFilleul ++;
                                                        if (count($value7->childrens)) {
                                                            foreach ($value7->childrens as $value8) {
                                                                $nombreDeFilleul ++;
                                                                if (count($value8->childrens)) {
                                                                    foreach ($value8->childrens as $value9) {
                                                                        $nombreDeFilleul ++;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $arrayName = array(
        'nombreDeFilleul' => $nombreDeFilleul,
        'nombreDeNiveau' => $nombreDeNiveau,
    );
}

function parametre_web()
{
    return $parametre = Parametre::latest()->first();
}

// Activation des liens en mode maquette
function urlMode($value, $etat)
{
	if ($etat == 222) {
		return '#';
	}
	else{
		return $value;
	}
}

//
function listing_post($etat = 222, $categorie_id, $apparence_id = null, $limit = 3, $column = null, $post_id = null, $nCaractere = null, $champATrier = 'id desc', $typeImage = '', $page = null, $additif = null, $restriction = [])
{
    if ($post_id) {
        $posts = Post::with([
            'categories' => function($q){
                $q->with([
                    'apparences',
                    'champs'
                ]);
            },
            'user',
            'fournisseur',
        ])
        ->where([
            'posts.id' => $post_id,
        ])
        ->get();
    }
    else {
        if (request('trier')) {
            switch (request('trier')) {
                case 365: // Populaire
                    $champATrier = 'rang asc, id desc';
                    break;
                case 366: // Prix croissant
                    $champATrier = 'prix_nouveau asc';
                    break;
                case 367: // Prix décroissant
                    $champATrier = 'prix_nouveau desc';
                    break;
                case 368: // Nouveauté
                    $champATrier = 'id desc';
                    break;

                default:
                    # code...
                    break;
            }
        }
        $posts = Post::with([
            'categories' => function($q){
                $q->with([
                    'apparences',
                    'champs'
                ]);
            },
            'user',
            'fournisseur',
        ])
        ->whereHas('categories', function ($q) use($categorie_id) {
            $q->whereIn('categories.id', [$categorie_id]);
        })
        ->whereNotIn('id', $restriction)
        ->when(request('term_search'), function($q){
            return $q->where('libelle', 'like', '%' . request('term_search') . '%');
        })
        ->when(request('price_min'), function($q){
            $min = request('price_min');
            $max = request('price_max');
            return $q->whereBetween('prix_nouveau', [$min, $max]);
        })
        ->orderByRaw("$champATrier");
        $postsSansPaginate = $posts;
        $postsSansPaginate = $postsSansPaginate->get();
        $posts = $posts->paginate($limit);
        //dd($posts->toArray());
    }

    if (count($posts)) {
        $champs = Champ::orderBy('created_at', 'desc')
        ->with([
            'type_champ',
        ])
        ->get();

        foreach ($posts[0]->categories as $rubrique) {
            if ($rubrique->pivot->type == 'rubrique') {
                $apparence = $rubrique->apparences[0];
                break;
            }
        }

        foreach ($posts[0]->categories as $categorie) {
            if ($categorie->pivot->type == 'categorie') {
                break;
            }
        }

        if ($apparence_id) {
            $apparence = Apparence::orderBy('created_at', 'desc')
            ->with([
                'type_apparence',
            ])
            ->find($apparence_id);
            //dd($apparence->toArray());
        }
        //dd($apparence->toArray());

        $code = null;
        $debut = null;
        $fin = null;
        $i = 0;
        $j = 0;
        foreach ($posts as $post) {
            $i++;
            $j++;
            foreach ($post->categories as $capacite) {
                if ($capacite->pivot->type == 'capacite') {
                    break;
                }
            }
            $suppression = array();
            $ajouter = array();
            foreach ($champs as $champ) {
                $suppression[] = '~'.$champ->libelle;
                switch ($champ->libelle) {
                    case 'user_id':
                        if($post->user)
                            $ajouter[] = $post->user->name.' '.$post->user->prenom;
                        else
                            $ajouter[] = null;
                        break;
                    break;
                    case 'image':
                        if(!empty($post->getMedia($champ->libelle)->first())){
                            $ajouter[] = url($post->getMedia($champ->libelle)->first()->getUrl($typeImage));
                        }
                        else {
                            $ajouter[] = null;
                        }
                    break;
                    case 'document':
                        if(!empty($post->getMedia($champ->libelle)->first())){
                            $ajouter[] = '<a href="'.url($post->getMedia($champ->libelle)->first()->getUrl('thumb')).'"><i class="icofont-law-document"></i></a>';
                        }
                        else {
                            $ajouter[] = null;
                        }
                    break;
                    case 'date_diff':
                        if($post->date_fin)
                        {
                            if($post->date_debut == $post->date_fin)
                                $date_difference = format_datation($post->date_debut);
                            else
                                $date_difference = 'Du '.date("d-m-Y à H:i", strtotime($post->date_debut)).' au '.date("d-m-Y à H:i", strtotime($post->date_fin));
                        }
                        else {
                            $date_difference = null;
                        }
                        $ajouter[] = $date_difference;
                    break;
                    case 'active':
                        if($i == 1)
                            $ajouter[] = 'active';
                        else
                            $ajouter[] = null;
                    break;
                    case 'incrementation':
                        $ajouter[] = $i;
                    break;
                    case 'lien':
                        if (substr($post[$champ->libelle], 0, 4) == 'http') {
                            $ajouter[] = urlMode($post[$champ->libelle], $etat);
                        }
                        else {
                            $ajouter[] = ($post[$champ->libelle]) ? urlMode(url($post[$champ->libelle]) , $etat): '';
                        }
                    break;
                    case 'slug':
                        $ajouter[] = ($post[$champ->libelle]) ? urlMode(url($post[$champ->libelle]), $etat) : '';
                        break;
                    case 'description':
                        if ($nCaractere) {
                            $ajouter[] = Str::limit(strip_tags($post[$champ->libelle]), $nCaractere);
                        }
                        else {
                            $ajouter[] = $post[$champ->libelle];
                        }
                        break;

                    case 'column':
                        $ajouter[] = $column;
                        break;

                    /* Debut rubrique */
                    case 'rubriqueLibelle':
                        $ajouter[] = $rubrique->libelle;
                        break;
                    case 'rubriqueDescription':
                        $ajouter[] = strip_tags($rubrique->description);
                        break;
                    case 'rubriqueIcon':
                        $ajouter[] = $rubrique->icon;
                        break;
                        case 'rubriqueSlug':
                            $ajouter[] = ($rubrique->slug) ? urlMode(url($rubrique->slug), $etat) : '';
                            break;
                    case 'rubriqueId':
                        $ajouter[] = $rubrique->id;
                        break;
                    case 'rubriqueImage':
                        if(!empty($rubrique->getMedia('image')->first()))
                            $ajouter[] = url($rubrique->getMedia('image')->first()->getUrl('thumb'));
                        else
                            $ajouter[] = null;
                        break;

                    /* Debut categorie */
                    case 'categoryLibelle':
                        $ajouter[] = $categorie->libelle;
                        break;
                    case 'categoryDescription':
                        $ajouter[] = strip_tags($categorie->description);
                        break;
                    case 'categoryIcon':
                        $ajouter[] = $categorie->icon;
                        break;
                    case 'categorySlug':
                        $ajouter[] = ($categorie->slug) ? urlMode(url($categorie->slug), $etat) : '';
                        break;
                    case 'categoryUrl':
                        $ajouter[] = $categorie->slug;
                        break;
                    case 'categoryImage':
                        if(!empty($categorie->getMedia('image')->first()))
                            $ajouter[] = url($categorie->getMedia('image')->first()->getUrl('thumb'));
                        else
                            $ajouter[] = null;
                    break;
                    case 'capacite':
                        $ajouter[] = '/'.$capacite->sous_titre;
                        break;
                    case 'created_at':
                    case 'antidater':
                    case 'date_planification':
                    case 'date_action':
                    case 'date_debut':
                    case 'date_fin':
                        if ($post[$champ->libelle]) {
                            $ajouter[] = format_datation($post[$champ->libelle]);
                        }
                        else {
                            $ajouter[] = null;
                        }
                    break;
                    case 'breadcrumb':
                        $ajouter[] = '<a href="'.url('/').'"><i class="fa fa-home"></i></a> /
                        <a href="#">'.$rubrique->libelle.'</a> /
                        '.$post->libelle;
                    break;
                    case 'partageFacebook':
                        $ajouter[] = '<a class="apss-facebook" title="'.$champ->titre.'" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.url()->current().'"><i class="fa fa-facebook"></i></a>';
                    break;
                    case 'partageTwitter':
                        $ajouter[] = '<a class="apss-twitter" title="'.$champ->titre.'" target="_blank" href="https://twitter.com/intent/tweet?text='.$post->libelle.'&url='.url()->current().'"><i class="fa fa-twitter"></i></a>';
                    break;
                    case 'partageLinkedin':
                        $ajouter[] = '<a class="apss-linkedin" title="'.$champ->titre.'" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&title='.$post->libelle.'&url='.url()->current().'"><i class="fa fa-linkedin"></i></a>';
                    break;
                    case 'partageWhatsapp':
                        $ajouter[] = '<a class="apss-whatsapp" title="'.$champ->titre.'" target="_blank" href="https://api.whatsapp.com/send?text='.$post->libelle.' '.url()->current().'"><i class="fa fa-whatsapp"></i></a>';
                    break;
                    case 'partageMail':
                        $ajouter[] = '<a class="apss-mail" title="'.$champ->titre.'" target="_blank" href="mailto:?subject='.$post->libelle.' '.url()->current().'/&body=Hello! J\'ai trouvé cette information pour vous: "'.$post->libelle.'". Voici le lien: '.url()->current().'.\n Merci."><i class="fa fa-envelope"></i></a>';
                    break;
                    case 'facebookCommentaire':
                    $ajouter[] = '<div class="fb-comments" data-href="'.url()->current().'" data-width="" data-numposts=""></div>';
                    break;
                    case 'prix_nouveau':
                        if($post->prix_nouveau){
                            $ajouter[] = number_format($post->prix_nouveau, 0, '.', ' ').' Fcfa/'.$capacite->sous_titre;
                        }
                        else {
                            $ajouter[] = null;
                        }
                    break;
                    case 'prix_ancien':
                        if($post->prix_ancien){
                            $ajouter[] = number_format($post->prix_ancien, 0, '.', ' ').' Fcfa/'.$capacite->sous_titre;
                        }
                        else {
                            $ajouter[] = null;
                        }
                    break;
                    case 'solde':
                        if($post->prix_ancien and $post->prix_ancien > 0){
                            $solde = 100-($post->prix_nouveau*100)/$post->prix_ancien;
                            $ajouter[] = '-'.number_format($solde, 0, '.', ' ').'%';
                        }
                        else {
                            $ajouter[] = null;
                        }
                    break;
                    case 'ajoutPanier':
                        $ajouter[] = urlMode(url('cart/'.$post->id), $etat);
                        break;
                    case 'ajoutWishlist':
                        $ajouter[] = urlMode(url('wishlist/'.$post->id), $etat);
                        break;
                    case 'gallery':
                        if(!empty($post->getMedia($champ->libelle)->first())){
                            $ajouter[] = url($post->getMedia($champ->libelle)->first()->getUrl($typeImage));
                        }
                        else {
                            $ajouter[] = null;
                        }
                    break;

                    // Author
                    case 'userSlug':
                        if($post->user)
                            $ajouter[] = ($post->user->slug) ? urlMode(url($post->user->slug), $etat) : '';
                        else
                            $ajouter[] = '#';
                        break;
                    case 'userName':
                        if($post->user)
                            $ajouter[] = $post->user->name.' '.$post->user->prenom;
                        else
                            $ajouter[] = null;
                        break;
                    case 'userImage':
                        if($post->user){
                            if(!empty($post->user->getMedia('image')->first()))
                                $ajouter[] = url($post->user->getMedia('image')->first()->getUrl('thumb'));
                            else
                                $ajouter[] = url('admin/image/user.png');
                            break;
                        }

                    // Fournisseur
                    case 'fournisseurSlug':
                        if($post->fournisseur)
                            $ajouter[] = ($post->fournisseur->slug) ? urlMode(url($post->fournisseur->slug), $etat) : '';
                        else
                            $ajouter[] = '#';
                        break;
                    case 'fournisseurName':
                        if($post->fournisseur)
                            $ajouter[] = $post->fournisseur->name.' '.$post->fournisseur->prenom;
                        else
                            $ajouter[] = null;
                        break;
                    case 'fournisseurImage':
                        if($post->fournisseur){
                            if ($post->fournisseur->getMedia('image')->first()) {
                                $ajouter[] = url($post->fournisseur->getMedia('image')->first()->getUrl('thumb'));
                            }
                            else {
                                $ajouter[] = url('admin/image/user.png');
                            }
                        }
                        else
                            $ajouter[] = url('admin/image/user.png');
                        break;

                    default:
                        $ajouter[] = $post[$champ->libelle];
                    break;
                }
            }
            if ($additif and $j == 6) {
                $j = 0;
                $code .= str_replace($suppression, $ajouter, $apparence->description.'</div></div><div><div class="row mx-n2">');
            }
            else {
                $code .= str_replace($suppression, $ajouter, $apparence->description);
            }
        }
        //dd($code);
        $debut .= str_replace($suppression, $ajouter, $apparence->debut);
        $fin .= str_replace($suppression, $ajouter, $apparence->fin);
        if ($page == 'category') {
            return array('code' => $debut.$code.$fin, 'posts' => $posts, 'postsSansPaginate' => $postsSansPaginate);
        }
        else {
            return $debut.$code.$fin;
        }
    }
    else {
        if ($page == 'category') {
            return array('code' => null, 'posts' => $posts, 'postsSansPaginate' => $postsSansPaginate);
        }
        else {
            return null;
        }
    }

}


// Format de date
function format_datation($date_post)
{
    $date = Carbon::parse($date_post);
    $now = Carbon::now();
    $diff = $date->diffInDays($now);
    if ($date > $now) {
        return $date->diffForHumans();
    }
    elseif($diff > 7){
        return $date->translatedFormat('d F Y à H\hi');
    }
    else {
        return $date->diffForHumans();
    }
}


// categories e-commerce
function categorieEcommerce($taxonomie_id)
{
    $categories = Categorie::with([
        'childrens' => function($q){
            $q->with([
                'childrens' => function($q){
                    $q->with([
                        'childrens' => function($q){
                            $q->with([
                                'childrens' => function($q){
                                    $q->with([
                                        'posts'
                                    ]);
                                }
                            ]);
                        },
                        'posts',
                    ]);
                },
                'posts',
            ]);
        },
        'parent',
        'posts',
    ])/*
    ->whereIn(
        'id', [1, 2, 3]
    ) */
    ->where([
        'taxonomie_id' => $taxonomie_id, // id taxonomie of menu_admin
        'parent_id' => null,
    ])
    ->orderBy('created_at', 'asc')
    ->get();
    //dd($categories->toArray());
    return $categories;
}

// Afficher produits
function getProduits($slug, $limit = 8, $champATrier = 'id', $critereDeChoix = 'desc')
{
    $posts = Post::with([
        'categories',
        'user',
    ])
    ->whereHas('categories', function ($q) use($slug) {
        $q->where([
            'slug' => $slug,
        ]);
    })
    ->orderBy($champATrier, $critereDeChoix)
    ->take($limit)
    ->get();
    return $posts;
}


// Détails produit dans panier
function detailPanier($reference)
{
    $post = Post::with([
        'categories' => function ($q){
            $q->with([
                'parent' => function($q){
                    $q->with([
                        'parent'
                    ]);
                }
            ]);
        },
    ])
    ->where([
        'reference' => $reference,
    ])
    ->first();
    return $post;
}

// Traiement de catégories
function traitementCategory($post, $type)
{
    $category = null;
    foreach ($post->categories as $categorie) {
        if ($categorie->pivot->type == $type) {
            $category = $categorie;
            break;
        }
    }
    return $category;
}

// Vérifier si un float est entier
function isInteger($input){
    return ($input - (int)$input) > 0 ? false:true;
}

// Trouver le cout de livraison
function coutLivraison($total)
{
    if ($total < 25000) {
        return 1000;
    }
    else {
        return 0;
    }
}


// Durée générale de vie des cookies
function dureeCookie()
{
    return 60*60*24*7; // 7 jours
}

// Calcul de date de livraison
function dateLivraison($date, $commercial_id)
{
    if($date->format('D') == 'Sun'){
        $date->addDay();
        $message = 'La date de la livraison de votre commande étant un dimanche sera reportée au <strong class="font-size-lg">'.$date->formatLocalized('%A %d %B %Y').'</strong>';
        //$cookie = Cookie::make('dateLivraison', $date, dureeCookie());
    }
    elseif(!$commercial_id and date('H') >= 20 and $date->subDay() <= Carbon::today()){
        $date->addDay();
        if($date->format('D') == 'Sun'){
            $date->addDay();
            $message = 'La date de la livraison de votre commande étant un dimanche sera reportée au <strong class="font-size-lg">'.$date->formatLocalized('%A %d %B %Y').'</strong>';
        }
        else{
            $message = 'Votre date de livraison sera le <strong class="font-size-lg">'.$date->formatLocalized('%A %d %B %Y').'</strong> parce que votre commande a été passée après 20h';
        }
    }
    else{
        $message = 'La date de la livraison de votre commande : <strong class="font-size-lg">'.$date->formatLocalized('%A %d %B %Y').'</strong>';
    }
    return $arrayName = array('date' => $date, 'message' => $message);
}


// Mobile detect
function mobile_detect_devise()
{
    $detect = new Mobile_Detect;
    if ($detect->isMobile() && $detect->isiOS()) {
        $source_id = 353; // mobile iOS
    }
    elseif ($detect->isMobile() && $detect->isiPad()) {
        $source_id = 359; // iPad
    }
    elseif ($detect->isMobile() && $detect->isTablet()) {
        $source_id = 358; // Tablette Android
    }
    elseif ($detect->isMobile() && $detect->isAndroidOS()) {
        $source_id = 358; // Mobile Android
    }
    elseif (!$detect->isMobile()) {
        $source_id = 360; // Tablette Android
    }
    else {
        $source_id = 360;
    }
    return $source_id;
}


// Détails commandes
function detailCommande($field, $value)
{
    $commande = Commande::with([
        //'produits',
        //'user',
        //'adresse',
        //'livraison_mode',
        'etat',
        //'source',
        'heure',
        'mode_paiements',
        'mode_paiement',
        //'commercial',
    ])
    ->where([
        $field => $value,
    ])
    ->when(auth()->user(), function($q){
        return $q->where([
            'user_id' => auth()->user()->id,
        ])
        /* ->orWhere([
            'commercial_id' => auth()->user()->id,
        ]) */;
    })
    ->first();
    if (!$commande) {
        if (Cookie::get('invATR')) {
            $commande = Commande::with([
                //'produits',
                //'user',
                //'adresse',
                //'livraison_mode',
                'etat',
                //'source',
                'heure',
                'mode_paiements',
                'mode_paiement',
                //'commercial',
            ])
            ->where([
                $field => $value,
            ])
            ->when(auth()->user(), function($q){
                return $q->where([
                    'commercial_id' => auth()->user()->id,
                ])
                /* ->orWhere([
                    'commercial_id' => auth()->user()->id,
                ]) */;
            })
            ->first();
        }
    }
    return $commande;
}

// Ajout au panier les produits de la commande
function panierCommande($field, $value, $user)
{
    $commande = Commande::with([
        'produits' => function($q){
            $q->with([
                'categories'
            ]);
        },
        //'user',
        //'adresse',
        //'livraison_mode',
        'etat',
        //'source',
        'heure',
        'mode_paiements',
        //'commercial',
    ])
    ->where([
        $field => $value,
    ])
    ->first();

    if ($commande) {
        foreach ($commande->produits as $produit) {
            foreach ($produit->categories as $subdivision) {
                if ($subdivision->pivot->type == 'subdivision') {
                    break;
                }
            }
            Cart::instance('shopping')->add($produit->reference, $produit->libelle, $subdivision->sous_titre, $produit->prix_nouveau);
        }
        //if ($commande->user_id == null) {
            $commande->user_id = $user->id;
            $commande->save();
        //}
    }
    return $commande;
}

function devise($montant)
{
    return number_format($montant, 0, '.', ' ').' Fcfa';
}


// Conversion de date
function conversion_date($date)
{
    if(empty(request($date))){
        $date = null;
    }
    else{
        $date = Carbon::parse(request($date));
        $date = $date->format('Y-m-d');
    }
    return $date;
}


// Count
function countUser($users)
{
    $nbrSuperadmin = 0;
    $nbrAdmin = 0;
    $nbrGrossiste = 0;
    $nbrFournisseur = 0;
    $nbrDetaillant = 0;
    foreach ($users as $key => $value) {
        switch ($value->roles->first()->name) {
            case 'superadmin':
                $nbrSuperadmin++;
                break;
            case 'admin':
                $nbrAdmin++;
                break;
            case 'grossiste':
                $nbrGrossiste++;
                break;
            case 'fournisseur':
                $nbrFournisseur++;
                break;
            case 'detaillant':
                $nbrDetaillant++;
                break;
            default:
                # code...
                break;
        }
    }
    return array(
        'superadmin' => $nbrSuperadmin,
        'admin' => $nbrAdmin,
        'grossiste' => $nbrGrossiste,
        'fournisseur' => $nbrFournisseur,
        'detaillant' => $nbrDetaillant,
        'totalUsers' => count($users),
    );
}

// Fonction qui permet de récupérer la première date à laquelle une commande a été passée
function get_first_date_order($commandes){
    $commandes=collect($commandes)->sortBy('created_at')->first();
    return Carbon::parse($commandes->created_at);
}

// Fonction qui permet de récupérer la première date à laquelle une commande a été passée
function get_date_order($commandes, $periode, $format = "date"){
    if (count($commandes)) {
        $commandes = collect($commandes)->$periode('created_at')->first();
        if ($format == 'date') {
            return Carbon::parse($commandes->created_at);
        }
        else {
            return Carbon::parse($commandes->created_at)->format($format);
        }
    }
    else {
        return null;
    }

    /* switch ($format) {
        case 'date':
            $commandes=collect($commandes)->$periode('created_at')->first();
            return Carbon::parse($commandes->created_at);
            break;
        case 'years':
            $commandes=collect($commandes)->$periode('created_at')->first();
            return Carbon::parse($commandes->created_at)->format('Y');
        case 'days':
            $commandes=collect($commandes)->$periode('created_at')->first();
            return Carbon::parse($commandes->created_at)->format('d');
        case 'month':
            $commandes=collect($commandes)->$periode('created_at')->first();
            return Carbon::parse($commandes->created_at)->format('m');
        case 'hour':
            $commandes=collect($commandes)->$periode('created_at')->first();
            return Carbon::parse($commandes->created_at)->format('H');
        default:
            # code...
            break;
    } */
}

//Organisation d'un te]ableau commande par année
function commande_periode($commandes){
    if (count($commandes)) {
        $first_date = get_date_order($commandes, 'sortBy', 'date');
        $last_date = get_date_order($commandes, 'sortByDesc', 'date');
        //dd($last_date);
        $diffDays = $first_date->diffInDays($last_date);
        $order_array=array();

        if ($diffDays >= 365) {
            $first_period = $first_date;
            $last_period = $last_date->format('Y-12-31 23:59:59');
            $type_period = 'Y';
        }
        elseif ($diffDays < 365 and $diffDays > 30) {
            $first_period = $first_date;
            $last_period = $last_date->format('Y-m-31 23:59:59');
            $last_period = Carbon::parse($last_period);
            //dd($last_period);
            $type_period = 'F-Y';
        }
        elseif ($diffDays <= 30) {
            $first_period = $first_date;
            $last_period = $last_date->format('Y-m-d 23:59:59');
            $type_period = 'd-m-Y';
        }

        $i = $first_period;
        do {
            if ($diffDays >= 365) {
                $orders = collect($commandes)->whereBetween("created_at", [$i->format('Y-01-01 00:00:00'),  $i->format('Y-12-31 23:59:59')]);
                $period = $i->format('Y');
            }
            elseif ($diffDays < 365 and $diffDays > 30) {
                $orders = collect($commandes)->whereBetween("created_at", [$i->format('Y-m-01 00:00:00'),  $i->format('Y-m-31 23:59:59')]);
                $period = $i->format('F-Y');
            }
            elseif ($diffDays <= 30) {
                $orders = collect($commandes)->whereBetween("created_at", [$i->format('Y-m-d 00:00:00'),  $i->format('Y-m-d 23:59:59')]);
                $period = $i->format('d-m-Y');
            }
            // Commandes livrées
            $commande_livrer = $orders->where('etat_id', 110);
            $nombre_commande_livrer = $commande_livrer->count();
            $gain = $commande_livrer->sum('total_commande');

            // Commandes annulées
            $commande_annuler = $orders->where('etat_id', 112);
            $nombre_commande_annuler = $commande_annuler->count();
            $total_commande_annuler = $commande_annuler->sum('total_commande');
            $manque_a_gagne = $commande_annuler->sum('total_commande');

            // Commande en attente
            $commande_en_attente = $orders->where('etat_id', 111);
            $total_commande_en_attente = $commande_en_attente->sum('total_commande');
            //dd($total_annuler);
            $orders = array(
                'period' => $period,
                'first_period' => $i->format('Y-m-01 00:00:00'),
                'last_period' => $i->format('Y-m-31 23:59:59'),
                'type' => $type_period,
                'commandes' => $orders,
                'nombre_commande_livrer' => $nombre_commande_livrer,
                'gain' => $gain,
                'com_att'=>$total_commande_en_attente,
                'nombre_commande_annuler' => $nombre_commande_annuler,
                'manque_a_gagne' => $manque_a_gagne,
                'total_commande_en_attente' => $total_commande_en_attente,
                'commande_en_attente' => $commande_en_attente,
                'total_commande_annuler' => $total_commande_annuler,
            );
            //dd($orders);
            array_push($order_array, $orders);
            if ($diffDays >= 365) {
                $i = $i->addYear();
            }
            if ($diffDays < 365 and $diffDays > 30) {
                $i = $i->addMonthsNoOverflow();
            }
            elseif ($diffDays <= 30) {
                $i = $i->addDay();
            }
        } while ($i <= $last_period);
        //dd($i);
        /* for($i = $first_period; $i<=$last_period; $i++){
            if ($diffDays >= 365) {
                $orders = collect($commandes)->whereBetween("created_at", [$i."-01-01", $i."-12-31"]);
            }
            elseif ($diffDays < 365) {
                $orders = collect($commandes)->whereBetween("created_at", [$first_years."-".$i."-01", $first_years."-".$i."-31"]);
            }
            elseif ($diffDays <= 30) {
                $first_period = $first_date->format('m');
                $last_period = $last_date->format('m');
            }

            // Commandes livrées
            $commande_livrer = $orders->where('etat_id', 110);
            $nombre_commande_livrer = $commande_livrer->count();
            $gain = $commande_livrer->sum('total_commande');

            // Commandes annulées
            $commande_annuler = $orders->where('etat_id', 112);
            $nombre_commande_annuler = $commande_annuler->count();
            $manque_a_gagne = $commande_annuler->sum('total_commande');
            $commande_en_attente=$orders->where('etat_id', 111);

            //dd($total_annuler);
            $orders = array(
                'year' => $i,
                'commandes' => $orders,
                'nombre_commande_livrer' => $nombre_commande_livrer,
                'gain' => $gain,
                'nombre_commande_annuler' => $nombre_commande_annuler,
                'manque_a_gagne' => $manque_a_gagne,
                'commande_en_attente' => $commande_en_attente,
            );
            array_push($order_array, $orders);
            if ($diffDays < 365) {
                if ($last_period2 < $first_period) {
                    if ($i == 12) {
                        $first_period = 1;
                        $last_period = $last_period2;
                        $first_years += $first_years;
                    }
                }
            }
        } */
        $cout_total = collect($commandes)->where('etat_id', 110)->sum('total_commande');
        $manque_a_gagne_total=collect($commandes)->where('etat_id',112)->sum('total_commande');
        $cout_total_commande_en_att=collect($commandes)->where('etat_id',111)->sum('total_commande');
        $nombre_commande_livrer=collect($commandes)->where('etat_id', 110)->count();
        $nombre_commande_annuler=collect($commandes)->where('etat_id',112)->count();
        $nombre_commande_en_attente=collect($commandes)->where('etat_id',111)->count();
        $collection = [
            'commande' => $order_array,
            'cout_total' => $cout_total,
            'cout_total_com_att'=>$cout_total_commande_en_att,
            'manque_a_gagne_total' => $manque_a_gagne_total,
            'nombre_commande_livrer' => $nombre_commande_livrer,
            'nombre_commande_annuler' => $nombre_commande_annuler,
            'nombre_commande_en_attente' => $nombre_commande_en_attente
        ];
        //dd($order_array);
        return $collection;
    }
    else {
        return null;
    }

}

/* function get_delivery_order($commande){
    $verifier=true;
    $commandes_livree={};
    while($verifier){
        $delivery_order=$commande->etat_id;
        if($delivery_order==110){
            array_push($commandes_livrees,$commande->id);
        }
    }
} */

//Fonction qui permet d'avoir des informations sur la session de l'user
function get_user_agent($user_agent){
    $bname = 'Unknown';
    $platform = 'Unknown';

    //First get the platform?
    if (preg_match('/linux/i', $user_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $user_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$user_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$user_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$user_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$user_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$user_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    return array($bname,$platform);
}

function active_filter()
{
    $activeArray = array(
        'date' => array(
            'active' => null,
            'fawesone' => 'fa-square-o',
        ),
        'priceAsc' => array(
            'active' => null,
            'fawesone' => 'fa-square-o',
        ),
        'priceDesc' => array(
            'active' => null,
            'fawesone' => 'fa-square-o',
        ),
        //'search' => "'id', 'desc'",
        'search' => array(
            'tri' => 'id',
            'valueTri' => 'desc'
        )
    );

    switch (request('filter')) {
        case 'date':
            $activeArray = array(
                'date' => array(
                    'active' => 'active',
                    'fawesone' => 'fa-check-square-o',
                ),
                'priceAsc' => array(
                    'active' => null,
                    'fawesone' => 'fa-square-o',
                ),
                'priceDesc' => array(
                    'active' => null,
                    'fawesone' => 'fa-square-o',
                ),
                'search' => array(
                    'tri' => 'id',
                    'valueTri' => 'desc'
                )
            );
            break;
        case 'priceAsc':
            $activeArray = array(
                'date' => array(
                    'active' => null,
                    'fawesone' => 'fa-square-o',
                ),
                'priceAsc' => array(
                    'active' => 'active',
                    'fawesone' => 'fa-check-square-o',
                ),
                'priceDesc' => array(
                    'active' => null,
                    'fawesone' => 'fa-square-o',
                ),
                'search' => array(
                    'tri' => 'prix_nouveau',
                    'valueTri' => 'asc'
                )
            );
            break;
        case 'priceDesc':
            $activeArray = array(
                'date' => array(
                    'active' => null,
                    'fawesone' => 'fa-square-o',
                ),
                'priceAsc' => array(
                    'active' => null,
                    'fawesone' => 'fa-square-o',
                ),
                'priceDesc' => array(
                    'active' => 'active',
                    'fawesone' => 'fa-check-square-o',
                ),
                'search' => array(
                    'tri' => 'prix_nouveau',
                    'valueTri' => 'desc'
                )
            );
            break;

        default:
            # code...
            break;
    }
    return $activeArray;
}

// Détails d'un post, d'une catégorie...
function lienPost($id, $model, $class = null)
{
    switch ($model) {
        case 'post':
            $value = Post::find($id);
            if ($value) {
                return '<a class="'.$class.'" href="'.url($value->slug).'">
                    '.$value->libelle.'
                </a>';
            }

        break;
        case 'categorie':
            $value = Categorie::find($id);
            if ($value) {
                return '<a class="'.$class.'" href="'.url('category/'.$value->slug).'">
                    '.$value->libelle.'
                </a>';
            }

        break;
        default:
            # code...
            break;
    }
}

// Durée d'une session
function duree_session()
{
    return $lastActivity = strtotime(Carbon::now()->subMinutes(5));
}


// Commandes en fonction des etats, de la date...
function stat_commandes($etat, $champ, $date = null)
{
    $commandes = Commande::select(DB::raw("COUNT(id) as nombre, SUM(total_commande) as montant"))
    ->when(($date), function($q) use($date) {
        return $q->whereBetween('created_at', [$date['first'], $date['last']]);
    })
    ->where('etat_id', $etat)
    ->first();
    if ($commandes) {
        if (!$commandes->montant) {
            $commandes->montant = 0;
        }
        return $commandes->$champ;
    }
    else {
        return '0';
    }
}


// Retouner au panier quand il ya aucun produit au panier
function return_panier()
{
    if (!count(Cart::instance('shopping')->content())){
        Alert::warning('Panier', 'Vous n\'avez aucun produit dans le panier');
        return redirect('panier');
    }
}
