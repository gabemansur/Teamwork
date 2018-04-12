<?php
namespace Teamwork\Tasks;

class Memory {

  private $tests = [
    'faces' => [
      'task_type' => 'images',
      'practices' => ['intro' => 'Look at these 6 faces for a few seconds. We\'ll
                        call these \"target faces\". Press "next" when you are
                        ready to continue.',
                      'number_tests' => 2,
                      'review_time' => -1,
                      'reminder_time' => 0,
                      'scoring' => [1 => 1, 2 => 3]
                    ],
      'target_groups' => ['number_tests' => 15,
                          'review_time' => 20,
                          'reminder_after' => 9,
                          'reminder_time' => 10,
                          'scoring' => [1 => 3, 2 => 3, 3 => 1, 4 => 1, 5 => 3,
                            6 => 2, 7 => 3, 8 => 3, 9 => 1, 10 => 1, 11 => 3, 12 => 3,
                            13 => 2, 14 => 1, 15 => 2]],

    ],

    'words' => [
      'task_type' => 'words',
      'practices' => ['intro' => 'Next, we’ll test word memory. In this task,
                        you’ll be presented with a set of ‘target words’.  Word
                        will appear for a maximum of 2 seconds. We’ll start
                        with a practice. In the practice round, you only have
                        to remember 3 target words.',
                      'number_tests' => 2,
                      'review_time' => 2,
                      'words' => ['blue', 'yellow', 'red'],
                      'tests' => [
                        ['type' => 'select_all',
                         'prompt' => 'Which of the following are target words',
                         'choices' => ['red', 'rust', 'blue'],
                         'correct' => [1, 3]],
                        ['type' => 'select_all',
                        'prompt' => 'Which of the following are target words',
                        'choices' => ['green', 'baseball', 'egg'],
                        'correct' => []],
                      ]
                    ],
      'target_groups' => ['number_tests' => 8,
                          'review_time' => 1.66,
                          'words' => ['horse', 'cave', 'lion', 'opal', 'tiger',
                                      'pearl', 'hut', 'emerald', 'saphire',
                                      'tent', 'hotel', 'cow'],
                          'tests' => [
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
                          ]
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
