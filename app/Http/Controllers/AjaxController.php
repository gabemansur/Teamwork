<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use Teamwork\Response;

class AjaxController extends Controller
{
  /**
   * Allows a task to be marked as completed via AJAX
   * so that individuals can confirm completion of their
   * portion of the task while remaining on-page.
   * @param  Request $response AJAX response data
   * @return void
   */
  public function markIndividualResponseComplete(Request $request) {

    $task = \Teamwork\GroupTask::with('response')
                               ->find($request->session()->get('currentGroupTask'));

    $individualTask = \Teamwork\IndividualTask::find($request->session()->get('currentIndividualTask'));



    $numUsersResponded = count($task->response->groupBy('user_id'));
    $usersInGroup = \Teamwork\User::where('group_id', \Auth::user()->group_id)
                                  ->where('role_id', 3)
                                  ->count();


    if($request->maxResponses) {

      $total_responses = count($task->response);

      if($total_responses == ($request->maxResponses * $usersInGroup)) {
        $individualTask->completed = true;
        $individualTask->save();
        $task->completed = $request->completeGroupTaskAlso;
        $task->save();
      }
    }
    else if($numUsersResponded == $usersInGroup) {
      $individualTask->completed = true;
      $individualTask->save();
      $task->completed = $request->completeGroupTaskAlso;
      $task->save();
    }

  }

  /**
   * Stores results of the current task in Session
  */
  public function storeTaskData(Request $request) {

    $data = json_decode($request->data);
    $request->session()->put('currentTaskData', $data);
  }

  /**
   * Checks if individual tasks are completed, meaning it is
   * safe for one member to login under the group ID to provide
   * a group response.
   */
   public function groupLoginAllowed(Request $request) {
     $individualTask = \Teamwork\IndividualTask::find($request->session()->get('currentIndividualTask'));
     echo $individualTask->completed;
   }

   /**
    * Returns if task is complete or not. This way,
    * we can keep users on a page until it is time for
    * them to continue.
    * @param  Request $request [description]
    * @return [type]           [description]
    */
   public function checkTaskCompletion(Request $request) {
     $task = \Teamwork\GroupTask::find($request->session()->get('currentGroupTask'));
     echo $task->completed;
   }
}
