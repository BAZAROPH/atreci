<?php

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WebController@index');
Route::get('/accueil', 'WebController@index');

Route::get('products','webController@all');
Route::get('advanced-search','webController@advanced_search');
Route::get('categories','webController@categories');

Route::get('migration-categorie', 'WebController@migration_categorie');
Route::get('migration-pays', 'WebController@migration_pays');
Route::get('migration-user', 'WebController@migration_user');
Route::get('delete-migration', 'WebController@migration_delete');

Route::get('parrain/{matricule}', 'WebController@registerMatricule');
Route::post('findMatricule', 'WebController@findMatricule');

Route::get('/search', 'SearchController@searchArticle')->name('search');

// this route can return the state with the state id
Route::get('findChildrens/{id}','WebController@findChildrens');


Auth::routes();

// OAuth Routes
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::group(['middleware' => ['role:superadmin|admin']],
    function() {
        Route::get('/celestadmin', 'HomeController@index');

        //Route des statistiques de commandes
        Route::get('celestadmin/commandes/statistics','StatistiqueController@commandes')->name('commandes.statistique');

        //Route des statistiques de commandes
        Route::get('celestadmin/users/statistics','StatistiqueController@users')->name('users.statistique');

        // Type Taxonomies
        Route::group(['middleware' => ['permission:type-taxonomies index']], function () {
            Route::get('/celestadmin/type-taxonomies', 'TypeTaxonomieController@index');
        });
        Route::group(['middleware' => ['permission:type-taxonomies create']], function () {
            Route::get('/celestadmin/type-taxonomies/create', 'TypeTaxonomieController@create');
            Route::post('/celestadmin/type-taxonomies/create', 'TypeTaxonomieController@store');
        });
        Route::group(['middleware' => ['permission:type-taxonomies edit']], function () {
            Route::get('/celestadmin/type-taxonomies/edit/{id}', 'TypeTaxonomieController@edit');
            Route::post('/celestadmin/type-taxonomies/edit/{id}', 'TypeTaxonomieController@update');
        });
        Route::group(['middleware' => ['permission:type-taxonomies delete']], function () {
            Route::post('/celestadmin/type-taxonomies/delete/{id}', 'TypeTaxonomieController@destroy');
        });
        Route::group(['middleware' => ['permission:type-taxonomies trash']], function () {
            Route::post('/celestadmin/type-taxonomies/corbeille/{id}', 'TypeTaxonomieController@corbeille');
        });
        Route::group(['middleware' => ['permission:type-taxonomies restore']], function () {
            Route::post('/celestadmin/type-taxonomies/restaurer/{id}', 'TypeTaxonomieController@restaurer');
        });

        // Taxonomies
        Route::group(['middleware' => ['permission:taxonomies index']], function () {
            Route::get('/celestadmin/taxonomies', 'TaxonomieController@index');
        });
        Route::group(['middleware' => ['permission:taxonomies create']], function () {
            Route::get('/celestadmin/taxonomies/create', 'TaxonomieController@create');
            Route::post('/celestadmin/taxonomies/create', 'TaxonomieController@store');
        });
        Route::group(['middleware' => ['permission:taxonomies edit']], function () {
            Route::get('/celestadmin/taxonomies/edit/{id}', 'TaxonomieController@edit');
            Route::post('/celestadmin/taxonomies/edit/{id}', 'TaxonomieController@update');
        });
        Route::group(['middleware' => ['permission:taxonomies delete']], function () {
            Route::post('/celestadmin/taxonomies/delete/{id}', 'TaxonomieController@destroy');
        });

        Route::group(['middleware' => ['permission:taxonomies trash']], function () {
            Route::post('/celestadmin/taxonomies/corbeille/{id}', 'TaxonomieController@corbeille');
        });
        Route::group(['middleware' => ['permission:taxonomies restore']], function () {
            Route::post('/celestadmin/taxonomies/restaurer/{id}', 'TaxonomieController@restaurer');
        });

        // Permissions
        Route::group(['middleware' => ['permission:permissions index']], function () {
            Route::get('/celestadmin/permissions', 'PermissionController@index')->name('permissions');
        });
        Route::group(['middleware' => ['permission:permissions create']], function () {
            Route::get('/celestadmin/permissions/create', 'PermissionController@create');
            Route::post('/celestadmin/permissions/create', 'PermissionController@store');
        });
        Route::group(['middleware' => ['permission:permissions edit']], function () {
            Route::get('/celestadmin/permissions/edit/{id}', 'PermissionController@edit');
            Route::post('/celestadmin/permissions/edit/{id}', 'PermissionController@update');
        });
        Route::group(['middleware' => ['permission:permissions delete']], function () {
            Route::post('/celestadmin/permissions/delete/{id}', 'PermissionController@destroy');
        });

        Route::group(['middleware' => ['permission:permissions trash']], function () {
            Route::post('/celestadmin/permissions/corbeille/{id}', 'PermissionController@corbeille');
        });
        Route::group(['middleware' => ['permission:permissions restore']], function () {
            Route::post('/celestadmin/permissions/restaurer/{id}', 'PermissionController@restaurer');
        });

        // Roles
        Route::group(['middleware' => ['permission:roles index']], function () {
            Route::get('/celestadmin/roles', 'RoleController@index')->name('roles');
        });
        Route::group(['middleware' => ['permission:roles create']], function () {
            Route::get('/celestadmin/roles/create', 'RoleController@create');
            Route::post('/celestadmin/roles/create', 'RoleController@store');
        });
        Route::group(['middleware' => ['permission:roles edit']], function () {
            Route::get('/celestadmin/roles/edit/{id}', 'RoleController@edit');
            Route::post('/celestadmin/roles/edit/{id}', 'RoleController@update');
        });
        Route::group(['middleware' => ['permission:roles delete']], function () {
            Route::post('/celestadmin/roles/delete/{id}', 'RoleController@destroy');
        });

        Route::group(['middleware' => ['permission:roles trash']], function () {
            Route::post('/celestadmin/roles/corbeille/{id}', 'RoleController@corbeille');
        });
        Route::group(['middleware' => ['permission:roles restore']], function () {
            Route::post('/celestadmin/roles/restaurer/{id}', 'RoleController@restaurer');
        });

        // Users
        Route::group(['middleware' => ['permission:users index']], function () {
            Route::get('/celestadmin/users', 'UserController@index')->name('user.index');
        });
        Route::group(['middleware' => ['permission:users create']], function () {
            Route::get('/celestadmin/users/create', 'UserController@create')->name('user.create');
            Route::post('/celestadmin/users/create', 'UserController@store')->name('user.store');
        });
        Route::group(['middleware' => ['permission:users show']], function () {
            Route::get('/celestadmin/users/{user}', 'UserController@show')->name('user.show');
        });
        Route::group(['middleware' => ['permission:users edit']], function () {
            Route::get('/celestadmin/users/edit/{id}', 'UserController@edit')->name('user.edit');
            Route::post('/celestadmin/users/edit/{id}', 'UserController@update')->name('user.update');
        });
        Route::group(['middleware' => ['permission:users delete']], function () {
            Route::post('/celestadmin/users/delete/{id}', 'UserController@destroy')->name('user.destroy');
        });

        Route::group(['middleware' => ['permission:users trash']], function () {
            Route::post('/celestadmin/users/corbeille/{id}', 'UserController@corbeille');
        });
        Route::group(['middleware' => ['permission:users restore']], function () {
            Route::post('/celestadmin/users/restaurer/{id}', 'UserController@restaurer');
        });
        Route::group(['middleware' => ['permission:users validation']], function () {
            Route::post('/celestadmin/users/valide/{id}', 'UserController@validation');
        });

        // Champs
        Route::group(['middleware' => ['permission:champs index']], function () {
            Route::get('/celestadmin/champs', 'ChampController@index');
        });
        Route::group(['middleware' => ['permission:champs create']], function () {
            Route::get('/celestadmin/champs/create', 'ChampController@create');
            Route::post('/celestadmin/champs/create', 'ChampController@store');
        });
        Route::group(['middleware' => ['permission:champs edit']], function () {
            Route::get('/celestadmin/champs/edit/{id}', 'ChampController@edit');
            Route::post('/celestadmin/champs/edit/{id}', 'ChampController@update');
        });
        Route::group(['middleware' => ['permission:champs delete']], function () {
            Route::post('/celestadmin/champs/delete/{id}', 'ChampController@destroy');
        });

        Route::group(['middleware' => ['permission:champs trash']], function () {
            Route::post('/celestadmin/champs/corbeille/{id}', 'ChampController@corbeille');
        });
        Route::group(['middleware' => ['permission:champs restore']], function () {
            Route::post('/celestadmin/champs/restaurer/{id}', 'ChampController@restaurer');
        });

        // Apparences
        Route::group(['middleware' => ['permission:apparences index']], function () {
            Route::get('/celestadmin/apparences', 'ApparenceController@index');
        });
        Route::group(['middleware' => ['permission:apparences create']], function () {
            Route::get('/celestadmin/apparences/create', 'ApparenceController@create');
            Route::post('/celestadmin/apparences/create', 'ApparenceController@store');
        });
        Route::group(['middleware' => ['permission:apparences edit']], function () {
            Route::get('/celestadmin/apparences/edit/{id}', 'ApparenceController@edit');
            Route::post('/celestadmin/apparences/edit/{id}', 'ApparenceController@update');
        });
        Route::group(['middleware' => ['permission:apparences delete']], function () {
            Route::post('/celestadmin/apparences/delete/{id}', 'ApparenceController@destroy');
        });

        Route::group(['middleware' => ['permission:apparences trash']], function () {
            Route::post('/celestadmin/apparences/corbeille/{id}', 'ApparenceController@corbeille');
        });
        Route::group(['middleware' => ['permission:apparences restore']], function () {
            Route::post('/celestadmin/apparences/restaurer/{id}', 'ApparenceController@restaurer');
        });

        // Parametre
        Route::group(['middleware' => ['permission:parametres index']], function () {
            Route::get('/celestadmin/parametres', 'ParametreController@index');
        });
        Route::group(['middleware' => ['permission:parametres create']], function () {
            Route::get('/celestadmin/parametres/create', 'ParametreController@create');
            Route::post('/celestadmin/parametres/create', 'ParametreController@store');
        });
        Route::group(['middleware' => ['permission:parametres edit']], function () {
            Route::get('/celestadmin/parametres/edit/{id}', 'ParametreController@edit');
            Route::post('/celestadmin/parametres/edit/{id}', 'ParametreController@update');
        });
        Route::group(['middleware' => ['permission:parametres delete']], function () {
            Route::post('/celestadmin/parametres/delete/{id}', 'ParametreController@destroy');
        });

        Route::group(['middleware' => ['permission:parametres trash']], function () {
            Route::post('/celestadmin/parametres/corbeille/{id}', 'ParametreController@corbeille');
        });
        Route::group(['middleware' => ['permission:parametres restore']], function () {
            Route::post('/celestadmin/parametres/restaurer/{id}', 'ParametreController@restaurer');
        });

        // Commande
        Route::group(['middleware' => ['permission:commandes panier']], function () {
            Route::get('/celestadmin/commandes/panier', 'CommandeController@panier')->name('panier.index');
        });
        Route::group(['middleware' => ['permission:commandes index']], function () {
            Route::get('/celestadmin/commandes', 'CommandeController@index')->name('commandes');
        });
        Route::group(['middleware' => ['permission:commandes show']], function () {
            Route::get('/celestadmin/commandes/{commande}', 'CommandeController@show')->name('commande.show');
        });
        Route::group(['middleware' => ['permission:commandes print']], function () {
            Route::get('/celestadmin/commandes/{commande}/{download}', 'CommandeController@print')->name('commande.print');
        });

        Route::group(['middleware' => ['permission:commandes versement']], function () {
            Route::post('/celestadmin/commandes/{commande}', 'CommandeController@versementCommande');
        });
        Route::group(['middleware' => ['permission:commandes delete']], function () {
            Route::post('/celestadmin/commandes/delete/{id}', 'CommandeController@destroy');
        });

        Route::group(['middleware' => ['permission:commandes trash']], function () {
            Route::post('/celestadmin/commandes/corbeille/{id}', 'ParametreController@corbeille');
        });
        Route::group(['middleware' => ['permission:commandes trash']], function () {
            Route::post('/celestadmin/commandes/restaurer/{id}', 'ParametreController@restaurer');
        });

        Route::get('/celestadmin/pdfview/{commande}', 'CommandeController@pdfview')->name('pdfview');

        // Pages
        Route::group(['middleware' => ['permission:pages index']], function () {
            Route::get('/celestadmin/pages', 'PageController@index');
        });
        Route::group(['middleware' => ['permission:pages create']], function () {
            Route::get('/celestadmin/pages/create', 'PageController@create');
            Route::post('/celestadmin/pages/create', 'PageController@store');
        });
        Route::group(['middleware' => ['permission:pages edit']], function () {
            Route::get('/celestadmin/pages/edit/{id}', 'PageController@edit');
            Route::post('/celestadmin/pages/edit/{id}', 'PageController@update');
        });
        Route::group(['middleware' => ['permission:pages delete']], function () {
            Route::post('/celestadmin/pages/delete/{id}', 'PageController@destroy');
        });

        Route::group(['middleware' => ['permission:pages trash']], function () {
            Route::post('/celestadmin/pages/corbeille/{id}', 'PageController@corbeille');
        });
        Route::group(['middleware' => ['permission:pages restore']], function () {
            Route::post('/celestadmin/pages/restaurer/{id}', 'PageController@restaurer');
        });

        // Catégories
        Route::get('/celestadmin/{slug}', 'CategorieController@index');
        Route::get('/celestadmin/{slug}/create', 'CategorieController@create');
        Route::post('/celestadmin/{slug}/create', 'CategorieController@store');
        Route::get('/celestadmin/{slug}/edit/{id}', 'CategorieController@edit');
        Route::get('/celestadmin/{slug}/filter/{id}', 'CategorieController@filter');
        Route::post('/celestadmin/{slug}/edit/{id}', 'CategorieController@update');
        Route::post('/celestadmin/{slug}/filter/{id}', 'CategorieController@filter_update');
        Route::post('/celestadmin/{slug}/delete/{id}', 'CategorieController@destroy');

        Route::post('/celestadmin/{slug}/corbeille/{id}', 'CategorieController@corbeille');
        Route::post('/celestadmin/{slug}/restaurer/{id}', 'CategorieController@restaurer');

        // Post
        Route::get('/celestadmin/p/{slug}', 'PostController@index');
        Route::get('/celestadmin/p/{slug}/create', 'PostController@create');
        Route::post('/celestadmin/p/{slug}/create', 'PostController@store');
        Route::get('/celestadmin/p/{slug}/edit/{id}', 'PostController@edit');
        Route::post('/celestadmin/p/{slug}/edit/{id}', 'PostController@update');
        Route::post('/celestadmin/p/{slug}/delete/{id}', 'PostController@destroy');

        Route::post('/celestadmin/p/{slug}/corbeille/{id}', 'PostController@corbeille');
        Route::post('/celestadmin/p/{slug}/restaurer/{id}', 'PostController@restaurer');

        Route::post('/celestadmin/media/delete/{id}', 'PostController@destroy_media');

        Route::get('/celestadmin/statistique/users', 'StatistiqueController@index');
    }
);

Route::group([
    'middleware' => [
        //'App\Http\Middleware\FinalisationInscription',
        'App\Http\Middleware\Authenticate',
        ]
    ], function() {
    Route::get('/profil', 'UserController@profil')->name('profil');
    Route::get('/profil/edit', 'UserController@edit_member');
    Route::post('/profil/edit', 'UserController@update_member');
    Route::get('/profil/picture', 'UserController@edit_picture');
    Route::post('/profil/picture', 'UserController@update_picture');
    Route::get('/profil/password', 'UserController@edit_password');
    Route::post('/profil/password', 'UserController@update_password');
    Route::get('/profil/type', 'UserController@type_compte')->name('typeCompte');
    Route::get('/profil/commande', 'UserController@commande')->name('commande');
    Route::get('/profil/repasser/{id}','UserController@repasser')->name('commande-repasser');
    Route::get('/profil/adresse', 'UserController@adresse')->name('adresse');

    // Routes checkout
    Route::get('/commercial', 'CartShoppingController@compteCommercial')->name('compteCommercial');
    Route::get('/adresse-de-livraison', 'CartShoppingController@adresseLivraison')->name('adresseLivraison');
    Route::get('/date-de-livraison', 'CartShoppingController@dateLivraison')->name('dateLivraison');
    Route::post('/choix-date', 'CartShoppingController@choixDate')->name('choixDate');
    Route::get('/heure-de-livraison', 'CartShoppingController@heureLivraison')->name('heureLivraison');
    Route::post('/choix-heure', 'CartShoppingController@choixHeure')->name('choixHeure');
    Route::get('/mode-de-paiement', 'CartShoppingController@modePaiement')->name('modePaiement');
    Route::post('/mode-de-paiement', 'CartShoppingController@moyenPaiement');
    Route::get('/confirmation', 'CartShoppingController@confirmation')->name('confirmation');
    Route::post('/confirmation', 'CartShoppingController@validation')->name('validation');
    Route::get('/status-payment', 'CartShoppingController@statusPayment')->name('statusPayment');
    Route::get('/felicitation/{reference}', 'CartShoppingController@felicitation')->name('felicitation');

    Route::post('/addAddress', 'CartShoppingController@addAddress')->name('addAddress');
    Route::post('/editAddress/{id}', 'CartShoppingController@editAddress');
    Route::post('/deleteAddress/{id}', 'CartShoppingController@deleteAddress');

    Route::post('/addUser', 'CartShoppingController@addUser')->name('addUser');
    Route::post('/editUser/{id}', 'CartShoppingController@editUser');


});

Route::post('/storeMedia', 'PostController@storeMedia')->name('storeMedia');

Route::get('test', function () {
    /* $cart = Cart::instance('shopping');
    $cart->add(
        ['id' => '482k', 'name' => 'Product 2', 'qty' => 1, 'price' => 10.00, 'weight' => 550, 'options' => ['size' => 'large']]
    ); */
    return (Cart::instance('shopping')->content());
    //Cart::instance('shopping')->destroy();
});
Route::get('/cart/{id}', 'CartShoppingController@addCart')->name('addCart');
Route::get('/wishlist/{id}', 'CartShoppingController@addWishlist')->name('addWishlist');
Route::get('cart', function () {
    return Cart::instance('shopping')->content();
    //dd(Cart::content()->toArray());
});

Route::get('/panier', 'CartShoppingController@panier')->name('panier');
Route::get('/wishlist', 'CartShoppingController@wishlist')->name('wishlist');

//Route::get('utilisateurs', ['uses'=>'UserController@getIndex', 'as'=>'utilisateurs']);

Route::get('/{slug}', 'WebController@showPost');
Route::get('/category/{slug}', 'WebController@showCategorie');

//Route::get('/{categorie_slug}/{slug}', 'WebController@showPost');
