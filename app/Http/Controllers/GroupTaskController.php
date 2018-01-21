<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use Teamwork\GroupTask;
use \Teamwork\Tasks as Task;

class GroupTaskController extends Controller
{
    public function getTask() {
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
        dump('THE EXPERIMENT IS OVER');
        return;
      }

      // If there are no tasks at all, let's create some
      else if(count($groupTasksAll) == 0) {
        $groupTasks = GroupTask::initializeDefaultTasks($group_id, $randomize = true);
      }

      $currentTask = $groupTasks->first();

      if($currentTask->individualTasks->isNotEmpty() && !$currentTask->individualTasks->first()->completed) {
        // SHOW INDIVIDUAL TASK PROMPT
        return view('layouts.participants.group-participant-task');
      }

      return $this->routeTask($currentTask);
    }

    public function routeTask($task) {

      switch($task->name) {
        case "UnscrambleWords":
          return redirect('/unscramble-words-group');

        case "Brainstorming":
          return redirect('/brainstorming-group');
      }

    }

    public function unscrambleWords() {

      $wordTask = new Task\UnscrambleWords();
      dump($wordTask->getScrambledWords());


    }
}
