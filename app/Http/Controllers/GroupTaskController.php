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

      switch($task->name) {

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

    public function endExperiment() {
      return view('layouts.participants.group-experiment-end');
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
      $currentTask = GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $mapping = (new \Teamwork\Tasks\Cryptography)->getMapping($parameters->mapping);
      $maxResponses = $parameters->maxResponses;
      $sorted = $mapping;
      sort($sorted);

      // Record the start time for this task
      $time = Time::firstOrNew(['user_id' => \Auth::user()->id,
                                'group_tasks_id' => $currentTask->id,
                                'individual_tasks_id' => $request->session()->get('currentIndividualTask')]);
      $time->recordStartTime();

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
        foreach ($guesses as $key => $guess) {
          $g = explode('=', $guess);
          if(count($g) < 2 ){ // This is the trailing comma
            continue;
          }
          if($g[1] == '---') { // If the guess for this letter is blank
            $correct = false;
            continue;

          }
          if($g[0] != $mapping[$g[1]]){
            $correct = false;
          }
        }
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
        $r->correct = $correct;
      }
      $r->save();
    }

    public function endCryptographyTask(Request $request) {
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
}
