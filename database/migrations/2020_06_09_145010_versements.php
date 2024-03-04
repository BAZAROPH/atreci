<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Versements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versements', function (Blueprint $table) {
            $table->id();
            $table->double('cout')->nullable();
            $table->double('frais')->nullable();
            $table->double('total')->nullable();
            $table->string('type')->nullable();
            $table->string('token')->nullable();
            $table->boolean('valide')->nullable();
            $table->unsignedBigInteger('commande_id')->nullable();
            $table->unsignedBigInteger('booster_id')->nullable(); // Lier à post
            $table->unsignedBigInteger('moyen_paiement_id')->nullable(); // Lier à post
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versements');
    }
}
