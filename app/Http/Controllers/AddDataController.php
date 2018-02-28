<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AddDataController extends controller
{
  public function add(Request $request) {
    return $request->input("data");
  }
}
