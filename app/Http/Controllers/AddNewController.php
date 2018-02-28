<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AddNewController extends controller
{
  private function titleExists($title) {
    return DB::table('experiments')->where('title', '=', $title)->exists();
  }


  public function show() {
    return view('add_new');
  }


  public function startRecord(Request $request) {
    $title = $request->input('title');
    if ($this->titleExists($title)) {
      returnError("title_exists");
    }

    try {
      DB::beginTransaction();
      DB::table('is_recording')->update(['is_recording' => true]);
      DB::table('experiments')->insert(['title' => $title]);
      DB::commit();
      return DB::table('is_recording')->select()->get();
    } catch (\Exception $e) {
      DB::rollback();
      return($e->getMessage());
    }
  }


  public function stopRecord() {
    DB::beginTransaction();

    try {
      DB::table('is_recording')->update(['is_recording' => false]);
      DB::commit();
      return DB::table('is_recording')->select()->get();
    } catch (\Exception $e) {
      DB::rollback();
      return($e->getMessage());
    }
  }

}
