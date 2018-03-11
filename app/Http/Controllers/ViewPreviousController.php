<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ViewPreviousController extends controller
{
  private function titleExists($title) {
    return DB::table('experiments')->where('title', '=', $title)->exists();
  }

  public function index() {
    $experiments = DB::table('experiments')->paginate(20);
    return view('previous/home')->with(['experiments' => $experiments, 'url' => URL::full()]);
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

}
