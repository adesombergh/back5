<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('taille_equipe');
            $table->integer('seuil_initial');
            $table->float('bonus_initial',6,2)->nullable();
            $table->integer('paliers_suivants')->nullable();
            $table->float('supplement',6,2)->nullable();
            $table->string('concerne')->nullable();
            $table->boolean('actif')->nullable();
            $table->string('type_de_service');
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
        Schema::dropIfExists('bonuses');
    }
}
