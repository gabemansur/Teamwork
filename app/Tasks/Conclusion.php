<?php
namespace Teamwork\Tasks;
use Teamwork\ConfirmationCode;

class Conclusion {

  private $conclusions = [
    'mturk' => [[
                  'type' => 'sub-header',
                  'content' => 'You\'ve completed all the tasks!'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'Thank you for participating!'
                ],
      ],
    'hdsl_individual' => [[
                  'type' => 'sub-header',
                  'content' => 'You\'ve completed all the tasks!'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'Thank you for participating!'
                ],
      ],

    'group_1' => [[
                  'type' => 'sub-header',
                  'content' => 'Your group has completed all of its tasks!'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'Please let a member of the Lab staff know that your group is finished.'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'They will let you know what to do next.'
                ],
      ],

    'group_2' => [[
                  'type' => 'sub-header',
                  'content' => 'You\'ve completed all the tasks for today!'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'Please take a moment to fill out this quick exit survey'
                ],

                [
                  'type' => 'sub-header',
                  'content' => '<a class="btn btn-lg btn-primary" href="https://docs.google.com/forms/d/1ZZV8P_dyifFn4DRhalN82126POz3R-SgCWXvTo7DMaU/viewform?edit_requested=true">
                  Exit Survey</a>'
                ],
      ],

    'group_5' => [[
                  'type' => 'sub-header',
                  'content' => 'Your group has completed all of its tasks!'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'Please let a member of the Lab staff know that your group is finished.'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'They will let you know what to do next.'
                ]]
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['false'], 'type' => ['mturk', 'hdsl_individual'], 'hasCode' => ['true', 'false'], 'feedback' => ['true', 'false']];

  public function getConclusion($type) {
    return $this->conclusions[$type];
  }

  public function newConfirmationCode($type) {
    return ConfirmationCode::where('user_id', null)
                            ->where('type', $type)
                            ->first();
  }

  public function getConfirmationCode($user_id) {
    return ConfirmationCode::where('user_id', $user_id)
                            ->first();
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
