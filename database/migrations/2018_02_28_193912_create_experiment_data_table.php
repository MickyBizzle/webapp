<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperimentDataTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('experiment_data', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('experiment_id')->length(10)->unsigned();
      $table->text('data');
      $table->foreign('experiment_id')->references('id')->on('experiments')->onDelete('cascade');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('experiment_data');
  }
}
