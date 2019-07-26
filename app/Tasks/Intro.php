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

  'hdsl_individual' => [[
                'type' => 'header',
                'content' => 'Welcome to the Harvard Study Of Intelligence and Social Skill'
              ],
              [
                'type' => 'paragraph',
                'content' => 'Over the next <strong>45 minutes</strong> you will complete a
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
                'content' => 'There are 5 tasks to complete. Some tasks take
                slightly longer than others, but not more than 15 minutes.
                Feel free to take a break between tasks.'
              ]
    ],

    'hdsl_individual_pilot' => [[
                  'type' => 'header',
                  'content' => 'Welcome to the online component of the Superteams study!'
                ],
                [
                  'type' => 'paragraph',
                  'content' => 'Over the next <strong>50 minutes</strong> you will complete a
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
                  'content' => 'There are 5 tasks to complete. Some tasks take
                  slightly longer than others, but not more than 15 minutes.
                  Feel free to take a break between tasks.'
                ]
      ],

    'hdsl_individual_important_info' => [[
                  'type' => 'header',
                  'content' => 'Important information about this study'
                ],
                [
                  'type' => 'paragraph',
                  'content' => 'The study has three parts. First, an online test
                  which you can complete at any time and location. Then there are
                  <strong>two separate visits</strong> to the Harvard Decision Science Lab. If you
                  successfully complete the online tasks, you will be eligible to
                  participate in the Lab sessions. Payments will be made in cash,
                  at the Lab:
                  <ul>
                    <li>$25 at the end of your first visit to the lab</li>
                    <li>$35 at the end of your second visit to the lab</li>
                  </ul>
                  We will also pay a bonus based on performance, at the end of
                  the second lab visit. If you complete the online test, but never
                  come to the Lab, you will not receive payment.
                  '
                ],
                [
                  'type' => 'paragraph',
                  'content' => 'Please click Continue if you wish to proceed'
                ]
      ],

    'group_1' => [[
                   'type' => 'header',
                   'content' => 'Welcome to your first group'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => 'You will be working together for around half an hour,
                   trying to solve 3 tasks.<br>You’ve seen similar
                   (or identical) tasks as individuals:'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => '<div class="row">
                   <div class="col-md-4 offset-md-4">
                   <ol><li>Optimization</li><li>Memory</li>
                   <li>Shapes</li></ol>
                   </div></div>'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => 'The main difference is that now you will be
                   answering as a group.'
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
                   'content' => 'You will be working together for around half an hour,
                   trying to solve 3 tasks. The tasks will be similar
                   to those you worked on in your previous groups:'
                 ],
                 [
                   'type' => 'paragraph',
                   'content' => '<div class="row">
                   <div class="col-md-4 offset-md-4">
                   <ol><li>Optimization</li><li>Memory</li>
                   <li>Shapes</li></ol>
                   </div></div>'
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

      ],

      'group_5' => [[
                     'type' => 'header',
                     'content' => 'Welcome to your new group'
                   ],
                   [
                     'type' => 'paragraph',
                     'content' => 'You will be working together for about 25
                     minutes, trying to solve a task you haven\'t seen before.'
                   ],
                   [
                     'type' => 'paragraph',
                     'content' => 'Take a moment to introduce yourselves, then click "Next".'
                   ]
        ]
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['false'], 'type' => ['mturk', 'hdsl_individual', 'group_1', 'group_2', 'group_5']];

  public function getIntro($type) {
    return $this->intro[$type];
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
