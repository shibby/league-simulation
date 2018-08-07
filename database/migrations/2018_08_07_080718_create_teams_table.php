<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('fans_count');
            $table->boolean('is_rival')->default(false);

            $table->integer('f_pts')->nullable()->default(0);
            $table->integer('f_w')->nullable()->default(0);
            $table->integer('f_d')->nullable()->default(0);
            $table->integer('f_l')->nullable()->default(0);
            $table->integer('f_gd')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
