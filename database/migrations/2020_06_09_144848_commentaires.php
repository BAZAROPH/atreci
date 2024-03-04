<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Commentaires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->text('description')->nullable();
            $table->boolean('visible')->nullable()->default(1);
            $table->boolean('corbeille')->nullable()->default(1);
            $table->unsignedBigInteger('posts_id')->nullable();
            $table->unsignedBigInteger('avis_id')->nullable(); // Pour les avis (les étoiles)
            $table->unsignedBigInteger('users_id')->nullable();
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
        Schema::dropIfExists('commentaires');
    }
}
