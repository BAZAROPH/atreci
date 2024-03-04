<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('title')->nullable();
            $table->string('sous_titre')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->text('url')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
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
        Schema::dropIfExists('parametres');
    }
}
