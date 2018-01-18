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


      // Check if a user with this participant_id already exists
      $user = User::firstOrCreate(['participant_id' => $request->participant_id],
                                  ['name' => 'partipant',
                                   'participant_id' => $request->participant_id,
                                   'password' => bcrypt('participant'),
                                   'role_id' => 3,
                                   'group_id' => $group->id]);
      $user->save();

       if($group->id != $user->group_id) {
         \Session::flash('message', 'It appears that you already belong to a different group.');
         return view('layouts.participants.participant-login')
                ->with('request', $request);
       }

    }
}
