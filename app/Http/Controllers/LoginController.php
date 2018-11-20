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

    public function participantPackageLogin($package) {

      return view('layouts.participants.participant-login')
             ->with($package);
    }

    public function postParticipantLogin(Request $request) {

      $group = Group::firstOrCreate(['group_number' => $request->group_id]);
      $group->save();

      $user = User::firstOrCreate(['participant_id' => $request->participant_id],
                                  ['name' => 'participant',
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

    public function individualLogin() {
      return view('layouts.participants.individual-only-login');
    }

    public function individualPackageLogin($package) {
      return view('layouts.participants.individual-only-login')
             ->with('package', $package);
    }

    public function postIndividualLogin(Request $request) {

      // If the user already exists, load their tasks and redirect
      $user = User::where('participant_id', $request->participant_id)->first();
      if($user) {
        \Auth::login($user);
        return redirect('/get-individual-task');
      }
      // Otherwise, continue to create a group and user and load the appropriate tasks
      $group = Group::firstOrCreate(['group_number' => uniqid()]);
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

       if(isset($request->task_package)) {
         if($request->task_package == 'eq') \Teamwork\GroupTask::initializeEQTasks(\Auth::user()->group_id, $randomize = false);
         if($request->task_package == 'iq') \Teamwork\GroupTask::initializeIQTasks(\Auth::user()->group_id, $randomize = false);
         if($request->task_package == 'block-a') \Teamwork\GroupTask::initializeBlockATasks(\Auth::user()->group_id, $randomize = false);
         if($request->task_package == 'block-b') \Teamwork\GroupTask::initializeBlockBTasks(\Auth::user()->group_id, $randomize = false);
         if($request->task_package == 'block-c') \Teamwork\GroupTask::initializeBlockCTasks(\Auth::user()->group_id, $randomize = false);
         if($request->task_package == 'block-d') \Teamwork\GroupTask::initializeBlockDTasks(\Auth::user()->group_id, $randomize = false);
         if($request->task_package == 'assign-block') \Teamwork\GroupTask::initializeAssignedBlockTasks(\Auth::user()->group_id, $randomize = false);
         if($request->task_package == 'memory') \Teamwork\GroupTask::initializeMemoryTasks(\Auth::user()->group_id, $randomize = false);
         if($request->task_package == 'testing-block') \Teamwork\GroupTask::initializeTestingTasks(\Auth::user()->group_id, $randomize = false);

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

      \Teamwork\GroupTask::initializeTasks($group->id, $request->taskArray);

      $tasks = \Teamwork\GroupTask::getTasks();

      \Session::flash('message','Group ' .$request->group_id. ' was created.');
      return redirect('/group-create');
    }

    public function groupAddParticipants() {
      return view('layouts.participants.group-add-participants');
    }

    public function postGroupAddParticipants(Request $request) {

      $group = Group::firstOrCreate(['group_number' => $request->group_id]);
      $group->save();

      $participants = explode(';', $request->participant_ids);

      foreach ($participants as $key => $participant_id) {
        $user = User::firstOrCreate(['participant_id' => trim($participant_id)],
                                    ['name' => 'partipant',
                                     'participant_id' => trim($participant_id),
                                     'password' => bcrypt('participant'),
                                     'role_id' => 3,
                                     'group_id' => $group->id]);
        $user->save();
      }

      \Session::flash('message', 'Participant IDs '.$request->participant_ids. ' were added to group '.$group->id);
      return redirect('/group-add-participants');

    }
}
