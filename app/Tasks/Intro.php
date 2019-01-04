<?php
namespace Teamwork\Tasks;

class Intro {

  private $intro = [
    'mturk' => [[
                  'type' => 'header',
                  'content' => 'Welcome to the Harvard Study Of Intelligence and Social Skill'
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
                ],
                [
                  'type' => 'paragraph',
                  'content' => 'There are 7 tasks to complete. Some tasks take
                  slightly longer than others, but not more than 15 minutes.
                  Feel free to take a break between tasks.'
                ]
      ],

    'group_1' => [[
                   'type' => 'header',
                   'content' => 'Welcome to your first group'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => 'You will be working together for about 45
                   minutes, trying to solve 4 tasks.<br>You’ve seen similar
                   (or identical) tasks as individuals:'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => '<div class="row">
                   <div class="col-md-4 offset-md-4">
                   <ol><li>Optimization</li><li>Memory</li>
                   <li>Cryptography</li><li>Shapes</li></ol>
                   </div></div>'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => 'The main difference is that now you will be
                   answering as a group.<br>You will be rewarded based on how well
                   your group performs.'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => 'Take a moment to introduce yourselves!'
                 ]

      ],
    'group_2' => [[
                   'type' => 'header',
                   'content' => 'Welcome to your new group'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => 'You will be working together for about 45
                   minutes, trying to solve 4 tasks. The tasks will be similar
                   to those you worked on in your previous groups:'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => '<div class="row">
                   <div class="col-md-4 offset-md-4">
                   <ol><li>Optimization</li><li>Memory</li>
                   <li>Cryptography</li><li>Shapes</li></ol>
                   </div></div>'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => 'Once again, you will be rewarded based on
                   how well the group performs.'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => 'Take a moment to introduce yourselves!'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => 'The instructions will continue when all
                   three group members have hit "Next"'
                 ]

      ]
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['false'], 'type' => ['mturk', 'group_1', 'group_2']];

  public function getIntro($type) {
    return $this->intro[$type];
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
