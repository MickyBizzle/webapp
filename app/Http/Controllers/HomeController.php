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
    $recent = DB::table('experiments')->latest()->get()[0];
    $data = DB::table('experiment_data')->where('experiment_id', $recent->id)->get();
    return view('home')->with(['recent' => $recent, 'data' => $data]);
  }
}
