<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use \Teamwork\Tasks as Task;
use Teamwork\Response;

class IndividualTaskController extends Controller
{
    public function getTask(Request $request) {

      $groupTasksAll = \Teamwork\GroupTask::where('group_id', \Auth::user()->group_id)
                             ->with('individualTasks')
                             ->orderBy('order', 'ASC')
                             ->get();

     // Filter out any completed tasks
     $groupTasks = $groupTasksAll->filter(function ($value, $key) {
       return $value->completed == false;
     });

     if(count($groupTasksAll) > 0 && count($groupTasks) == 0) {
       // The experiment is over
       return redirect('/participant-experiment-end');
     }

     // If there are no tasks at all, let's create some
     else if(count($groupTasksAll) == 0) {
       // Alternately, we could display a message for the user to login as a group
       // because the following code is duplicated in the group task controller
       $groupTasks = \Teamwork\GroupTask::initializeDefaultTasks(\Auth::user()->group_id, $randomize = true);
     }

      $currentTask = $groupTasks->first();
      $individualTask = $currentTask->individualTasks->first();

      $request->session()->put('currentGroupTask', $currentTask->id);

      if($individualTask) {
        $request->session()->put('currentIndividualTask', $currentTask->individualTasks->first()->id);
        return $this->routeTask($currentTask);
      }

      else {
        return view('layouts.participants.participant-group-task');
      }
    }

    public function routeTask($task) {
      switch($task->name) {

        case "OptimizationTask":
          return redirect('/optimization-individual-intro');

        case "Brainstorming":
          return redirect('/brainstorming-individual-intro');
      }
    }

    public function endTask(Request $request) {


      $task = \Teamwork\GroupTask::with('response')
                                 ->find($request->session()->get('currentGroupTask'));

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
      return view('layouts.participants.participant-experiment-end');
    }

    public function optimizationIntro() {
      return view('layouts.participants.tasks.optimization-individual-intro');
    }

    public function optimization(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $function = $parameters['function'];
      $maxResponses = $parameters['maxResponses'];
      return view('layouts.participants.tasks.optimization-individual')
             ->with('function', $function)
             ->with('maxResponses', $maxResponses);
    }

    public function saveOptimizationGuess(Request $request) {

      $groupTaskId = $request->session()->get('currentGroupTask');
      $individualTaskId = $request->session()->get('currentIndividualTask');

      $r = new Response;
      $r->group_tasks_id = $groupTaskId;
      $r->individual_tasks_id = $individualTaskId;
      $r->user_id = \Auth::user()->id;
      $r->prompt = $request->function;
      $r->response = $request->guess;
      $r->save();

    }

    public function brainstormingIntro() {
      return view('layouts.participants.tasks.brainstorming-individual-intro');
    }

    public function brainstorming(Request $request) {

      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));

      $task = new Task\Brainstorming;

      $prompt = unserialize($currentTask->parameters)['prompt'];

      return view('layouts.participants.tasks.brainstorming-individual')
             ->with('prompt', $prompt);
    }

    public function scoreBrainstorming(Request $request) {

      $groupTaskId = $request->session()->get('currentGroupTask');
      $individualTaskId = $request->session()->get('currentIndividualTask');

      foreach ($request->responses as $response) {
        if(!$response) continue; // Skip any empty responses

        $r = new Response;
        $r->group_tasks_id = $groupTaskId;
        $r->individual_tasks_id = $individualTaskId;
        $r->user_id = \Auth::user()->id;
        $r->prompt = $request->prompt;
        $r->response = $response;
        $r->save();
      }


      return view('layouts.participants.tasks.participant-task-results')
             ->with('taskName', "Brainstorming Task")
             ->with('result', false);
    }
}
