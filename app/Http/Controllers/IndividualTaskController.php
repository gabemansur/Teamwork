<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;

class IndividualTaskController extends Controller
{
    public function getTask() {

      $groupTasks = \Teamwork\GroupTask::where('group_id', \Auth::user()->group_id)
                             ->where('completed', false)
                             ->with('individualTasks')
                             ->orderBy('order', 'ASC')
                             ->get();

      if(count($groupTasks) == 0) {
        // NO TASKS
      }

      $task = $groupTasks->first();
      $individualTask = $task->individualTasks->first();

      if($individualTask) {
        dump("THIS IS AN INDIVIDUAL TASK");
      }

      else {
        return view('layouts.participants.participant-group-task');
      }


    }
}
