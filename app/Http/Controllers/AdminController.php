<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\Concerns\FromView;

class AdminController extends Controller
{

    public function getCSV() {


      $users = \Teamwork\User::where('role_id', 3)
                             ->with('group');

      $userData = [];

      // Pass reference to userData so we can push to it inside the closure
      $users->chunk(1, function ($users) use(&$userData) {
            array_push($userData, $this->collectResponses($users));
      });

      $responses = [];
      foreach($userData as $data) {
        foreach($data as $user) {
          foreach($user['tasks'] as $task) {
           foreach($task['responses'] as $responses) {
            foreach($responses as $response) {

                $responses[] = ['user' => $user['user'],
                                'group' => $user['group'],
                                'task' => $task['name'],
                                'introTime' => $task['introTime'],
                                'taskTime' => $task['taskTime'],
                                'prompt' => $response['prompt'],
                                'response' => $response['response'],
                                'correct' => $response['correct'],
                                'points' => $response['points'],
                                'time' => $response['time']];
            }
          }
        }
      }
    }
      $collection = collect($responses);
      $filedate = date('Y-m-d');

      return Excel::create('TaskData_'.$filedate, function($excel) use($collection){

        $excel->sheet('TaskResponses', function($sheet) use($collection){
            $sheet->fromModel($collection, null, 'A1', true);
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

      return view('layouts.admin.data')
             ->with('userData', $userData);
    }

    private function collectResponses($users) {
      $userData = [];
      foreach ($users as $key => $user) {

          $uData = ['user' => $user->participant_id,
                    'group'=> $user->group->id,
                    'tasks' => []];

          $groupTasks = \Teamwork\GroupTask::with('response')
                                           ->where('group_id', $user->group->id)
                                           ->get();

          foreach ($groupTasks as $k => $task) {

            $taskTime = \DB::table('times')
                       ->where('user_id', $user->id)
                       ->where('group_tasks_id', $task->id)
                       ->where('type', 'task')
                       ->first();

            if($taskTime) {
              $taskTime = strtotime($taskTime->end_time) - strtotime($taskTime->start_time);
            }

            else $taskTime = null;

            $introTime = \DB::table('times')
                       ->where('user_id', $user->id)
                       ->where('group_tasks_id', $task->id)
                       ->where('type', 'intro')
                       ->first();

            if($introTime) {
              $introTime = strtotime($introTime->end_time) - strtotime($introTime->start_time);
            }

            else $introTime = null;


            try {
              $params = json_encode(unserialize($task->parameters));
            }

            catch(\Exception $e) {
              $params = null;
            }


            $taskData = ['name' => $task->name,
                         'parameters' => $params,
                         'taskTime' => $taskTime,
                         'introTime' => $introTime,
                         'responses' => []];

            $responses = [];
            foreach ($task->response as $response) {
              if($task->name == 'Memory') {

                $u = unserialize($response->prompt);

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
