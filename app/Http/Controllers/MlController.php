<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Phpml\ModelManager;
use Phpml\Metric\ConfusionMatrix;

class MlController extends controller
{
  private $mlp;

  public function index() {
    $last_trained = DB::table('training_info')->select('last_trained')->get()[0]->last_trained;

    $time_taken = DB::table('training_info')->select('time_taken')->get()[0]->time_taken;

    $is_training = DB::table('is_training')->select('is_training')->get()[0]->is_training;

    return view('ml')->with(['url' => URL::full(), 'last_trained' => $last_trained, 'time_taken' => $time_taken, 'is_training' => $is_training]);
  }

  public function train() {
    $training = $this->getTrainingExperiments();
    $expandedData = $this->expandData($training);

    // dd($expandedData[0]);

    $trainingArray = [];
    $labelsArray = [];

    foreach($expandedData as $key => $exp) {
      array_push($trainingArray, $this->extractFeatures($exp->data, $exp->media_type));
      array_push($labelsArray, (string)$exp->emotional_response);
    }

    // dd($trainingArray, $labelsArray);

    Storage::disk('local')->put('training_data.txt', json_encode($trainingArray));
    Storage::disk('local')->put('labels_data.txt', json_encode($labelsArray));

    \Artisan::queue('runtrainingscript');
  }

  private function expandData($toExpand) {
    $OFFSET = 1;
    $COUNT = 30;
    $returnArray = [];

    foreach ($toExpand as $key => $record) {
      $data = $this->formatData($this->getDataForExp($record->id));
      for ($i = 0; $i < count($data[0]) - $COUNT; $i+=$OFFSET) {
        $myData[0] = array_slice($data[0], $i, $COUNT);
        $myData[1] = array_slice($data[1], $i, $COUNT);
        $myData[2] = array_slice($data[2], $i, $COUNT);

        $dataJSON = new \stdClass();

        $dataJSON->emotional_response = $record->emotional_response;
        $dataJSON->media_type = $record->media_type;
        $dataJSON->data = $myData;

        array_push($returnArray, $dataJSON);
      };
    };
    return $returnArray;
  }

  public function predict(Request $request) {
    $exp = DB::table('experiments')->where(['id' => $request->input('id')])->get()[0];
    $data = $this->extractFeatures($this->formatData($this->getDataForExp($exp->id)), $exp->media_type);

    $filepath = '../storage/app/model';
    $modelManager = new ModelManager();
    $restoredClassifier = $modelManager->restoreFromFile($filepath);

    return $this->getResponse($restoredClassifier->predict($data));
  }

  public function batch_test() {
    $ids = DB::table('experiments')->select('id', 'emotional_response', 'media_type')
    ->where('is_training_data', '0')
    ->get();

    $results = [];
    $correctness = 0;

    foreach ($ids as $key => $exp) {
      $tempArr = [];
      // array_push($tempArr, 'Experiment ID: ' . $exp->id);
      $expected = $this->getResponse($exp->emotional_response);
      array_push($tempArr, 'Expected outcome: ' . $expected);

      $filepath = '../storage/app/model';
      $modelManager = new ModelManager();
      $restoredClassifier = $modelManager->restoreFromFile($filepath);

      $data = $this->extractFeatures($this->formatData($this->getDataForExp($exp->id)), $exp->media_type);

      $outcome = $this->getResponse($restoredClassifier->predict($data));

      array_push($tempArr, 'ML outcome: ' . $outcome);
      array_push($results, $tempArr);

      if ($expected == $outcome) {
        $correctness += 1;
      }
    }

    dd(($correctness / count($results)) * 100, $results);
    dd($results);
  }

  private function getTrainingExperiments() {
    return DB::table('experiments')->where([
      ['is_training_data', '1'],
      // ['emotional_response', '<>', '4']
      // ['media_type', '=', '1']
      ])->get();
  }

  private function getDataForExp($id) {
    return DB::table('experiment_data')->where('experiment_id', $id)->get();
  }

  private function formatData($data) {
    $formattedData = [];
    $heart = [];
    $temp = [];
    $skinRes = [];
    foreach($data as $key => $val) {
      $val = (json_decode($val->data));
      array_push($heart, floatval($val[0]->value));
      array_push($temp, floatval($val[1]->value));
      array_push($skinRes, floatval($val[2]->value));
    }
    array_push($formattedData, $heart);
    array_push($formattedData, $temp);
    array_push($formattedData, $skinRes);
    return $formattedData;
  }

  private function extractFeatures($data, $media_type) {
    $heartbeat = $data[0];
    $temp = $data[1];
    $skinRes = $data[2];

    $featuresArray = [
      $media_type,
      $heartbeat[0],
      $this->getAverage($heartbeat),
      $this->getAverage($temp),
      $this->getAverage($skinRes),
      $this->getMax($heartbeat),
      $this->getMax($temp),
      $this->getMax($skinRes),
      $this->getMin($heartbeat),
      $this->getMin($temp),
      $this->getMin($skinRes),
      $this->getVariance($heartbeat,3,false, true),
      $this->getVariance($heartbeat,3,false, false),
      $this->getVariance($heartbeat,5,true, true),
      $this->getVariance($heartbeat,10,true, true),
      $this->getVariance($heartbeat,20,true, true),
      $this->getVariance($heartbeat,40,true, true)
    ];
    return $featuresArray;
  }

  private function getAverage($input) {
    return array_sum($input) / count($input);
  }

  private function getMax($input) {
    return max($input);
  }

  private function getMin($input) {
    return min($input);
  }

  private function getResponse($input) {
    switch ($input) {
      case 1:
      return "Anger";
      case 2:
      return "Disgust";
      case 3:
      return "Fear";
      case 4:
      return "Happiness";
      case 5:
      return "Sadness";
      case 6:
      return "Surprise";
    }
  }

  private function getVariance($input, $length, $absolute, $max) {
    $comparison = $max ? PHP_INT_MIN : PHP_INT_MAX;

    if (count($input) < $length)
    return 0;

    for ($i = 0; $i <= count($input) - $length; $i++) {
      $subset = array_slice($input, $i, $length);
      $range = $this->rangeCalculator($subset, $absolute);

      if ($max && $range > $comparison) {
        $comparison = $range;
      }
      else if (!$max && $range < $comparison) {
        $comparison = $range;
      }

    }
    return $comparison;
  }

  //Input = Array
  //Absolute = take total change or change in one direction
  private function rangeCalculator($input, $absoluteValues = true) {
    $difference = 0;
    $first = true;
    $last = 0;

    foreach($input as $key => $element) {
      if ($first) {
        $last = $element;
        $first = false;
        continue;
      }

      // If absolute we always go positive
      $difference += $absoluteValues ? abs($last - $element) : $element - $last;
      $last = $element;
    };

    return $difference;
  }
}
