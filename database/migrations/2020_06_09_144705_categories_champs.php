<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoriesChamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_champs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->unsignedBigInteger('champ_id')->nullable();
            $table->boolean('obligatoire')->nullable();
            $table->double('rang')->nullable();
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
        Schema::dropIfExists('categories_champs');
    }
}
