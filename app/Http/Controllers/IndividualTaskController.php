<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use \Teamwork\Tasks as Task;
use Teamwork\Response;
use \Teamwork\Time;

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
          return redirect('/memory-individual-intro');

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

      // Record the start time for this task
      $time = Time::firstOrNew(['user_id' => \Auth::user()->id,
                                'group_tasks_id' => $request->session()->get('currentGroupTask'),
                                'individual_tasks_id' => $request->session()->get('currentIndividualTask')]);
      $time->recordStartTime();

      return view('layouts.participants.tasks.team-role')
             ->with('scenarios', $scenarios);
    }

    public function saveTeamRole(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $individualTaskId = $request->session()->get('currentIndividualTask');
      $parameters = unserialize($currentTask->parameters);
      $scenarios = (new \Teamwork\Tasks\TeamRole)->getScenarios();

      // Record the end time for this task
      $time = Time::where('user_id', '=', \Auth::user()->id)
                  ->where('group_tasks_id', '=', $currentTask->id)
                  ->first();
      $time->recordEndTime();

      // Save each response
      foreach ($request->all() as $key => $answer) {
        if($key == '_token') continue;
        $indices = explode('_', $key);
        $scenario = $scenarios[$indices[1]]['responses'][$indices[3]];

        $r = new Response;
        $r->group_tasks_id = $currentTask->id;
        $r->individual_tasks_id = $individualTaskId;
        $r->user_id = \Auth::user()->id;
        $r->prompt = $scenario['response'];
        $r->response = $answer;
        $r->save();
      }

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

      // Record the start time for this task
      $time = Time::firstOrNew(['user_id' => \Auth::user()->id,
                                'group_tasks_id' => $request->session()->get('currentGroupTask'),
                                'individual_tasks_id' => $request->session()->get('currentIndividualTask')]);
      $time->recordStartTime();

      return view('layouts.participants.tasks.big-five')
             ->with('statements', $statements);
    }

    public function saveBigFive(Request $request) {
      $currentTask = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
      $individualTaskId = $request->session()->get('currentIndividualTask');
      $parameters = unserialize($currentTask->parameters);
      $statements = (new \Teamwork\Tasks\BigFive)->getStatements('ordered');

      // Record the end time for this task
      $time = Time::where('user_id', '=', \Auth::user()->id)
                  ->where('group_tasks_id', '=', $currentTask->id)
                  ->first();
      $time->recordEndTime();

      foreach ($statements as $key => $statement) {
        $r = new Response;
        $r->group_tasks_id = $currentTask->id;
        $r->individual_tasks_id = $individualTaskId;
        $r->user_id = \Auth::user()->id;
        $r->prompt = $statement['statement'];
        $r->response = $request[$statement['number']];
        $r->save();
      }

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

      // Record the start time for this task
      $time = Time::firstOrNew(['user_id' => \Auth::user()->id,
                                'group_tasks_id' => $currentTask->id,
                                'individual_tasks_id' => $request->session()->get('currentIndividualTask')]);
      $time->recordStartTime();

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

      // Record the end time for this task
      $time = Time::where('user_id', '=', \Auth::user()->id)
                  ->where('group_tasks_id', '=', $currentTask->id)
                  ->first();
      $time->recordEndTime();

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
                          'points'  => 0,
                          'count' =>$testCount,
                          'task_type' => $t['task_type']];
      }

      // Look up the test based on the response key
      foreach ($responses as $key => $response) {

        $indices = explode('_', $key);
        $test = $tests[$indices[1]]['blocks'][$indices[2]];

        $points = 0;

        // If the response is a single item
        if($test['selection_type'] == 'select_one') {

          if($test['correct'][0] == $response) {
            $correct[$indices[1]]['points'] += 3;
            $points = 3;
          }
        }

        // Otherwise, process arrays of responses against arrays of correct answers
        else {

          foreach($response as $selected) {
            if($selected == '0' && count($test['correct']) == 0) {
              $points = 3;
              $correct[$indices[1]]['points'] += 3;
              continue;
            }
            if(in_array($selected, $test['correct'])){
              $points++;
              $correct[$indices[1]]['points']++;
            }
          }
        }

        $r = new Response;
        $r->user_id = \Auth::user()->id;
        $r->group_tasks_id = $currentTask->id;
        $r->individual_tasks_id = $request->session()->get('currentIndividualTask');
        $r->prompt = serialize($test);
        if(is_array($response)) {
          $r->response = serialize($response);
        }
        else $r->response = $response;
        $r->points = $points;
        $r->save();

      }

      $results = '';
      $bestTest['test'] = '';
      $bestTest['score'] = 0;
      $bestTest['task_type'] = '';

      foreach($correct as $c) {
        if($c['points'] / 3 > $bestTest['score']) {
          $bestTest['score'] = $c['points'] / 3;
          $bestTest['test'] = $c['name'];
          $bestTest['task_type'] = $c['task_type'];

        }
        $results .= 'You performed best on the '. $bestTest['task_type'] .' test.<br>';
      }

      $request->session()->put('currentIndividualTaskResult', $results);
      $request->session()->put('currentIndividualTaskName', 'Memory Task');

      return redirect('\individual-task-results');

    }

    public function eyes(Request $request) {
      $tests = (new \Teamwork\Tasks\Eyes)->getTest();

      $dir = (new \Teamwork\Tasks\Eyes)->getDirectory();

      // Record the start time for this task
      $time = Time::firstOrNew(['user_id' => \Auth::user()->id,
                                'group_tasks_id' => $request->session()->get('currentGroupTask'),
                                'individual_tasks_id' => $request->session()->get('currentIndividualTask')]);
      $time->recordStartTime();

      return view('layouts.participants.tasks.eyes-individual')
             ->with('dir', $dir)
             ->with('tests', $tests);
    }

    public function saveEyes(Request $request) {
      $groupTaskId = $request->session()->get('currentGroupTask');
      $individualTaskId = $request->session()->get('currentIndividualTask');

      // Record the end time for this task
      $time = Time::where('user_id', '=', \Auth::user()->id)
                  ->where('group_tasks_id', '=', $groupTaskId)
                  ->first();
      $time->recordEndTime();

      $tests = (new \Teamwork\Tasks\Eyes)->getTest();
      $correct = 0;
      $isCorrect = false;

      foreach ($request->all() as $key => $value) {
        if($key == '_token') continue;
        $isCorrect = false;
        if($value == $tests[$key]['correct']){
          $isCorrect = true;
          $correct++;
        }

        $response = new Response;
        $response->user_id = \Auth::user()->id;
        $response->group_tasks_id = $groupTaskId;
        $response->individual_tasks_id = $individualTaskId;
        $response->prompt = $tests[$key]['img'];
        $response->response = $value;
        $response->correct = $isCorrect;
        $response->save();

      }

      $results = 'You scored '.$correct.' out of '.count($tests);

      $request->session()->put('currentIndividualTaskResult', $results);
      $request->session()->put('currentIndividualTaskName', 'Eyes Task');
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
