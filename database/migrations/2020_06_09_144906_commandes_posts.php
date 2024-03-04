<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommandesPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes_posts', function (Blueprint $table) {
            $table->id();
            $table->double('cout')->nullable();
            $table->double('quantite')->nullable();
            $table->json('options'); // Pour enregistrer les couleurs, bonnets, tailles...
            $table->unsignedBigInteger('commande_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
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
        Schema::dropIfExists('commandes_posts');
    }
}
