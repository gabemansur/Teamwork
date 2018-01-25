<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use Teamwork\GroupTask;
use Teamwork\Response;
use \Teamwork\Tasks as Task;

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
}
