<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use Teamwork\GroupTask;
use Teamwork\Response;
use \Teamwork\Tasks as Task;
use \Teamwork\Time;

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
        return view('layouts.participants.group-individual-task');
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
          return redirect('/optimization-group');

        case "UnscrambleWords":
          return redirect('/unscramble-words-intro');

        case "Brainstorming":
          return redirect('/brainstorming-intro');
      }

    }

    public function endTask(Request $request) {


      $task = \Teamwork\GroupTask::with('response')
                                 ->find($request->session()->get('currentGroupTask'));

      // If this is an individual-only task, mark it as done
      $parameters = unserialize($task->parameters);
      if($parameters->hasGroup == 'false') {
        $task->completed = true;
        $task->save();
        return redirect('/get-individual-task');
      }

      $numUsersResponded = count($task->response->groupBy('user_id'));

      $usersInGroup = \Teamwork\User::where('group_id', \Auth::user()->group_id)
                                    ->where('role_id', 3)
                                    ->count();

      if($numUsersResponded == $usersInGroup) {
        $task->completed = true;
        $task->save();
        return redirect('/get-individual-task');
      }
      else {
        return view('layouts.participants.tasks.waiting');
      }
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

      // We'll record an empty response here so that participants will be
      // able to move on to the next task once they are done with the intro
      $r = new Response;
      $r->group_tasks_id = $currentTask->id;
      $r->user_id = \Auth::user()->id;
      $r->prompt = 'Memory Intro';
      $r->response = 'n/a';
      $r->save();

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

      // Originally, there was an array of multiple tests. We've separated the
      // different memory tasks into individual tasks but to avoid rewriting a
      // lot of code, we'll construct a single-element array with the one test.
      return view('layouts.participants.tasks.memory-group')
             ->with('tests', [$test])
             ->with('enc_tests', json_encode([$test]))
             ->with('imgsToPreload', $imgsToPreload);
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

    public function optimization(Request $request) {
      $currentTask = GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $function = $parameters->function;

      return view('layouts.participants.tasks.optimization-group')
             ->with('function', $function);
    }

    public function saveOptimization(Request $request) {
      $currentTask = GroupTask::find($request->session()->get('currentGroupTask'));

      $r = new Response;
      $r->group_tasks_id = $currentTask->id;
      $r->individual_tasks_id = $request->session()->get('currentIndividualTask');
      $r->user_id = \Auth::user()->id;
      $r->prompt = $request->function;
      $r->response = $request->guess;
      $r->save();

      $currentTask->completed = true;
      $currentTask->save();

      return view('layouts.participants.tasks.group-task-results')
             ->with('taskName', "Optimization Task")
             ->with('result', false);;
    }

    public function cryptographyIntro(Request $request) {
      $currentTask = GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $maxResponses = $parameters->maxResponses;
      return view('layouts.participants.tasks.cryptography-group-intro')
             ->with('maxResponses', $maxResponses);
    }

    public function cryptography(Request $request) {
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
             ->with('maxResponses', $maxResponses);
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
      $this->recordEndTime($request, 'task');
      $task = GroupTask::find($request->session()->get('currentGroupTask'));
      $task->points = $request->task_result;
      $task->completed = true;
      $task->save();

      // Record the end time for this task
      $time = Time::where('user_id', '=', \Auth::user()->id)
                  ->where('group_tasks_id', '=', $task->id)
                  ->first();
      $time->recordEndTime();

      if(\Auth::user()->role_id == 3) return redirect('/end-individual-task');
      else return redirect('/get-group-task');
    }

    public function testCryptograhySave(Request $request) {
      //$groupTaskId = $request->session()->get('currentGroupTask');

      $correct = true;
      dump($request->mapping);
      if($request->prompt == "Guess Full Mapping") {

        //$currentTask = GroupTask::find($request->session()->get('currentGroupTask'));
        $parameters = unserialize($currentTask->parameters);
        $mapping = json_decode($request->mapping);
        dump($mapping);
        $correct = true;
        $guesses = explode(',', $request->guess);
        foreach ($guesses as $key => $guess) {
          $g = explode('=', $guess);
          if(count($g) < 2 || $g[1] == '---') continue; // If the guess for this letter is blank
          dump('Guess: '.$g[0]. ' Mapped to: '.$mapping[$g[1]]);
          if($g[0] != $mapping[$g[1]]){
            dump('not equal');
            $correct = false;
          }
        }
      }

      $r = new Response;
      //$r->group_tasks_id = $groupTaskId;
      //$r->user_id = \Auth::user()->id;
      if($request->prompt == "Guess Full Mapping") {
        $r->prompt = $request->mapping;
      }
      else {
        $r->prompt = $request->prompt;
      }

      $r->response = $request->guess;
      if($request->prompt == "Guess Full Mapping") {
        $r->correct = $correct;
      }
      //$r->save();
      //dump($r);
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
                                      ->where('name', '!=', 'Feedback')
                                      ->where('name', '!=', 'Conclusion')
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
}
