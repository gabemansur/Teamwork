<?php
namespace Teamwork\Tasks;

class Conclusion {

  private $conclusions = [
    'mTurk' => [[
                  'type' => 'sub-header',
                  'content' => 'You\'ve completed all the tasks!'
                ],
                [
                  'type' => 'sub-header',
                  'content' => 'Thank you for participating!'
                ],
      ],
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['false'], 'type' => ['mTurk'], 'hasCode' => ['true', 'false']];

  public function getConclusion($type) {
    return $this->conclusions[$type];
  }

  public function getMturkCode() {
    // This is where we'll give them a confirmation code to enter into their MTurk survey.
    // For now, it's just a random string...
    return uniqid();
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
