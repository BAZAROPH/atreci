<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApparencesCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparences_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apparence_id')->nullable();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->bigInteger('default')->nullable();
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
        Schema::dropIfExists('apparences_categories');
    }
}
