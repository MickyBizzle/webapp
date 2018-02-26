<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    if (!Schema::hasTable('recording')) {
      try {
        Schema::create('recording', function($table) {
          $table->boolean('is_recording');
        });
        DB::table('recording')->insert(['is_recording' => false]);
      } catch(\Illuminate\Database\QueryException $ex) {
        die($ex->getMessage());
      }
    }

    if (!Schema::hasTable('experiments')) {
      try {
        Schema::create('experiments', function($table) {
          $table->increments('id');
          $table->string('title', 100);
          $table->dateTime('created_at');
          $table->time('elapsed');
        });
      } catch(\Illuminate\Database\QueryException $ex) {
        die($ex->getMessage());
      }
    }

    if (!Schema::hasTable('experiment_data')) {
      try {
        Schema::create('experiment_data', function($table) {
          $table->increments('id');
          $table->string('data', 100);
        });
      } catch(\Illuminate\Database\QueryException $ex) {
        die($ex->getMessage());
      }
    }
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('home');
  }
}
