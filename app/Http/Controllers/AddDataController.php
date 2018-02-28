<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AddDataController extends controller
{
  private function isRecording() {
    return DB::table('is_recording')->select()->get();
  }

  public function add(Request $request) {
    if ($this->isRecording()[0]->is_recording) {
      return "yes";
    }
    else {
      return "Not recording";
    }
  }
}
