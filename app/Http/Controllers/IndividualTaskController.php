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

        case "TeamRole":
          request()->session()->put('currentIndividualTaskName', 'Team Role Task');
          return redirect('/team-role-intro');

        case "BigFive":
          request()->session()->put('currentIndividualTaskName', 'Big Five Task');
          return redirect('/big-five-intro');

        case "Cryptography":
          request()->session()->put('currentIndividualTaskName', 'Cryptography Task');
          return redirect('/cryptography-individual-intro');

        case "Optimization":
          request()->session()->put('currentIndividualTaskName', 'Optimization Task');
          return redirect('/optimization-individual-intro');

        case "Memory":
          request()->session()->put('currentIndividualTaskName', 'Memory Task');
          return redirect('/memory-individual');

        case "Eyes":
          request()->session()->put('currentIndividualTaskName', 'Eyes Task');
          return redirect('/rmet-individual');

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
             ->with('results', $request->session()->get('currentIndividualTaskResult'));

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
      return view('layouts.participants.participant-experiment-end');
    }

    public function teamRoleIntro(Request $request) {
      return view('layouts.participants.tasks.team-role-intro');
    }

    public function teamRole(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $scenarios = (new \Teamwork\Tasks\TeamRole)->getScenarios();
      return view('layouts.participants.tasks.team-role')
             ->with('scenarios', $scenarios);
    }

    public function saveTeamRole(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $scenarios = (new \Teamwork\Tasks\TeamRole)->getScenarios();
      // NEED TO SCORE AND SAVE
      $results = 'You have now completed the Team Role Test.<br>Press Continue to move on to the next task.';
      $request->session()->put('currentIndividualTaskResult', $results);
      $request->session()->put('currentIndividualTaskName', 'Team Role Test');

      return redirect('\individual-task-results');
    }

    public function teamRoleEnd(Request $request) {
      return view('layouts.participants.tasks.team-role-end');
    }

    public function bigFiveIntro(Request $request) {
      return view('layouts.participants.tasks.big-five-intro');
    }

    public function bigFive(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $statements = (new \Teamwork\Tasks\BigFive)->getStatements($parameters->statementOrder);
      return view('layouts.participants.tasks.big-five')
             ->with('statements', $statements);
    }

    public function saveBigFive(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $statements = (new \Teamwork\Tasks\BigFive)->getStatements('ordered');
      // NEED TO SCORE AND SAVE
      return redirect('/big-five-end');
    }

    public function bigFiveEnd(Request $request) {
      return view('layouts.participants.tasks.big-five-end');
    }

    public function cryptographyIntro(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $maxResponses = $parameters->maxResponses;
      $mapping = (new \Teamwork\Tasks\Cryptography)->getMapping('random');
      $aSorted = $mapping;
      asort($aSorted); // Sort, but preserve key order
      $sorted = $mapping;
      sort($sorted); // Sort and re-index
      return view('layouts.participants.tasks.cryptography-individual-intro')
             ->with('maxResponses', $maxResponses)
             ->with('mapping', json_encode($mapping))
             ->with('aSorted', $aSorted)
             ->with('sorted', $aSorted);
    }

    public function optimizationIntro() {
      return view('layouts.participants.tasks.optimization-individual-intro');
    }

    public function optimization(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $function = (new \Teamwork\Tasks\Optimization)->getFunction($parameters->function);
      $maxResponses = $parameters->maxResponses;
      return view('layouts.participants.tasks.optimization-individual')
             ->with('function', $function)
             ->with('maxResponses', $maxResponses)
             ->with('hasGroup', $parameters->hasGroup);
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

    public function saveOptimizationFinalGuess(Request $request) {

      $groupTaskId = $request->session()->get('currentGroupTask');
      $individualTaskId = $request->session()->get('currentIndividualTask');

      $r = new Response;
      $r->group_tasks_id = $groupTaskId;
      $r->individual_tasks_id = $individualTaskId;
      $r->user_id = \Auth::user()->id;
      $r->prompt = $request->function .": final";
      $r->response = $request->final;
      $r->save();

      return redirect('/end-individual-task');

    }

    public function memoryIntro(Request $request) {
      return view('layouts.participants.tasks.memory-individual-intro');
    }

    public function memory(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $tests = [];
      foreach ($parameters->test as $key => $test) {
        $tests[] = (new \Teamwork\Tasks\Memory)->getTest($test);
      }

      return view('layouts.participants.tasks.memory-individual')
             ->with('tests', $tests)
             ->with('enc_tests', json_encode($tests));
    }

    public function saveMemory(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $parameters = unserialize($currentTask->parameters);
      $tests = [];
      foreach ($parameters->test as $key => $test) {
        $tests[] = (new \Teamwork\Tasks\Memory)->getTest($test);
      }

      // Retrieve all responses
      $responses = array_where($request->request->all(), function ($value, $key) {
        return strpos($key, 'response') !== false;
      });


      foreach ($tests as $key => $t) {
        $testCount = count(array_where($t['blocks'], function($b, $k){
          return $b['type'] == 'test';
        }));

        $correct[$key] = ['name' => $t['test_name'],
                          'correct'  => 0,
                          'count' =>$testCount];
      }

      // Look up the test based on the response key
      foreach ($responses as $key => $response) {

        $indices = explode('_', $key);
        $test = $tests[$indices[1]]['blocks'][$indices[2]];

        $saveCorrect = 0; // Holds the value for is_correct in the responses table;

        // If the response is a single item
        if($test['selection_type'] == 'select_one') {

          if($test['correct'][0] == $response) {
            $saveCorrect = 1;
            $correct[$indices[1]]['correct']++;
          }
        }

        // Otherwise, process arrays of responses against arrays of correct answers
        else {
          $isCorrect = true;
          foreach($response as $selected) {
            if(!in_array($selected, $test['correct'])) $isCorrect = false;
          }
          if($isCorrect){
            $correct[$indices[1]]['correct']++;
            $saveCorrect = 1;
          }
        }
        /*
        $r = new Response;
        $r->prompt = $test;
        if(is_array($response)) {
          dump($response.' is an array');
          $r->response = json_encode($response);
        }

        else $r->response = $response;
        $r->is_correct = $saveCorrect;
        $r->save();
        */
      }

      $results = '';
      foreach($correct as $c) {
        $results .= 'Test: '.$c['name'].' Result: '.$c['correct'].' out of '.$c['count'].'<br>';
      }
      $request->session()->put('currentIndividualTaskResult', $results);
      $request->session()->put('currentIndividualTaskName', 'Memory Test');

      return redirect('\individual-task-results');

    }

    public function eyes(Request $request) {
      $tests = (new \Teamwork\Tasks\Eyes)->getTest();

      $dir = (new \Teamwork\Tasks\Eyes)->getDirectory();
      return view('layouts.participants.tasks.eyes-individual')
             ->with('dir', $dir)
             ->with('tests', $tests);
    }

    public function saveEyes(Request $request) {
      $tests = (new \Teamwork\Tasks\Eyes)->getTest();
      $correct = 0;

      foreach ($request->all() as $key => $value) {
        if($key == '_token') continue;
        $isCorrect = 0;
        if($value == $tests[$key]['correct']){
          $isCorrect = 1;
          $correct++;
        }
        /*
        $response = new Response;
        $response->prompt = $tests[$key]['img'];
        $response->response = $value;
        $reponse->is_correct = $isCorrect;
        $response->save();
        */
      }

      $results = 'You scored '.$correct.' out of '.count($tests);

      $request->session()->put('currentIndividualTaskResult', $results);
      $request->session()->put('currentIndividualTaskName', 'Memory Test');
      return redirect('\individual-task-results');
    }

    public function brainstormingIntro() {
      return view('layouts.participants.tasks.brainstorming-individual-intro');
    }

    public function brainstorming(Request $request) {

      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));

      $task = new Task\Brainstorming;

      $prompt = unserialize($currentTask->parameters)->prompt;

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

      $results = 'You earned '.$correct.' points for this task.';
      $request->session()->put('currentIndividualTaskResult', $results);
      $request->session()->put('currentIndividualTaskName', 'Shapes Task');
      return redirect('\individual-task-results');
    }

    public function testMemory() {
      $tests = [];
      $tests[] = (new \Teamwork\Tasks\Memory)->getTest('faces_1');

      dump($tests);
      return view('layouts.participants.tasks.memory-individual')
             ->with('tests', $tests)
             ->with('enc_tests', json_encode($tests));
    }

}
