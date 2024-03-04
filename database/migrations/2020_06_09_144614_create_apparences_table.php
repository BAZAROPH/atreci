<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparences', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->text('debut')->nullable();
            $table->text('fin')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('type_apparence_id')->nullable(); //
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('apparences');
    }
}
