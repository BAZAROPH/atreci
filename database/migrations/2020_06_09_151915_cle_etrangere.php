<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleEtrangere extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_user')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('users');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('taxonomie_id')->references('id')->on('taxonomies');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('categories');
        });

        Schema::table('taxonomies', function (Blueprint $table) {
            $table->foreign('type_taxonomies_id')->references('id')->on('type_taxonomies');
        });

        Schema::table('champs', function (Blueprint $table) {
            $table->foreign('type_champ_id')->references('id')->on('taxonomies');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lier_id')->references('id')->on('posts');
        });

        Schema::table('commandes', function (Blueprint $table) {
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('adresse_id')->references('id')->on('posts');
            $table->foreign('livraison_mode_id')->references('id')->on('categories');
            $table->foreign('livraison_point_id')->references('id')->on('posts');
            $table->foreign('livraison_agence_id')->references('id')->on('posts');
            $table->foreign('etat_id')->references('id')->on('categories');
            $table->foreign('source_id')->references('id')->on('categories');
            $table->foreign('heure_id')->references('id')->on('categories');
            $table->foreign('mode_paiement_id')->references('id')->on('categories');
            $table->foreign('commercial_id')->references('id')->on('users');
        });

        Schema::table('parametres', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('categories');
        });

        Schema::table('apparences', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('categories_champs', function (Blueprint $table) {
            $table->foreign('categorie_id')->references('id')->on('categories');
            $table->foreign('champ_id')->references('id')->on('champs');
        });

        Schema::table('categories_posts', function (Blueprint $table) {
            $table->foreign('categorie_id')->references('id')->on('categories');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('apparences_categories', function (Blueprint $table) {
            $table->foreign('apparence_id')->references('id')->on('apparences');
            $table->foreign('categorie_id')->references('id')->on('categories');
        });

        Schema::table('commentaires', function (Blueprint $table) {
            $table->foreign('posts_id')->references('id')->on('posts');
            $table->foreign('avis_id')->references('id')->on('categories');
            $table->foreign('users_id')->references('id')->on('users');
        });

        Schema::table('commandes_posts', function (Blueprint $table) {
            $table->foreign('commande_id')->references('id')->on('commandes');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('versements', function (Blueprint $table) {
            $table->foreign('commandes_id')->references('id')->on('commandes');
            $table->foreign('boosters_id')->references('id')->on('posts');
            $table->foreign('moyen_paiements_id')->references('id')->on('posts');
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('users_createur_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
