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

  private function timeGreaterThanTen() {
    $time = $this->isRecording()[0]->updated_at;
    if ((strtotime(date("Y-m-d H:i:s")) - strtotime($time)) > 5) {
      return false;
    }
    return true;
  }

  public function add(Request $request) {
    if ($this->isRecording()[0]->is_recording && $this->timeGreaterThanTen()) {
      // nodeId packetId bpm mov batt temp gsr
      $temp = explode(',', $request->data);
      $data[0] = ['column' => "beats per minute", "value" => $temp[2]];
      $data[1] = ['column' => "skin temperature", "value" => $temp[5]/100];
      $data[2] = ['column' => "galvanic skin resistance", "value" => $temp[6]];
      try {
        DB::beginTransaction();
        $latest_exp = DB::table('experiments')->latest()->get()[0];
        if (!$latest_exp->experiment_started) {
          DB::table('experiments')->where('id', $latest_exp->id)->update(['experiment_started' => date("Y-m-d H:i:s")]);
        }
        DB::table('experiment_data')->insert(['experiment_id' => $latest_exp->id, 'data' => json_encode($data)]);
        DB::commit();
        return "data saved";
      } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
      }
      // return $data;
    }
    else {
      return "Not recording";
    }
  }
}
