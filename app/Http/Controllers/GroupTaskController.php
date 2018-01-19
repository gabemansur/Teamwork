<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use Teamwork\GroupTask;

class GroupTaskController extends Controller
{
    public function getTask() {
      $group_id = \Auth::user()->group_id;

      $groupTasks = GroupTask::where('group_id', $group_id)
                             ->where('completed', false)
                             ->with('individualTasks')
                             ->orderBy('order', 'ASC')
                             ->get();

      if(count($groupTasks) == 0) {
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

      $wordTask = new \Teamwork\Tasks\UnscrambleWords;
      dump($wordTask->getWords());


    }
}
