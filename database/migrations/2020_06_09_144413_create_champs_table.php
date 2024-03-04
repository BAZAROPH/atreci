<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('champs', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('slug')->nullable();
            $table->text('requete')->nullable();
            $table->boolean('visible')->nullable()->default(1); //
            $table->unsignedBigInteger('type_champ_id')->nullable(); // lier à la table categorie
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
        Schema::dropIfExists('champs');
    }
}
