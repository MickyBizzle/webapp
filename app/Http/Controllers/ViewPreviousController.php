<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;

class ViewPreviousController extends controller
{
  private function titleExists($title) {
    return DB::table('experiments')->where('title', '=', $title)->exists();
  }

  public function index() {
    $noData = DB::table('experiments')->where('experiment_started', null)->get();
    if (sizeof($noData) == 0) {
      $noData = false;
    }

    if (!isset($_GET['show'])) {
      $experiments = DB::table('experiments')->where('experiment_started', '!=', null)->orderBy('created_at', 'desc')->paginate(20);
    }

    if (isset($_GET['show']) && $_GET['show'] == 'training') {
      $experiments = DB::table('experiments')->where([
        ['experiment_started', '!=', null],
        ['is_training_data', 1]
        ])->orderBy('created_at', 'desc')->paginate(20);
    }

    if (isset($_GET['show']) && $_GET['show'] == 'non_training') {
      $experiments = DB::table('experiments')->where([
        ['experiment_started', '!=', null],
        ['is_training_data', 0]
        ])->orderBy('created_at', 'desc')->paginate(20);
    }

    return view('previous/home')->with(['noData' => $noData, 'experiments' => $experiments, 'url' => URL::full()]);
  }

  public function showExperiment($id) {
    $experiment = DB::table('experiments')->where('id', $id)->get()->first();
    $data = DB::table('experiment_data')->where('experiment_id', $id)->get();
    return view('previous/show')->with(['experiment' => $experiment, 'data' => $data]);
  }

  public function updateTitle(Request $request) {
    $id = $request->input('id');
    $title = $request->input('title');

    if (trim($title) == "") {
      returnError("no_title");
    }

    if ($this->titleExists($title)) {
      returnError("title_exists");
    }

    return DB::table('experiments')->where('id', $id)->update(['title' => $title]);
  }

  public function delete($id) {
    DB::table('experiments')->where('id', $id)->delete();
    return redirect()->back();
  }

  public function updateChecked($id) {
    dd($_POST);
  }

}
