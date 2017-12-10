<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('qui')->unsigned()->nullable();
            $table->foreign('qui')->references('id')->on('users');

            $table->dateTime('quand');
            $table->string('type',11);
            $table->boolean('brunch');
            $table->boolean('verified');

            $table->float('pieces',6,2)->nullable();
            $table->integer('billet5')->nullable();
            $table->integer('billet10')->nullable();
            $table->integer('billet20')->nullable();
            $table->integer('billet50')->nullable();
            $table->integer('billet100')->nullable();

            $table->integer('schema_bonus')->unsigned()->nullable();
            $table->foreign('schema_bonus')->references('id')->on('bonuses');

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
        Schema::dropIfExists('services');
    }
}
