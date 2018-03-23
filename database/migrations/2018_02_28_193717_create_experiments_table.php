<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperimentsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('experiments', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title', 100);
      $table->boolean('is_training_data');
      $table->tinyInteger('emotional_response')->nullable();
      $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->time('elapsed')->nullable();
      $table->dateTime('experiment_started')->nullable();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('experiments');
  }
}
