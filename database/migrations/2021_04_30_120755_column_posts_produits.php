<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColumnPostsProduits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dateTime('date')->comment('Date du post')->nullable();
            $table->bigInteger('quantite')->nullable();
            $table->string('variete')->comment('Variété de la culture')->nullable();
            $table->text('technique')->comment('Technique de production de la culture')->nullable();
            $table->text('intrant')->comment('Intrants utilisés pour la culture')->nullable();
            $table->string('certification')->comment('Certification de la culture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('date', 'quantite', 'variete', 'techique', 'intrant', 'certification');
        });
    }
}
