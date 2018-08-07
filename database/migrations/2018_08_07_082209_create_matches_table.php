<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('week');
            $table->integer('team1_id')->unsigned();
            $table->foreign('team1_id')->on('teams')->references('id');
            $table->integer('team2_id')->unsigned();
            $table->foreign('team2_id')->on('teams')->references('id');

            $table->boolean('has_been_played')->default(false);
            $table->integer('team1_score')->unsigned()->nullable();
            $table->integer('team2_score')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
