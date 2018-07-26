<?php
namespace Teamwork\Tasks;

class Intro {

  private $intro = [
    'mTurk' => [[
                  'type' => 'paragraph',
                  'content' => 'Welcome etc...'
                ],
                [
                  'type' => 'paragraph',
                  'content' => 'For many of these tasks, we have
                      a PRACTICE to explain how the tasks work.
                      They won’t be counted towards your score.
                      But, it is important to try to get these
                      simple questions correct, as we use them to
                      gauge if you read and understood the
                      instructions.'
                ]
      ],
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['false'], 'type' => ['mTurk']];

  public function getIntro($type) {
    return $this->intro[$type];
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
