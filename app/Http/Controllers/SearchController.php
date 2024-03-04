<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchArticle($limit = 30)
    {
        $category_name = request('category_name');
        $term_search = request('term_search');

        $elementDeTri = Categorie::with([
            'parent'
        ])
        ->where([
            'taxonomie_id' => 38,
        ])
        ->orderBy('id', 'desc')
        ->get();
        if ($category_name) {
            $categorie_id = $category_name;
        }
        else {
            $categorie_id = 229;
        }

        $parametre = parametre_web();

        // Journalisation
        activity()
            ->log('search produits');
        // End journalisation

        return view('web.cart.search-produit')->with([
            'categorie_id' => $categorie_id,
            'elementDeTri' => $elementDeTri,
            'parametre' => $parametre,
            'infosPage' => array(
                'title' => 'Recherche de produit',
                'slug' => 'search',
            ),
        ]);
    }
}
