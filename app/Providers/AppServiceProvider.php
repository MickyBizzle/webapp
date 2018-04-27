<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
  /**
  * Bootstrap any application services.
  *
  * @return void
  */
  public function boot()
  {
    Schema::defaultStringLength(191);
    $training_status = DB::table('is_training')->select('is_training')->get()[0]->is_training;
    if ($training_status == 0) {
      $training_status = "NO";
      $training_colour = "black";
    }
    else {
      $training_status = "YES";
      $training_colour = "red";
    }
    view()->share('training_status', $training_status);
    view()->share('training_colour', $training_colour);
  }

  /**
  * Register any application services.
  *
  * @return void
  */
  public function register()
  {
    //
  }
}
