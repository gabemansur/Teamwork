<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getResponses() {

      $users = \Teamwork\User::where('role_id', 3)
                             ->with('group')
                             ->get();

      $userData = [];

      foreach ($users as $key => $user) {

        $groupTasks = \Teamwork\GroupTask::with('response')
                                    ->find($user->group->id)
                                    ->get();

        $uData = ['user' => $user->id,
                  'group'=> $user->group->id,
                  'tasks' => []];

        foreach ($groupTasks as $k => $task) {

          $time = \DB::table('times')
                     ->where('user_id', $user->id)
                     ->where('group_tasks_id', $task->id)
                     ->first();

          if($time) {
            $t = strtotime($time->end_time) - strtotime($time->start_time);
          }

          else $t = null;


          try {
            $params = unserialize($task->parameters);
          }

          catch(\Exception $e) {
            $params = null;
          }


          $taskData = ['name' => $task->name,
                       'parameters' => $params,
                       'time' => $t,
                       'responses' => []];

          $responses = [];
          foreach ($task->response as $response) {
            $responses[] = ['prompt' => $response->prompt,
                            'response' => $response->response,
                            'correct' => $response->correct,
                            'points' => $response->points,
                            'time' => $response->time];
            array_push($taskData['responses'], $responses);
          }
          dump($taskData);
          //array_push($uData['tasks'], $taskData);
        }

        //array_push($userData, $uData);
      }
      //dump($userData);

    }
}
