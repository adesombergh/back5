<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorties', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->integer('type')->unsigned()->nullable();
            $table->foreign('type')->references('id')->on('sortie_types');


            $table->string('desc')->nullable();
            $table->float('value',8,2);

            $table->boolean('facture')->nullable();

            $table->integer('qui')->unsigned()->nullable();
            $table->foreign('qui')->references('id')->on('users');

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
        Schema::dropIfExists('sorties');
    }
}
