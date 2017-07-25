<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserworkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userworkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workout_id');
            $table->integer('user_id');
            $table->dateTime('date');
            $table->integer('workout_sets');
            $table->integer('workout_reps');
            $table->integer('workout_weight');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('userworkouts');
    }
}
