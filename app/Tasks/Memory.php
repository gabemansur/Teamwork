<?php
namespace Teamwork\Tasks;

class Memory {

  private $memoryTests = [

    'faces_1' => [
        'test_name' => 'faces_1',
        'task_type' => 'images',
        'directory' => '/img/memory-task/faces/',
        'blocks' => [
          ['type' => 'practice_review',
          'text' => 'Look at these 6 faces for a few seconds. We\'ll call these
                    "target faces".',
          'targets' => ['p0_targets_1.png'],
          'review_time' => null],
        [ 'type' => 'practice_test',
          'selection_type' => 'select_one',
          'prompt' => 'Which of the follwing faces is a "target" face?',
          'img' => 'p0_test_1.png',
          'correct' => [1]],
        [ 'type' => 'practice_test',
          'selection_type' => 'select_one',
          'prompt' => 'Which of the follwing faces is a "target" face?',
          'img' => 'p0_test_2.png',
          'correct' => [3]],
        ['type' => 'review',
          'text' => 'Next you will review 6 target faces for
                      20 seconds. You can see them front-on, or
                      in profile. Focus on each target face and
                      try to remember it.',
          'targets' => ['1_targets_1.png', '1_targets_2.png', '1_targets_3.jpg'],
          'review_time' => 20,],
          [ 'type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_1.jpg',
            'correct' => [3]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_2.jpg',
            'correct' => [3]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_3.jpg',
            'correct' => [1]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_4.jpg',
            'correct' => [1]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_5.jpg',
            'correct' => [3]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_6.jpg',
            'correct' => [2]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_7.jpg',
            'correct' => [3]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_8.jpg',
            'correct' => [3]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_9.jpg',
            'correct' => [1]],

          ['type' => 'review',
            'text' => 'Here’s a reminder of the faces.
            You have 10 seconds to refresh your memory.',
            'targets' => ['1_targets_1.png', '1_targets_2.png', '1_targets_3.jpg'],
            'review_time' => 10,
          ],

          ['type' => 'text',
            'text' => 'For the last six questions, some
            of the images are deliberately blurred to make
            things more challenging.',
          ],

          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_10.jpg',
            'correct' => [1]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_11.jpg',
            'correct' => [3]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_12.jpg',
            'correct' => [3]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_13.jpg',
            'correct' => [2]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_14.jpg',
            'correct' => [1]],
          ['type' => 'test',
            'selection_type' => 'select_one',
            'prompt' => 'Which of the follwing faces is a "target" face?',
            'img' => '1_test_15.jpg',
            'correct' => [2]],

          ], // End blocks

    ], // End faces_1

    'words_1' => [
          'test_name' => 'words_1',
          'task_type' => 'words',
          'blocks' => [
              ['type' => 'text',
               'text' => 'Next, we’ll test word memory. In this task,
                        you’ll be presented with a set of ‘target words’.  Word
                        will appear for a maximum of 2 seconds. We’ll start
                        with a practice. In the practice round, you only have
                        to remember 3 target words.',],
              ['type' => 'review',
              'text' => '',
              'targets' => ['blue', 'yellow', 'red'],
              'review_time_each' => 2,
              'review_time' => null],
              [ 'type' => 'practice_test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words?',
                'choices' => ['red', 'rust', 'blue'],
                'correct' => [1, 3]],
              [ 'type' => 'practice_test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words?',
                'choices' => ['green', 'baseball', 'egg'],
                'correct' => []],
              ['type' => 'text',
              'text' => 'You will now be presented with 12 target
                          words. Try to remember all of them. Each word will
                          show up separately. In total, you have 20 seconds
                          to remember the words.
                          You’re not allowed to write anything down.',],
              ['type' => 'review',
              'text' => '',
              'targets' => ['horse', 'cave', 'lion', 'opal', 'tiger',
                          'pearl', 'hut', 'emerald', 'saphire',
                          'tent', 'hotel', 'cow'],
              'review_time_each' => 1.66,
              'review_time' => null],
              ['type' => 'test',
               'selection_type' => 'select_all',
               'prompt' => 'Which of the following are target words',
               'choices' => ['house', 'tiger', 'hut'],
               'correct' => [2, 3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['hotel', 'coffee', 'mountain'],
                'correct' => [1]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['cow', 'dog', 'emerald'],
                'correct' => [1, 3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['ruby', 'pig', 'balloon'],
                'correct' => []],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['apartment', 'tiger', 'diamond'],
                'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['pearl', 'scarf', 'hotel'],
                'correct' => [3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['boat', 'penny', 'cat'],
                'correct' => []],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['lion', 'saphire', 'cave'],
                'correct' => [1, 2]],


          ] // End blocks

    ], // End words_1

    'story_1' => [
        'test_name' => 'story_1',
        'task_type' => 'story',
        'directory' => '/img/memory-task/faces/',
        'blocks' => [
            ['type' => 'text',
             'text' => 'The last memory task asks you to remember
                             a very short story. Once again, we’ll start with a
                             practice. In the practice round, you only have to
                             remember one sentence.'],
            ['type' => 'review',
            'text' => 'Practice story:',
            'targets' => ['Peter was hungry, so he went to the store on the
                            corner of his street and bought a hamburger.'],
            'review_time' => null],
            [ 'type' => 'practice_test',
              'selection_type' => 'select_one',
              'prompt' => 'Why did Peter go to the store?',
              'choices' => ['Because he was hungry',
                            'To get coffee',
                            'To buy food for his dog'],
              'correct' => [1]],
            [ 'type' => 'practice_test',
              'selection_type' => 'select_one',
              'prompt' => 'What did Peter eat?',
              'choices' => ['Hamburger',
                            'Sandwich',
                            'Fries'],
              'correct' => [1]],
            ['type' => 'text',
             'text' => 'Now for the actual task. You will be
                         presented with a slightly longer story. You
                         will have 30 seconds to read it. Try to take
                         in as much information as possible. After the 30
                         seconds are up, we’ll ask you some questions
                         about the story. Your answers are important.'],
            ['type' => 'review',
            'text' => '',
            'targets' => ['Anna Thompson of South Boston, employed
                            as a cook in a school cafeteria, reported at the
                            police station that she had been held up on State
                            Street the night before and robbed of $56. She had
                            four small children, the rent was due, and they had
                            not eaten for two days. The police, touched by the
                            woman’s story, collected money for her.',],
            'review_time' => 30],

            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'What was the name of the main character?',
              'choices' => ['Anna Thompson',
                            'Anna Tompkins',
                            'Hanna Tompkins'],
              'correct' => [1]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'How many children did she have?',
              'choices' => ['4',
                            '5',
                            '6'],
              'correct' => [1]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'On what street was she robbed?',
              'choices' => ['South Street',
                            'State Street',
                            'Sixth Street'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What was her job?',
                'choices' => ['Cook',
                              'She didn\'t have a job',
                              'Janitor'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'When did she report being robbed?',
                'choices' => ['One night after the robbery',
                              'Two nights after the robbery',
                              'A week after the robbery'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How much money was stolen?',
                'choices' => ['$65',
                              '$56',
                              '$66'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How long had the family not eaten for?',
                'choices' => ['2 days',
                              '1 day',
                              'They missed 2 meals'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What did the police do?',
                'choices' => ['Arrest the thief',
                              'Collect money for the woman',
                              'Give the woman food'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'Where does the main character live?',
                'choices' => ['South Boston',
                              'Somerville',
                              'North Boston'],
                'correct' => [1]]

        ] // End blocks
    ], // End story_1

  ]; // End memoryTests

  private $tests = [
    'faces' => [
      'task_type' => 'images',
      'directory' => '/img/memory-task/faces/',

      'practices' => [
                          ['intro' => [
                                        'text' => 'Look at these 6 faces for a few seconds. We\'ll call these "target faces". Press "next" when you are ready to continue.',
                                        'img' => 'p0_targets_1.png',
                                        'review_time' => null,
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
                         'review_time' => 20,
                      ],
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
                          'text' => 'You will now be presented with 12 target
                          words. Try to remember all of them. Each word will
                          show up separately. In total, you have 20 seconds
                          to remember the words.
                          You’re not allowed to write anything down.',
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
        'practices' => [
                        'intro' => [
                          'text' => 'The last memory task asks you to remember
                                          a very short story. Once again, we’ll start with a
                                          practice. In the practice round, you only have to
                                          remember one sentence.',
                          'story' => 'Peter was hungry, so he went to the store on the corner of his street and bought a hamburger.',
                        ],
                        ['tests' => ['type' => 'select_one',
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
                        ],
        'tests' => [
                            ['intro' => [
                                'text' => 'Now for the actual task. You will be
                                presented with a slightly longer story. You
                                will have 30 seconds to read it. Try to take
                                in as much information as possible. After the 30
                                 seconds are up, we’ll ask you some questions
                                 about the story. Your answers are important.',
                                 'review_time' => 30,
                                 'story' => 'Anna Thompson of South Boston, employed
                                 as a cook in a school cafeteria, reported at the
                                 police station that she had been held up on State
                                 Street the night before and robbed of $56. She had
                                 four small children, the rent was due, and they had
                                 not eaten for two days. The police, touched by the
                                 woman’s story, collected money for her.',
                              ],
                            ],

                            ['type' => 'select_one',
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

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['true', 'false'], 'test' => ['allows_multiples' => ['faces_1', 'words_1', 'story_1']]];

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
    return $this->memoryTests[$test];
  }


  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
