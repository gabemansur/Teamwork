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
                  'content' => 'You\'ve completed all the tasks!'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'Please return to the waiting area to join your next group'
                ],
      ],

    'group_2' => [[
                  'type' => 'sub-header',
                  'content' => 'You\'ve completed all the tasks for today!'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'Click the button below to sign your digital receipt.'
                ],
      ],
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['false'], 'type' => ['mturk', 'hdsl_individual'], 'hasCode' => ['true', 'false']];

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
