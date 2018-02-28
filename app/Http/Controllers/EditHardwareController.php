<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditHardwareController extends controller
{

  public function __construct() {
    $this->middleware('auth');
  }

  public function index() {
    return view('edit_hardware');
  }

  public function logout() {
    Auth::logout();
  }
}
