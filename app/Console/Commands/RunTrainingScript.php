<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Phpml\Classification\MLPClassifier;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Classification\NaiveBayes;
use Phpml\Classification\DecisionTree;
use Phpml\ModelManager;

class RunTrainingScript extends Command
{
  /**
  * The name and signature of the console command.
  *
  * @var string
  */
  protected $signature = 'runtrainingscript';

  /**
  * The console command description.
  *
  * @var string
  */
  protected $description = 'Run training script for Neural Network';

  /**
  * Create a new command instance.
  *
  * @return void
  */
  public function __construct()
  {
    parent::__construct();
  }

  /**
  * Execute the console command.
  *
  * @return mixed
  */
  public function handle()
  {
    // To avoid timeout issues
    ini_set('max_execution_time', 9000);
    ini_set('memory_limit','960M');

    // Clear model file ready for saving new model
    Storage::disk('local')->put('model', '');

    // Time before training starts
    $before = time();

    // Read training data and labels from files to arrays
    $trainingArray = json_decode(Storage::get('training_data.txt'));
    $labelsArray = json_decode(Storage::get('labels_data.txt'));

    // Update training flag in DB to true
    DB::table('is_training')->update(['is_training' => true]);

    // Train decision tree classifier with max depth of 20
    $classifier = new DecisionTree($maxDepth = 20);
    $classifier->train($trainingArray, $labelsArray);

    //Save model for future use
    $filepath = '../storage/app/model';
    $modelManager = new ModelManager();
    $modelManager->saveToFile($classifier, $filepath);

    // Update training flag in DB to false
    DB::table('is_training')->update(['is_training' => false]);

    // Calculate time taken to train
    $after = time() - $before;

    // Update last trained and time taken in DB
    DB::table('training_info')->update(['last_trained' => date("Y-m-d H:i:s"), 'time_taken' => gmdate('H:i:s', $after)]);
  }
}
