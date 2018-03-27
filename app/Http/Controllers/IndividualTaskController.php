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

        case "Optimization":
          request()->session()->put('currentIndividualTaskName', 'Optimization Task');
          return redirect('/optimization-individual-intro');

        case "Brainstorming":
          request()->session()->put('currentIndividualTaskName', 'Brainstorming Task');
          return redirect('/brainstorming-individual-intro');

        case "Shapes":
          request()->session()->put('currentIndividualTaskName', 'Shapes Task');
          return redirect('/shapes-individual-intro');
      }
    }

    public function showTaskResults(Request $request) {
      return view('layouts.participants.tasks.participant-task-results')
             ->with('taskName', $request->session()->get('currentIndividualTaskName'))
             ->with('result', $request->session()->get('currentIndividualTaskResult'));

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

      $request->session()->put('currentIndividualTaskResult', false);
      $request->session()->put('currentIndividualTaskName', 'Brainstorming Task');

      return redirect('\individual-task-results');
    }

    public function shapesIntro() {
      return view('layouts.participants.tasks.shapes-individual-intro');
    }

    public function shapesIndividual() {
      $task = new Task\Shapes;
      $shapes = $task->getShapes();
      return view('layouts.participants.tasks.shapes-individual')
             ->with('shapes', $shapes['subtest1']);
    }

    public function saveShapesIndividual(Request $request) {
      $task = new Task\Shapes;
      $shapes = $task->getShapes();
      $answers = $shapes['subtest1']['answers'];
      $correct = 0;

      foreach ($request->all() as $key => $input) {
        if($key != '_token' && $input == $answers[$key - 1]) {
          $correct++;
        }
      }


      $r = new Response;
      $r->group_tasks_id = $request->session()->get('currentGroupTask');
      $r->individual_tasks_id = $request->session()->get('currentIndividualTask');
      $r->user_id = \Auth::user()->id;
      $r->prompt = 'subtest1';
      $r->response = json_encode($request->all());
      $r->points = $correct;
      $r->save();
      $request->session()->put('currentIndividualTaskResult', $correct);
      $request->session()->put('currentIndividualTaskName', 'Shapes Task');
      return redirect('\individual-task-results');
    }

}
