<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->double('quantite_produit')->nullable();
            $table->double('cout_commande')->nullable();
            $table->double('cout_livraison')->nullable();
            $table->double('total_commande')->nullable();
            $table->dateTime('date_livraison')->nullable();
            $table->enum('type', ['service', 'produit'])->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->unsignedBigInteger('adresse_id')->nullable();
            $table->unsignedBigInteger('livraison_mode_id')->nullable(); // Lier à post
            $table->unsignedBigInteger('livraison_point_id')->nullable(); // Lier à post
            $table->unsignedBigInteger('livraison_agence_id')->nullable(); // Lier à post
            // $table->unsignedBigInteger('moyen_paiement_id')->nullable(); // Lier à post // Une commande peut avoir plusieurs moyens de paiement donc création d'une table
            $table->unsignedBigInteger('etat_id')->nullable(); // Lier à categorie
            $table->unsignedBigInteger('source_id')->nullable(); // Lier à categorie
            $table->unsignedBigInteger('heure_id')->nullable(); // Lier à categorie
            $table->unsignedBigInteger('mode_paiement_id')->nullable(); // Lier à categorie
            $table->unsignedBigInteger('commercial_id')->nullable(); // Lier à user
            $table->timestamps();
            $table->softDeletes();
            $table->json('paiement')->nullable();
            $table->string('token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commandes');
    }
}
