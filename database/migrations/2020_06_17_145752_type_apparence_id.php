<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TypeApparenceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apparences', function (Blueprint $table) {
            $table->foreign('type_apparence_id')->references('id')->on('categories');
            $table->foreign('parent_id')->references('id')->on('apparences');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apparences', function (Blueprint $table) {
            $table->foreign('type_apparence_id')->references('id')->on('categories');
            $table->foreign('parent_id')->references('id')->on('apparences');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }
}
