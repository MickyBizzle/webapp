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

  public function getData(Request $request) {
    try {
      DB::beginTransaction();
      DB::table('is_recording')->where('is_recording', true)->update(['updated_at' => date("Y-m-d H:i:s")]);
      if ($request->input('getTimeStarted')) {
        $toSend['startTime'] = DB::table('experiments')->where('id', $request->input('id'))->get()[0]->experiment_started;
      }
      $toSend['data'] = DB::table('experiment_data')->select('data')->where('experiment_id', $request->input('id'))->orderBy('id', 'desc')->take(10)->get();
      $toSend['length'] = sizeof(DB::table('experiment_data')->select('data')->where('experiment_id', $request->input('id'))->get());
      DB::commit();
      return json_encode($toSend);
      // return var_dump($request->input('id'));
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
    }
  }


  public function startRecord(Request $request) {
    $title = $request->input('title');
    if ($this->titleExists($title)) {
      returnError("title_exists");
    }

    try {
      DB::beginTransaction();
      DB::table('is_recording')->update(['is_recording' => true]);
      $id = DB::table('experiments')->insertGetId(['title' => $title, 'is_training_data' => $request->input('isTrainingData')]);
      DB::commit();
      return json_encode(['id' => $id]);
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
    }
  }


  public function stopRecord(Request $request) {
    DB::beginTransaction();
    try {
      DB::table('is_recording')->update(['is_recording' => false]);
      if ($request->input('id')) {
        DB::table('experiments')->where('id', $request->input('id'))->update(['elapsed' => $request->input('time')]);
      }
      DB::commit();
      return DB::table('is_recording')->select()->get();
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
    }
  }

  public function addEmotion(Request $request) {
    DB::beginTransaction();
    try {
      DB::table('experiments')->where('id', $request->input('id'))->update(['emotional_response' => $request->input('emotion')]);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
    }
  }

}
