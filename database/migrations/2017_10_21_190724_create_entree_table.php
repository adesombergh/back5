<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrees', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('caisse_id')->unsigned();
            $table->foreign('caisse_id')->references('id')->on('caisses')->onDelete('cascade');

            $table->integer('type')->unsigned();
            $table->foreign('type')->references('id')->on('entree_types');

            $table->string('value');
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
        Schema::dropIfExists('entrees');
    }
}
