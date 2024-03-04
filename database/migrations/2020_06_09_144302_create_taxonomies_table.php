<?php
// Table système
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('sous_titre')->nullable();
            $table->string('cout')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('type_taxonomie_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('visible')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxonomies');
    }
}
