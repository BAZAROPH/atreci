<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->string('libelle')->nullable();
            $table->string('sous_titre')->nullable();
            $table->text('description')->nullable();
            $table->string('lien')->nullable();
            $table->text('requete')->nullable();
            $table->string('cout')->nullable();
            $table->string('icon')->nullable(); // Font awesone...
            $table->string('slug')->nullable();
            $table->string('indicateur')->nullable();
            $table->boolean('corbeille')->nullable()->default(1);
            $table->bigInteger('rang')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('taxonomie_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable(); // vers la même table categorie
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
        Schema::dropIfExists('categories');
    }
}
