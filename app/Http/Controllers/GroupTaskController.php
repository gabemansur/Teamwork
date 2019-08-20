<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use Teamwork\GroupTask;
use Teamwork\Response;
use \Teamwork\Tasks as Task;
use \Teamwork\Time;
use \Teamwork\Progress;

class GroupTaskController extends Controller
{

    public function getTask(Request $request) {
      $group_id = \Auth::user()->group_id;

      $groupTasksAll = GroupTask::where('group_id', $group_id)
                             ->with('individualTasks')
                             ->orderBy('order', 'ASC')
                             ->get();

      // Filter out any completed tasks
      $groupTasks = $groupTasksAll->filter(function ($value, $key) {
        return $value->completed == false;
      });

      if(count($groupTasksAll) > 0 && count($groupTasks) == 0) {
        // The experiment is over
        return redirect('/group-experiment-end');
      }

      // If there are no tasks at all, let's create some
      else if(count($groupTasksAll) == 0) {
        $groupTasks = GroupTask::initializeDefaultTasks($group_id, $randomize = true);
      }

      $currentTask = $groupTasks->first();

      $request->session()->put('currentGroupTask', $currentTask->id);

      if($currentTask->individualTasks->isNotEmpty() && !$currentTask->individualTasks->first()->completed) {
        // SHOW INDIVIDUAL TASK PROMPT

        $request->session()->put('currentIndividualTask', $currentTask->individualTasks->first()->id);
        return redirect('/get-individual-task');
        //return view('layouts.participants.group-individual-task');
      }

      return $this->routeTask($currentTask);
    }

    public function routeTask($task) {

      $this->getProgress();

      switch($task->name) {

        case "Memory":
          return redirect('/memory-group');

        case "Cryptography":
          return redirect('/cryptography-intro');

        case "Optimization":
          return redirect('/optimization-group-intro');

        case "Shapes":
          return redirect('/shapes-group-intro');

        case "UnscrambleWords":
          return redirect('/unscramble-words-intro');

        case "Brainstorming":
          return redirect('/brainstorming-intro');
      }

    }

    public function endTask(Request $request) {


      $task = \Teamwork\GroupTask::with('response')
                                 ->with('progress')
                                 ->find($request->session()->get('currentGroupTask'));

      // If this is an individual-only task, mark it as done
      $parameters = unserialize($task->parameters);
      if($parameters->hasGroup == 'false') {
        $task->completed = true;
        $task->save();
        return redirect('/get-individual-task');
      }

      // Save this user's task progress
      $progress = new Progress;
      $progress->user_id = \Auth::user()->id;
      $progress->group_id = \Auth::user()->group_id;
      $progress->group_tasks_id = $task->id;
      $progress->save();

      $numUsersCompleted = count($task->progress->groupBy('user_id'));

      $usersInGroup = \Teamwork\User::where('group_id', \Auth::user()->group_id)
                                    ->where('role_id', 3)
                                    ->count();

      if($numUsersCompleted == $usersInGroup) {
        $task->completed = true;
        $task->save();
        // Remove any waiting messages that were set
        $request->session()->forget('waitingMsg');
        return redirect('/get-individual-task');
      }
      else {
        return redirect('/waiting');
      }
    }

    public function waiting() {
      return view('layouts.participants.tasks.waiting');
    }

    public function showTaskResults(Request $request) {
      return view('layouts.participants.tasks.group-task-results')
             ->with('taskName', $request->session()->get('currentGroupTaskName'))
             ->with('results', $request->session()->get('currentGroupTaskResult'));

    }

    public function endExperiment() {
      return view('layouts.participants.group-experiment-end');
    }

    public function memoryGroupIntro(Request $request) {
      $this->recordStartTime($request, 'intro');
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $memory = new \Teamwork\Tasks\Memory;
      $intro = $memory->getTest($parameters->test);

      return view('layouts.participants.tasks.memory-group-intro')
             ->with('introType', $intro['test_name']);
    }

    public function memory(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));

      $parameters = unserialize($currentTask->parameters);
      $memory = new \Teamwork\Tasks\Memory;
      $test = $memory->getTest($parameters->test);
      $imgsToPreload = $memory->getImagesForPreloader($test['test_name']);
      if($test['task_type'] == 'intro') return redirect('/memory-group-intro');
      if($test['task_type'] == 'results') return redirect('/memory-group-results');
      if($test['type'] == 'intro') {
        $this->recordStartTime($request, 'intro');
      }

      else {
        $this->recordStartTime($request, 'task');
      }

      // Determine is this user is the reporter for the group
      $isReporter = $this->isReporter(\Auth::user()->id, \Auth::user()->group_id);
      // Originally, there was an array of multiple tests. We've separated the
      // different memory tasks into individual tasks but to avoid rewriting a
      // lot of code, we'll construct a single-element array with the one test.
      return view('layouts.participants.tasks.memory-group')
             ->with('testName', $test['test_name'])
             ->with('tests', [$test])
             ->with('taskId', $currentTask->id)
             ->with('enc_tests', json_encode([$test]))
             ->with('imgsToPreload', $imgsToPreload)
             ->with('isReporter', ($isReporter) ? 1 : 0);
    }

    public function saveMemory(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $test = (new \Teamwork\Tasks\Memory)->getTest($parameters->test);
      // Determine is this user is the reporter for the group
      $isReporter = $this->isReporter(\Auth::user()->id, \Auth::user()->group_id);

      if($test['type'] == 'intro') {
        $this->recordEndTime($request, 'intro');
        // We'll record an empty response here so that participants will be
        // able to move on to the next task once they are done with the intro
        $r = new Response;
        $r->group_tasks_id = $currentTask->id;
        $r->user_id = \Auth::user()->id;
        $r->prompt = 'Memory Intro';
        $r->response = 'n/a';
        $r->save();
        if($isReporter) {
          $request->session()->put('waitingMsg', 'Please wait for the experiment to continue...');
        }
        else {
          $request->session()->put('waitingMsg', "For this part of the task you will be working on the Reporter's laptop");
        }
        //return redirect('/end-group-task');
      }

      else {
        $this->recordEndTime($request, 'task');
      }


      // Retrieve all responses
      $responses = array_where($request->request->all(), function ($value, $key) {
        return strpos($key, 'response') !== false;
      });

      // Originally, there was an array of multiple tests. We've separated the
      // different memory tasks into individual tasks but to avoid rewriting a
      // lot of code, we'll construct a single-element array with the one test.
      $tests = [$test];


      foreach ($tests as $key => $t) {
        $testCount = count(array_where($t['blocks'], function($b, $k){
          return $b['type'] == 'test';
        }));

        $correct[$key] = ['name' => $t['test_name'],
                          'points'  => 0,
                          'count' =>$testCount,
                          'task_type' => $t['task_type']];
      }
      // Look up the test based on the response key
      foreach ($responses as $key => $response) {
        if(!$isReporter) continue;
        $indices = explode('_', $key);
        $test = $tests[$indices[1]]['blocks'][$indices[2]];

        $points = 0;

        // If the response is a single item and they got it correct,
        // give them 3 points
        if($test['selection_type'] == 'select_one') {

          if($test['correct'][0] == $response) {
            $correct[$indices[1]]['points'] += 3;
            $points = 3;
          }
        }

        // Otherwise, process arrays of choices against arrays of responses and correct answers
        else {
          // If they selected 'none' and there were no correct choices
          // give them 3 points
          if(count($response) == 1 && $response[0] == '0' && count($test['correct']) == 0) $points = 3;
          else {
            foreach($test['choices'] as $pos => $choice) {
              // If in responses arr and in correct arr, +1 point
              if(in_array($pos + 1, $response) && in_array($pos + 1, $test['correct'])) {
                $points += 1;
              }
              else if(!in_array($pos + 1, $response) && !in_array($pos + 1, $test['correct'])) {
                $points += 1;
              }
            }
          }
          $correct[$indices[1]]['points'] += $points;
        }

        $prompt = $tests[$indices[1]]['test_name'].' type: '.$tests[$indices[1]]['task_type'].' '.$tests[$indices[1]]['blocks'][$indices[2]]['type'];

        $r = new Response;
        $r->user_id = \Auth::user()->id;
        $r->group_tasks_id = $currentTask->id;
        $r->individual_tasks_id = $request->session()->get('currentIndividualTask');
        $r->prompt = $prompt;

        if(is_array($response)) {
         $responseStr = '';
         foreach ($response as $val) {
           $responseStr .= $val.',';
         }
         $r->response = $responseStr;
        }
        else $r->response = $response;
        $r->points = $points;
        $r->save();

      }

      // If this participant isn't the reporter, we'll set a message to
      // display on the waiting page
      if(!$isReporter) {
        $waitingMsg = 'You\'ll complete this task on the reporter\'s laptop.';
        $request->session()->put('waitingMsg', $waitingMsg);
      }
      else {
        $request->session()->put('waitingMsg', 'Please wait for the experiment to continue...');
      }

      return redirect('/end-group-task');
    }

    public function unscrambleWordsIntro() {
      return view('layouts.participants.tasks.unscramble-words-intro');
    }

    public function unscrambleWords() {

      $wordTask = new Task\UnscrambleWords();
      $words = $wordTask->getScrambledWords();
      return view('layouts.participants.tasks.unscramble-words')
             ->with('words', $words);
    }

    public function scoreUnscrambleWords(Request $request) {

      $wordTask = new Task\UnscrambleWords();
      $numCorrect = 0;

      $taskId = $request->session()->get('currentGroupTask');

      foreach ($request->responses as $response) {
        if(!$response) continue; // Skip any empty responses

        $r = new Response;
        $r->group_tasks_id = $taskId;
        $r->user_id = \Auth::user()->id;
        $r->response = $response;


        if($wordTask->checkResponse($response)) {
          $r->correct = true;
          $r->points = 1;
          $numCorrect++;
        }
        $r->save();
      }

      $task = GroupTask::find($taskId);
      $task->points = $numCorrect;
      $task->completed = true;
      $task->save();

      return view('layouts.participants.tasks.group-task-results')
             ->with('taskName', "Unscramble Words Task")
             ->with('result', $numCorrect);

    }

    public function optimizationIntro(Request $request) {
      $this->recordStartTime($request, 'intro');

      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);

      $totalTasks = \Teamwork\GroupTask::where('group_id', \Auth::user()->group_id)
                                       ->where('name', 'Optimization')
                                       ->get();
      $completedTasks = $totalTasks->filter(function($task){
        if($task->completed) { return $task; }
      });

      // Determine is this user is the reporter for the group
      $isReporter = $this->isReporter(\Auth::user()->id, \Auth::user()->group_id);
      return view('layouts.participants.tasks.optimization-group-intro')
                  ->with('totalTasks', $totalTasks)
                  ->with('taskId', $currentTask->id)
                  ->with('completedTasks', $completedTasks)
                  ->with('isReporter', $isReporter)
                  ->with('function', 't1')
                  ->with('maxResponses', $parameters->maxResponses)
                  ->with('intro', $parameters->intro)
                  ->with('groupSize', \Teamwork\User::where('group_id', \Auth::user()->group_id)->count());
    }

    public function optimization(Request $request) {
      $this->recordEndTime($request, 'intro');
      $this->recordStartTime($request, 'task');
      $currentTask = GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $function = (new \Teamwork\Tasks\Optimization)->getFunction($parameters->function);

      // Determine is this user is the reporter for the group
      $isReporter = $this->isReporter(\Auth::user()->id, \Auth::user()->group_id);

      return view('layouts.participants.tasks.optimization-group')
             ->with('function', $function)
             ->with('maxResponses', $parameters->maxResponses)
             ->with('isReporter', $isReporter)
             ->with('taskId', $currentTask->id)
             ->with('groupSize', \Teamwork\User::where('group_id', \Auth::user()->group_id)->count());;
    }

    public function saveOptimizationFinalGuess(Request $request) {

      $groupTaskId = $request->session()->get('currentGroupTask');
      $individualTaskId = $request->session()->get('currentIndividualTask');

      $currentTask = \Teamwork\GroupTask::find($groupTaskId);
      $parameters = unserialize($currentTask->parameters);
      $function = (new \Teamwork\Tasks\Optimization)->getFunction($parameters->function);

      $r = new Response;
      $r->group_tasks_id = $groupTaskId;
      $r->individual_tasks_id = $individualTaskId;
      $r->user_id = \Auth::user()->id;
      $r->prompt = 'final: '.$request->function;
      $r->response = $request->final_result;
      $r->save();

      // Record the end time for this task
      $this->recordEndTime($request, 'task');

      $request->session()->put('currentGroupTaskResult', 'You have completed the Optimization Task.');
      $request->session()->put('currentGroupTaskName', 'Optimization Task');

      $nextTask = \Teamwork\GroupTask::where('group_id', $currentTask->group_id)
                                     ->where('order', $currentTask->order + 1)
                                     ->first();

      $request->session()->put('waitingMsg', 'Please wait for the experiment to continue...');
      // If there is another Optimization task coming, skip the task results page
      if($nextTask && $nextTask->name == 'Optimization') return redirect('/end-group-task');

      return redirect('/group-task-results');

    }


    public function cryptographyIntro(Request $request) {
      $currentTask = GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $maxResponses = $parameters->maxResponses;
      $introType = $parameters->intro;
      // Determine is this user is the reporter for the group
      $isReporter = $this->isReporter(\Auth::user()->id, \Auth::user()->group_id);
      if($isReporter) $this->recordStartTime($request, 'intro');
      // We need to set a start time so when the non-reporters submit the task,
      // it records properly
      else $this->recordStartTime($request, 'task');

      $mapping = (new \Teamwork\Tasks\Cryptography)->getMapping('random');
      $aSorted = $mapping;
      asort($aSorted); // Sort, but preserve key order
      $sorted = $mapping;
      sort($sorted); // Sort and re-index

      return view('layouts.participants.tasks.cryptography-group-intro')
             ->with('maxResponses', $maxResponses)
             ->with('isReporter', $isReporter)
             ->with('mapping', json_encode($mapping))
             ->with('aSorted', $aSorted)
             ->with('sorted', $aSorted)
             ->with('introType', $introType);
    }

    public function cryptography(Request $request) {
      $isReporter = $this->isReporter(\Auth::user()->id, \Auth::user()->group_id);
      $this->recordEndTime($request, 'intro');
      $currentTask = GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $mapping = (new \Teamwork\Tasks\Cryptography)->getMapping($parameters->mapping);
      $maxResponses = $parameters->maxResponses;
      $sorted = $mapping;
      sort($sorted);

      // Record the start time for this task
      $this->recordStartTime($request, 'task');

      return view('layouts.participants.tasks.cryptography-group')
             ->with('mapping',json_encode($mapping))
             ->with('sorted', $sorted)
             ->with('maxResponses', $maxResponses)
             ->with('isReporter', $isReporter)
             ->with('hasGroup', $parameters->hasGroup);
    }

    public function saveCryptographyResponse(Request $request) {
      $groupTaskId = $request->session()->get('currentGroupTask');

      $correct = true;

      if($request->prompt == "Guess Full Mapping") {

        $guesses = explode(',', $request->guess);
        $mapping = json_decode($request->mapping);
        $correct = true;
        $numCorrect = 0;

        foreach ($guesses as $key => $guess) {
          $g = explode('=', $guess);
          if(count($g) < 2 ){ // This is the trailing comma
            continue;
          }
          if($g[1] == '---') { // If the guess for this letter is blank
            $correct = false;
            continue;

          }
          else if($g[0] != $mapping[$g[1]]){ // If the guess doesn't match the mapping
            $correct = false;
          }

          else { // Otherwise, this letter is correct
            $numCorrect++;
          }
        }
      }

      else {
        $correct = false;
        $numCorrect = 'n/a';
      }

      $r = new Response;
      $r->group_tasks_id = $groupTaskId;
      $r->user_id = \Auth::user()->id;
      if($request->prompt == "Guess Full Mapping") {
        $r->prompt = "Guess Full Mapping: ".json_encode($request->mapping);
      }
      else {
        $r->prompt = $request->prompt;
      }

      $r->response = $request->guess;
      if($request->prompt == "Guess Full Mapping") {
        $r->response = $request->guess.' Correct: '.$numCorrect;
        $r->correct = $correct;
        $r->points = $numCorrect;
      }
      $r->save();
    }

    public function endCryptographyTask(Request $request) {
      $task = GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($task->parameters);
      $isReporter = $this->isReporter(\Auth::user()->id, \Auth::user()->group_id);
      // If htis participant isn't the reporter, we'll save an empty response
      // so that the group can continue when the reporter has finished

      if(!$isReporter){
        $r = new Response;
        $r->group_tasks_id = $task->id;
        $r->user_id = \Auth::user()->id;
        $r->prompt = 'Not reporter';
        $r->response = 'n/a';
        $r->save();
        return redirect('/end-group-task');
      }

      $this->recordEndTime($request, 'task');
      $task->points = $request->task_result;
      $task->completed = true;
      $task->save();

      // Record the end time for this task
      $time = Time::where('user_id', '=', \Auth::user()->id)
                  ->where('group_tasks_id', '=', $task->id)
                  ->first();
      $time->recordEndTime();
      $request->session()->put('waitingMsg', 'Please wait for the experiment to continue...');
      if(!$parameters->hasGroup) return redirect('/end-individual-task');
      else return redirect('/end-group-task');
    }

    public function shapesGroupIntro(Request $request) {
      $this->recordStartTime($request, 'intro');
      // Determine is this user is the reporter for the group
      $isReporter = $this->isReporter(\Auth::user()->id, \Auth::user()->group_id);
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      return view('layouts.participants.tasks.shapes-group-intro')
             ->with('isReporter', $isReporter)
             ->with('subtest', $parameters->subtest);;
    }

    public function shapesGroup(Request $request) {
      $this->recordEndTime($request, 'intro');
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);

      $task = new Task\Shapes;
      $shapes = $task->getShapes($parameters->subtest);

      $imgsToPreload = [];
      // Create array of images for preloading
      for($i = 1; $i < $shapes['length']; $i++){
        $imgsToPreload[] = '/img/shapes-task/'.$parameters->subtest.'/'.$i.'.png';
      }

      // Record the start time for this task
      $this->recordStartTime($request, 'task');

      return view('layouts.participants.tasks.shapes-group')
             ->with('shapes', $shapes)
             ->with('imgsToPreload', $imgsToPreload)
             ->with('subtest', $parameters->subtest);
    }

    public function saveShapesGroup(Request $request) {

      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $individualTask = $request->session()->get('currentIndividualTask');
      $parameters = unserialize($currentTask->parameters);

      $task = new Task\Shapes;
      $shapes = $task->getShapes($parameters->subtest);

      $answers = $shapes['answers'];

      foreach ($request->all() as $key => $input) {
        if($key == '_token') continue;

        $inputString = $input;

        if(is_array($answers[$key - 1])){
          $inputString = json_encode($input);

          $points = 2 - count(array_diff($input, $answers[$key - 1]));

          if($points == 2) $correct = 1;
          else $correct = 0;
        }

        else if($input == $answers[$key - 1]) {
          $correct = 1;
          $points = 1;
        }

        else {
          $correct = 0;
          $points = 0;
        }

        $r = new Response;
        $r->group_tasks_id = $currentTask->id;
        $r->individual_tasks_id = $individualTask;
        $r->user_id = \Auth::user()->id;
        $r->prompt = $parameters->subtest.' : '.$key;
        $r->response = $inputString;
        $r->correct = $correct;
        $r->points = $points;
        $r->save();

      }

      // Record the end time for this task
      $this->recordEndTime($request, 'task');

      $results = 'You have completed the Shapes Task.';
      $request->session()->put('currentGroupTaskResult', $results);
      $request->session()->put('currentGroupTaskName', 'Shapes Task');
      $request->session()->put('waitingMsg', 'Please wait for the experiment to continue...');
      return redirect('/group-task-results');
    }

    public function endShapesGroup(Request $request) {
      $request->session()->put('waitingMsg', "For this part of the task you will be working on the Reporter's laptop");
      return redirect('/end-group-task');
    }

    public function setTaskEnd(Request $request) {
      $this->recordEndTime($request, 'task');
    }

    private function recordStartTime(Request $request, $type) {
      $time = Time::firstOrNew(['user_id' => \Auth::user()->id,
                                'group_tasks_id' => $request->session()->get('currentGroupTask'),
                                'individual_tasks_id' => $request->session()->get('currentIndividualTask'),
                                'type' => $type]);
      $time->recordStartTime();
    }

    private function recordEndTime(Request $request, $type) {
      $time = Time::where('user_id', '=', \Auth::user()->id)
                  ->where('group_tasks_id', '=', $request->session()->get('currentGroupTask'))
                  ->where('type', '=', $type)
                  ->first();
      $time->recordEndTime();
    }

    public function getProgress() {
      $tasks = \Teamwork\GroupTask::where('group_id', \Auth::user()->group_id)
                                      ->where('name', '!=', 'Consent')
                                      ->where('name', '!=', 'Intro')
                                      ->where('name', '!=', 'ChooseReporter')
                                      ->where('name', '!=', 'Teammates')
                                      ->where('name', '!=', 'Feedback')
                                      ->where('name', '!=', 'Conclusion')
                                      ->where('name', '!=', 'Survey')
                                      ->get();

      $count = 0;
      $completed = 0;
      $lastTask = null;

      foreach ($tasks as $task) {
        if($task->name != $lastTask) {
          $count++;
          if($task->completed) $completed++;
        }
        $lastTask = $task->name;

      }
      \Session::put('totalTasks', $count);
      \Session::put('completedTasks', $completed);
    }

    private function isReporter($userId, $groupId) {
      // Get the id of the reporter for the group
      $reporterId = \DB::table('reporters')->where('group_id', $groupId)->pluck('user_id')->first();
      return $reporterId == $userId;
    }
}
