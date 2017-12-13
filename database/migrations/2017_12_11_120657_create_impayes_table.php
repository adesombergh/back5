<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpayesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impayes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('client')->nullable();

            $table->integer('qui')->unsigned()->nullable();
            $table->foreign('qui')->references('id')->on('users');

            $table->float('combien',6,3);
            
            $table->boolean('due');

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
        Schema::dropIfExists('impayes');
    }
}
