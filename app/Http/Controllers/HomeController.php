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

  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    try {
      $experiments = DB::table('experiments')->latest()->get();
      $exp_data = DB::table('experiment_data')->get();
    }
    catch (\Exception $e) {
      if (strpos($e->getMessage(), 'table or view not found') !== false) {
        returnTableNotFoundError();
      }
    }

    $recent = $experiments[0];
    $data = DB::table('experiment_data')->where('experiment_id', $recent->id)->get();

    $size['experiments'] = count($experiments);
    $size['data'] = count($exp_data);
    return view('home')->with(['recent' => $recent, 'data' => $data, 'sizes' => $size]);
  }
}
