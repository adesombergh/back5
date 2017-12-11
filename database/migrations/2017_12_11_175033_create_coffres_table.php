<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoffresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffres', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('qui')->unsigned();
            $table->foreign('qui')->references('id')->on('users');

            $table->float('vrac',6,2)->nullable();
            $table->float('depenses',6,2)->nullable();
            $table->integer('cents10')->nullable();
            $table->integer('cents20')->nullable();
            $table->integer('cents50')->nullable();
            $table->integer('euro1')->nullable();
            $table->integer('euro2')->nullable();
            $table->integer('billet5')->nullable();
            $table->integer('billet10')->nullable();
            $table->integer('billet20')->nullable();
            $table->integer('billet50')->nullable();
            $table->integer('billet100')->nullable();

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
        Schema::dropIfExists('coffres');
    }
}
