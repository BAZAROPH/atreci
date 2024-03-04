<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('rang')->nullable();
            $table->boolean('visibilite')->nullable()->default(1);
            $table->boolean('corbeille')->nullable()->default(1);
            $table->boolean('est_vendu')->nullable();
            $table->boolean('est_nouveau')->nullable();
            $table->string('libelle')->nullable();
            $table->string('sous_titre')->nullable();
            $table->text('description')->nullable();
            $table->text('resume')->nullable();
            $table->text('caracteristique')->nullable();
            $table->string('lien')->nullable();
            $table->string('fonction')->nullable();
            $table->string('localisation')->nullable();
            $table->double('prix_nouveau')->nullable();
            $table->string('prix_ancien')->nullable();
            $table->string('poids')->nullable();
            $table->double('x_produit')->nullable(); // Dans le cas de la gestion du stock
            $table->bigInteger('x_utilisation')->nullable(); // Nombre de fois utiliser pour les réductions
            $table->string('icon')->nullable();
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_fin')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('surface')->nullable();
            $table->string('piece')->nullable();
            $table->string('salle_bain')->nullable();
            $table->string('etage')->nullable();
            $table->string('annee')->nullable();
            $table->string('kilometrage')->nullable();
            $table->string('x_place')->nullable();
            $table->dateTime('date_planification')->nullable(); // Programmer la date d'affichage de la publication
            $table->dateTime('antidater')->nullable(); // Changer la date de publication
            //$table->enum('gestion_stock', ['1', '0'])->nullable();
            //$table->enum('slider', ['1', '0'])->nullable();
            //$table->enum('etat', ['neuf', 'occasion', 'autre'])->nullable();
            //$table->enum('transmission', ['manuelle', 'automatique', 'tiptronic'])->nullable();
            //$table->enum('carburant', ['gasoil', 'essence'])->nullable();
            //$table->enum('climatisation', ['oui', 'non'])->nullable();
            //$table->unsignedBigInteger('capacite_id')->nullable();
            //$table->unsignedBigInteger('subdivision_id')->nullable();
            //$table->unsignedBigInteger('disponibilite_id')->nullable(); // Au cas où on ne gère pas le stock
            //$table->unsignedBigInteger('applicable_id')->nullable();
            //$table->unsignedBigInteger('applicable_id')->nullable();
            //$table->unsignedBigInteger('applicable_id')->nullable();
            //$table->unsignedBigInteger('applicable_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lier_id')->nullable(); // lier à post
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
