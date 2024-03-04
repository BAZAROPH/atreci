<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->nullable();
            $table->string('name')->nullable();
            $table->string('prenom')->nullable();
            $table->string('slug')->nullable();
            $table->string('login')->nullable();
            $table->string('telephone')->unique()->nullable();
            $table->string('indicatif_telephone')->nullable()->default('+225');
            $table->string('whatsapp')->nullable();
            $table->string('indicatif_whatsapp')->nullable()->default('+225');
            $table->text('biographie')->nullable();
            $table->string('adresse')->nullable();
            $table->string('sexe')->nullable();
            $table->dateTime('date_naissance')->nullable();
            $table->string('poste')->nullable();
            $table->string('type_piece')->nullable();
            $table->string('numero_piece')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();;
            $table->rememberToken();
            $table->boolean('corbeille')->default(1);
            $table->boolean('valide')->default(0);
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('source_id')->nullable(); // Type de devise lier à la table catégorie
            $table->timestamps();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
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
        Schema::dropIfExists('users');
    }
}
