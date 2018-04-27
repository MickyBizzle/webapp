<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_info', function (Blueprint $table) {
            $table->dateTime('last_trained')->nullable();
            $table->time('time_taken')->nullable();
        });
        DB::table('training_info')->insert(['last_trained' => date("Y-m-d H:i:s")]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_info');
    }
}
