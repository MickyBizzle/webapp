<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AddNewController extends controller
{
  public function show() {
    return view('add_new');
  }

  public function startRecord() {
    DB::beginTransaction();

    try {
      DB::table('recording')->update(['is_recording' => true]);
      DB::commit();
      return DB::table('recording')->select()->get();
    } catch (\Exception $e) {
      DB::rollback();
      return($e->getMessage());
    }
  }

  public function stopRecord() {
    DB::beginTransaction();

    try {
      DB::table('recording')->update(['is_recording' => false]);
      DB::commit();
      return DB::table('recording')->select()->get();
    } catch (\Exception $e) {
      DB::rollback();
      return($e->getMessage());
    }
  }


}
