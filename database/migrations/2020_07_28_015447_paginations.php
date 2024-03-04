<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Paginations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paginations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apparence_id')->nullable();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('items')->nullable();
            $table->timestamps();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_page_id')->references('id')->on('categories');
        });

        Schema::table('paginations', function (Blueprint $table) {
            $table->foreign('apparence_id')->references('id')->on('apparences');
            $table->foreign('categorie_id')->references('id')->on('categories');
            $table->foreign('page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paginations');
    }
}
