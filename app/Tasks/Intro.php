<?php
namespace Teamwork\Tasks;

class Intro {

  private $intro = [
    'mTurk' => [[
                  'type' => 'header',
                  'content' => 'Welcome to the Harvard Study Of Intelligence and Social Skill!'
                ],
                [
                  'type' => 'paragraph',
                  'content' => 'Over the next <strong>60-70 minutes</strong> you will complete a
                  range of different tasks. Our goal is to understand how well
                  you solve problems, your ability to perceive emotions in
                  others, and your short-term memory. This is a research study
                  and your answers are important.'
                ],
                [
                  'type' => 'paragraph',
                  'content' => 'Most tasks begin with a practice. We’ve
                  included these practice questions to explain how our
                  tasks work. The practice questions do NOT count towards
                  your score. But, it is important to try to get these
                  simple questions correct, as we use them to make sure
                  that you’ve read and understood the instructions.'
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
