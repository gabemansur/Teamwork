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

    // Returns an array of groups that contain 1 person (i.e. Individual Task participants)
    private function getIndividualGroups() {
      $groups = \DB::select( \DB::raw("SELECT group_id
      FROM group_user
      GROUP BY group_id
      HAVING COUNT(*) = 1"));
      $groupIds = [];
      foreach($groups as $key => $group) {
        $groupIds[] = $group->group_id;
      }
      return $groupIds;
    }

    public function getIndividualTaskResponses() {
      $groups = $this->getIndividualGroups();
      $userData = [];

      foreach ($groups as $key => $group) {
        $userId = \DB::table('group_user')
                     ->where('group_id', $group)
                     ->pluck('user_id')
                     ->first();

        $users = \Teamwork\User::where('id', $userId)
                              ->with('group')
                              ->get();

        array_push($userData, $this->collectResponses($users, $group));

      }

      return view('layouts.admin.data')
             ->with('userData', $userData);
    }

    public function getGroupTaskResponses() {

      $individualGroups = $this->getIndividualGroups();

      $userGroups = \DB::table('group_user')
                   ->whereNotIn('group_id', $individualGroups)
                   ->get();

      $userData = [];

      foreach($userGroups as $k => $userGroup) {
        $users = \Teamwork\User::where('id', $userGroup->user_id)
                               ->with('group')
                               ->get();

        array_push($userData, $this->collectResponses($users, $userGroup->group_id));
        // Pass reference to userData so we can push to it inside the closure
        /*
        $users->chunk(1, function ($users) use(&$userData) {
              array_push($userData, $this->collectResponses($users, $userGroup->group_id));
        });
        */
      }

      return view('layouts.admin.data')
             ->with('userData', $userData);
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



    private function collectResponses($users, $groupId) {
      $userData = [];
      foreach ($users as $key => $user) {

          $reporterCheck = \DB::table('reporters')
             ->where('user_id', $user->id)
             ->where('group_id', $groupId)
             ->first();

          $isReporter = ($reporterCheck) ? true : false;

          $group = \Teamwork\Group::find($groupId);


          $uData = ['user' => $user->participant_id,
                    'isReporter' => $isReporter,
                    'eligible' => $user->score_group,
                    'surveyCode' => $user->survey_code,
                    'group'=> $group->group_number,
                    'tasks' => []];

          $groupTasks = \Teamwork\GroupTask::with('response')
                                           ->where('group_id', $groupId)
                                           ->get();

          foreach ($groupTasks as $k => $task) {

            $taskTime = \DB::table('times')
                       ->where('user_id', $user->id)
                       ->where('group_tasks_id', $task->id)
                       ->where('type', 'task')
                       ->first();

            if($taskTime && $taskTime->start_time && $taskTime->end_time) {
              $taskTime = strtotime($taskTime->end_time) - strtotime($taskTime->start_time);
            }

            else $taskTime = null;

            $introTime = \DB::table('times')
                       ->where('user_id', $user->id)
                       ->where('group_tasks_id', $task->id)
                       ->where('type', 'intro')
                       ->first();

            if($introTime && $introTime->start_time && $introTime->end_time) {
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
              if($response->user_id != $user->id) continue;
              if($task->name == 'Memory') {

                //$u = unserialize($response->prompt);
                if($response->prompt == 'Memory stimulus type') {
                  $t = (strtotime($response->updated_at) - strtotime($response->created_at));
                  $response->response .= ' (' .$t. ' secs)';
                }
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
      return $userData;
    }

}
