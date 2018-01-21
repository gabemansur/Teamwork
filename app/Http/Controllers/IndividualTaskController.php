<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;

class IndividualTaskController extends Controller
{
    public function getTask() {

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
       dump('THE EXPERIMENT IS OVER');
       return;
     }

     // If there are no tasks at all, let's create some
     else if(count($groupTasksAll) == 0) {
       // Alternately, we could display a message for the user to login as a group
       // because the following code is duplicated in the group task controller
       $groupTasks = \Teamwork\GroupTask::initializeDefaultTasks(\Auth::user()->group_id, $randomize = true);
     }

      $task = $groupTasks->first();
      $individualTask = $task->individualTasks->first();

      if($individualTask) {
        dump($task->name . " THIS IS AN INDIVIDUAL TASK");
      }

      else {
        return view('layouts.participants.participant-group-task');
      }


    }
}
