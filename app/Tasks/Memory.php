<?php
namespace Teamwork\Tasks;

class Memory {

  private $tests = [
    'faces' => [
      'task_type' => 'images',
      'directory' => '/img/memory-task/faces/',

      'practices' => [

                      ['intro' => [
                          'text' => 'Look at these 6 faces for a few seconds. We\'ll call these "target faces". Press "next" when you are ready to continue.',
                          'img' => 'p0_targets_1.png',
                          'review_time' => -1,
                        ],
                      ],
                      ['tests' =>
                          ['type' => 'select_one',
                            'prompt' => 'Which of the follwing faces is a "target" face?',
                            'img' => 'p0_test_1.png',
                            'correct' => [1]],
                          ['type' => 'select_one',
                            'prompt' => 'Which of the follwing faces is a "target" face?',
                            'img' => 'p0_test_2.png',
                            'correct' => [3]]
                          ],
                        ],

      'tests' => [
                    ['intro' => [
                        'text' => 'Next you will review 6 target faces for
                                        20 seconds. You can see them front-on, or
                                        in profile. Focus on each target face and
                                        try to remember it.',
                        'img' => ['1_targets_1.png', '1_targets_2.png', '1_targets_3.png'],
                        'review_time' => 'review_time' => 20,
                      ],

                      ['tests' =>

                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_1.png',
                          'correct' => [3]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_2.png',
                          'correct' => [3]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_3.png',
                          'correct' => [1]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_4.png',
                          'correct' => [1]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_5.png',
                          'correct' => [3]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_6.png',
                          'correct' => [2]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_7.png',
                          'correct' => [3]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_8.png',
                          'correct' => [3]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_9.png',
                          'correct' => [1]],

                        ],

                        ['type' => 'reminder',
                          'text' => 'Here’s a reminder of the faces.
                          You have 10 seconds to refresh your memory.',
                          'review_time' => 10,
                        ],

                        ['type' => 'msg',
                          'text' => 'For the last six questions, some
                          of the images are deliberately blurred to make
                          things more challenging.',
                        ],

                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_10.png',
                          'correct' => [1]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_11.png',
                          'correct' => [3]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_12.png',
                          'correct' => [3]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_13.png',
                          'correct' => [2]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_14.png',
                          'correct' => [1]],
                        ['type' => 'select_one',
                          'prompt' => 'Which of the follwing faces is a "target" face?',
                          'img' => '1_test_15.png',
                          'correct' => [2]],
                      ],

    ],
  ],
    'words' => [
      'task_type' => 'words',
      'practices' => [
                       ['intro' => [
                          'text' => 'Next, we’ll test word memory. In this task,
                                    you’ll be presented with a set of ‘target words’.  Word
                                    will appear for a maximum of 2 seconds. We’ll start
                                    with a practice. In the practice round, you only have
                                    to remember 3 target words.',
                          'review_time' => 2,
                          'words' => ['blue', 'yellow', 'red'],
                          ],
                        ],
                      'tests' => [
                        ['type' => 'select_all',
                         'prompt' => 'Which of the following are target words',
                         'choices' => ['red', 'rust', 'blue'],
                         'correct' => [1, 3]],
                        ['type' => 'select_all',
                        'prompt' => 'Which of the following are target words',
                        'choices' => ['green', 'baseball', 'egg'],
                        'correct' => []],
                      ],
                    ],
      'tests' => [
                      ['intro' => [
                          'text' => 'Next you will review 6 target faces for
                                          20 seconds. You can see them front-on, or
                                          in profile. Focus on each target face and
                                          try to remember it.',
                          'img' => ['1_targets_1.png', '1_targets_2.png', '1_targets_3.png'],
                          'review_time' => 1.66,
                          'words' => ['horse', 'cave', 'lion', 'opal', 'tiger',
                                      'pearl', 'hut', 'emerald', 'saphire',
                                      'tent', 'hotel', 'cow'],
                          ],
                      ],

                      ['type' => 'select_all',
                       'prompt' => 'Which of the following are target words',
                       'choices' => ['house', 'tiger', 'hut'],
                       'correct' => [2, 3]],
                      ['type' => 'select_all',
                      'prompt' => 'Which of the following are target words',
                      'choices' => ['hotel', 'coffee', 'mountain'],
                      'correct' => [1]],
                      ['type' => 'select_all',
                      'prompt' => 'Which of the following are target words',
                      'choices' => ['cow', 'dog', 'emerald'],
                      'correct' => [1, 3]],
                      ['type' => 'select_all',
                      'prompt' => 'Which of the following are target words',
                      'choices' => ['ruby', 'pig', 'balloon'],
                      'correct' => []],
                      ['type' => 'select_all',
                      'prompt' => 'Which of the following are target words',
                      'choices' => ['apartment', 'tiger', 'diamond'],
                      'correct' => [2]],
                      ['type' => 'select_all',
                      'prompt' => 'Which of the following are target words',
                      'choices' => ['pearl', 'scarf', 'hotel'],
                      'correct' => [3]],
                      ['type' => 'select_all',
                      'prompt' => 'Which of the following are target words',
                      'choices' => ['boat', 'penny', 'cat'],
                      'correct' => []],
                      ['type' => 'select_all',
                      'prompt' => 'Which of the following are target words',
                      'choices' => ['lion', 'saphire', 'cave'],
                      'correct' => [1, 2]],
      ],
    ],
    'story' => [
        'task_type' => 'story',
        'practices' => ['intro' => 'The last memory task asks you to remember
                          a very short story. Once again, we’ll start with a
                          practice. In the practice round, you only have to
                          remember one sentence.',

                        'story' => 'Peter was hungry, so he went to the store on the corner of his street and bought a hamburger.',
                        'tests' => ['type' => 'select_one',
                                    'prompt' => 'Why did Peter go to the store?',
                                    'choices' => ['Because he was hungry',
                                                  'To get coffee',
                                                  'To buy food for his dog'],
                                    'correct' => [1]],
                                    ['type' => 'select_one',
                                      'prompt' => 'Why did Peter go to the store?',
                                      'choices' => ['Because he was hungry',
                                                    'To get coffee',
                                                    'To buy food for his dog'],
                                      'correct' => [1]],
                                  ],
        'target_groups' => ['review_time' => 30,
                            'story' => 'Anna Thompson of South Boston, employed
                            as a cook in a school cafeteria, reported at the
                            police station that she had been held up on State
                            Street the night before and robbed of $56. She had
                            four small children, the rent was due, and they had
                            not eaten for two days. The police, touched by the
                            woman’s story, collected money for her.',
                            'tests' => ['type' => 'select_one',
                                        'prompt' => 'What was the name of the main character?',
                                        'choices' => ['Anna Thompson',
                                                      'Anna Tompkins',
                                                      'Hanna Tompkins'],
                                        'correct' => [1]],
                                        ['type' => 'select_one',
                                          'prompt' => 'How many children did she have?',
                                          'choices' => ['4',
                                                        '5',
                                                        '6'],
                                          'correct' => [1]],
                                        ['type' => 'select_one',
                                          'prompt' => 'On what street was she robbed?',
                                          'choices' => ['South Street',
                                                        'State Street',
                                                        'Sixth Street'],
                                            'correct' => [2]],
                                          ['type' => 'select_one',
                                            'prompt' => 'What was her job?',
                                            'choices' => ['Cook',
                                                          'She didn\'t have a job',
                                                          'Janitor'],
                                            'correct' => [1]],
                                          ['type' => 'select_one',
                                            'prompt' => 'When did she report being robbed?',
                                            'choices' => ['One night after the robbery',
                                                          'Two nights after the robbery',
                                                          'A week after the robbery'],
                                            'correct' => [1]],
                                          ['type' => 'select_one',
                                            'prompt' => 'How much money was stolen?',
                                            'choices' => ['$65',
                                                          '$56',
                                                          '$66'],
                                            'correct' => [2]],
                                          ['type' => 'select_one',
                                            'prompt' => 'How long had the family not eaten for?',
                                            'choices' => ['2 days',
                                                          '1 day',
                                                          'They missed 2 meals'],
                                            'correct' => [1]],
                                          ['type' => 'select_one',
                                            'prompt' => 'What did the police do?',
                                            'choices' => ['Arrest the thief',
                                                          'Collect money for the woman',
                                                          'Give the woman food'],
                                            'correct' => [2]],
                                          ['type' => 'select_one',
                                            'prompt' => 'Where did the story take place?',
                                            'choices' => ['South Boston',
                                                          'Somerville',
                                                          'North Boston'],
                                            'correct' => [1]]
                                        ]

    ]
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['true', 'false'], 'test' => ['allows_multiples' => ['faces', 'words', 'story']]];

  public function getTests() {
    return $this->prompts;
  }

  public function setTests($tests) {
    $this->tests = $tests;
  }

  public function getRandomTest() {
    return $this->tests[array_rand($this->tests)];
  }

  public function getTest($test) {
    dump($this->tests);
    return $this->tests[$test];
  }


  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
