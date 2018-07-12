<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use Excel;

class AdminController extends Controller
{

    public function xxgetResponses() {


      $data = \Teamwork\User::where('role_id', 3)
                             ->with('group');


      $filedate = date('Y_m_d');


      return Excel::create('TaskData'.$filedate, function($excel) use($data){

          $data->chunk(10, function ($users) use($excel) {

                $collection = $this->collectResponses($users);

                $excel->sheet('TaskResponses', function($sheet) use($collection){
                    $sheet->fromModel($collection, null, 'A1', true);
                });
          });

        })->export('xls');


    }

    public function getResponses() {
      $users = \Teamwork\User::where('role_id', 3)
                             ->with('group');

      $userData = [];

      // Pass reference to userData so we can push to it inside the closure
      $users->chunk(1, function ($users) use(&$userData) {
            array_push($userData, $this->collectResponses($users));
      });

      /*
      foreach($userData as $data) {
        foreach($data as $user) {
          foreach($user['tasks'] as $task) {
            foreach($task['responses'] as $response) {
              dump($response);
            }
          }
        }
      }
      */

      return view('layouts.admin.data')
             ->with('userData', $userData);
    }

    private function collectResponses($users) {
      $userData = [];
      foreach ($users as $key => $user) {

          $uData = ['user' => $user->id,
                    'group'=> $user->group->id,
                    'tasks' => []];

          $groupTasks = \Teamwork\GroupTask::with('response')
                                           ->where('group_id', $user->group->id)
                                           ->get();

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
              $params = json_encode(unserialize($task->parameters));
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
              if($task->name == 'Memory') {

                $u = unserialize($response->prompt);
                dump($u);
              }
              $responses[] = ['prompt' => $response->prompt,
                              'response' => $response->response,
                              'correct' => $response->correct,
                              'points' => $response->points,
                              'time' => $response->created_at];

            }
            array_push($taskData['responses'], $responses);
            array_push($uData['tasks'], $taskData);
          }
        array_push($userData, $uData);
      }
      //dump($userData);
      return $userData;
    }

}
