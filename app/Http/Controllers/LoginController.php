<?php

namespace Teamwork\Http\Controllers;

use Illuminate\Http\Request;
use Teamwork\User;
use Teamwork\Group;

class LoginController extends Controller
{
    public function participantLogin() {
      return view('layouts.participants.participant-login');
    }

    public function postParticipantLogin(Request $request) {

      $group = Group::firstOrCreate(['group_number' => $request->group_id]);
      $group->save();

      $user = User::firstOrCreate(['participant_id' => $request->participant_id],
                                  ['name' => 'partipant',
                                   'participant_id' => $request->participant_id,
                                   'password' => bcrypt('participant'),
                                   'role_id' => 3,
                                   'group_id' => $group->id]);
      $user->save();
      \Auth::login($user);

       if($group->id != $user->group_id) {
         return redirect()->back()->withInput()->withErrors('It appears that you already belong to another group.');
       }

       return redirect('/get-individual-task');
    }

    public function groupLogin() {
      return view('layouts.participants.group-login');
    }

    public function postGroupLogin(Request $request) {

      $group = Group::firstOrCreate(['group_number' => $request->group_id]);
      $group->save();

      // Find or create a group user, for authentication purposes
      $user = User::firstOrCreate(['group_id' => $group->id,
                                   'role_id' => 4],
                                  ['name' => 'group',
                                   'participant_id' => null,
                                   'password' => bcrypt('group')]);
      \Auth::login($user);

      return redirect('/get-group-task');
    }

    public function groupCreateLogin() {
      $tasks = \Teamwork\GroupTask::getTasks();
      foreach ($tasks as $key => $task) {
        $class = "\Teamwork\Tasks\\".$task['name'];
        //$tasks[$key]['params'] = \Teamwork\Tasks\Cryptography::getAvailableParams();
        $tasks[$key]['params'] = $class::getAvailableParams();
      }
      dump($tasks);
      return view('layouts.participants.group-create-login')
             ->with('tasks', $tasks);
    }

    public function postGroupCreateLogin(Request $request) {

      $group = Group::firstOrCreate(['group_number' => $request->group_id]);
      $group->save();

      // Find or create a group user, for authentication purposes
      $user = User::firstOrCreate(['group_id' => $group->id,
                                   'role_id' => 4],
                                  ['name' => 'group',
                                   'participant_id' => null,
                                   'password' => bcrypt('group')]);

      \Teamwork\GroupTask::initializeTasks($group->id, $request->tasks);

      $tasks = \Teamwork\GroupTask::getTasks();

      \Session::flash('message','Group ' .$request->group_id. ' was created.');
      return view('layouts.participants.group-create-login')
             ->with('tasks', $tasks);
    }
}
