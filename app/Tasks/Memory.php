<?php
namespace Teamwork\Tasks;

class Memory {

  private $memoryTests = [

    'images_instructions' => [
      'test_name' => 'images_instructions',
      'task_type' => 'images',
      'type' => 'intro',
      'directory' => '/img/memory-task/faces/',
      'blocks' => [
          ['type' => 'text',
            'header' => 'Memory Task',
            'text' => 'Next are some tests of memory. We’ll start with a practice.
            Please do not write anything down during these tasks.'],
          ['type' => 'practice_review',
          'text' => 'We\'ll start with a practice. Look at these 6 faces for a few seconds. We\'ll call these
                    "target faces".',
          'targets' => ['p0_targets_1.png'],
          'review_time' => null],
        [ 'type' => 'practice_test',
          'selection_type' => 'select_one',
          'prompt' => 'Which of the following faces is a "target" face?',
          'img' => 'p0_test_1.png',
          'correct' => [1]],
        [ 'type' => 'practice_test',
          'selection_type' => 'select_one',
          'prompt' => 'Which of the following faces is a "target" face?',
          'img' => 'p0_test_2.png',
          'correct' => [3]],
        ['type' => 'text',
          'text' => 'When you click "Continue" a screen will appear with 6 target
                     images. The images may not be faces this time, they may be
                     some other type of object.
                     You can view the images front-on or in profile.
                     Click the "change perspective" button to see them from a different angle.
                     You will have 20 seconds to memorize
                     these target images.'],
      ]// end blocks
    ], // end images_instructions

    'words_instructions' => [
      'test_name' => 'words_instructions',
      'task_type' => 'images',
      'type' => 'intro',
      'directory' => '/img/memory-task/faces/',
      'blocks' => [
        ['type' => 'text',
         'header' => 'Memory Task',
         'text' => 'Next, we’ll test word memory. In this task,
                  you’ll be presented with a set of "target words".  Each word
                  will show up separately for 2 seconds. We’ll start
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
          'correct' => [],
          'popup_text' => 'Sometimes, none of the words will be a target word.<br>In that case, just click "next"!',
          'popup_display_time' => 5],
        ['type' => 'text',
        'text' => 'Now for the actual task. You will be presented with 12 target
                    words. Try to remember all of them. Each word will
                    show up separately for 2 seconds.
                    You’re not allowed to write anything down. The words will
                    begin to appear when you click "Continue".',],
      ]// end blocks
    ], // end words_instructions

    'story_instructions' => [
      'test_name' => 'story_instructions',
      'task_type' => 'images',
      'type' => 'intro',
      'directory' => '/img/memory-task/',
      'blocks' => [
        ['type' => 'text',
         'header' => 'Memory Task',
         'text' => 'This memory task asks you to remember
                         two very short stories. Once again, we’ll start with a
                         practice. In the practice round each "story" will only have one sentence.'],
        ['type' => 'review',
        'text' => 'Practice stories:',
        'targets' => ['Peter was hungry, so he went to the store on the
                        corner of his street and bought a hamburger.',
                      'Yesterday, a local woman found a 10-foot crocodile
                      in her kitchen, an event the fire department
                      described as "unusual".'],
        'review_time' => 15],
        [ 'type' => 'practice_test',
          'selection_type' => 'select_one',
          'prompt' => 'Why did Peter go to the store?',
          'choices' => ['Because he was hungry',
                        'To get coffee',
                        'To buy food for his dog'],
          'correct' => [1]],
        [ 'type' => 'practice_test',
          'selection_type' => 'select_one',
          'prompt' => 'Where was a crocodile found yesterday?',
          'choices' => ['In a kitchen in Australia',
                        'On a roof in Manhattan',
                        'On the moon'],
          'correct' => [1]],
        ['type' => 'text',
         'text' => 'Now for the actual task. You will be presented with two longer stories.
                    You will have 30 seconds to read them. Try to take in as much information as possible.
                    There is a timer in the top right of the screen.
                    After the 30 seconds are up, we’ll ask you some questions about the stories.
                    Your 30 seconds will start when you hit continue.'],
      ]// end blocks
    ], // end words_instructions

    'faces_1' => [
        'test_name' => 'faces_1',
        'task_type' => 'images',
        'type' => 'task',
        'directory' => '/img/memory-task/faces/',
        'blocks' => [
            ['type' => 'review',
              'text' => '',
              'targets' => ['1_targets_1.png', '1_targets_2.png', '1_targets_3.jpg'],
              'review_time' => 20,],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_1.jpg',
                'correct' => [3]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_2.jpg',
                'correct' => [3]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_3.jpg',
                'correct' => [1]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_4.jpg',
                'correct' => [1]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_5.jpg',
                'correct' => [3]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_6.jpg',
                'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_7.jpg',
                'correct' => [3]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_8.jpg',
                'correct' => [3]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
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
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_10.jpg',
                'correct' => [1]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_11.jpg',
                'correct' => [3]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following faces is a "target" face?',
                'img' => '1_test_12.jpg',
                'correct' => [3]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_13.jpg',
                'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_14.jpg',
                'correct' => [1]],
              ['type' => 'test',
                'selection_type' => 'select_one',
                'show_numbers' => 'true',
                'prompt' => 'Which of the following images is a "target" face?',
                'img' => '1_test_15.jpg',
                'correct' => [2]],

          ], // End blocks

    ], // End faces_1

    'faces_2' => [
        'test_name' => 'faces_2',
        'task_type' => 'images',
        'type' => 'task',
        'directory' => '/img/memory-task/faces/',
        'blocks' => [

          ['type' => 'review',
            'text' => '',
            'targets' => ['2_targets_1.jpg', '2_targets_2.jpg', '2_targets_3.jpg'],
            'review_time' => 20,],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" face?',
              'img' => '2_test_1.jpg',
              'correct' => [3]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" face?',
              'img' => '2_test_2.jpg',
              'correct' => [1]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" face?',
              'img' => '2_test_3.jpg',
              'correct' => [2]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" face?',
              'img' => '2_test_4.jpg',
              'correct' => [3]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" face?',
              'img' => '2_test_5.jpg',
              'correct' => [1]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" face?',
              'img' => '2_test_6.jpg',
              'correct' => [3]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" face?',
              'img' => '2_test_7.jpg',
              'correct' => [2]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" face?',
              'img' => '2_test_8.jpg',
              'correct' => [2]],
            ], // End blocks
    ], // End faces_2

    'cars_1' => [
        'test_name' => 'cars_1',
        'task_type' => 'images',
        'type' => 'task',
        'directory' => '/img/memory-task/cars/',
        'blocks' => [
          ['type' => 'review',
            'text' => '',
            'targets' => ['1_targets_1.png', '1_targets_2.png', '1_targets_3.png'],
            'review_time' => 20,],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'false',
              'prompt' => 'Which of the following images is a "target" car?',
              'img' => '1_test_1.jpg',
              'correct' => [3]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'false',
              'prompt' => 'Which of the following images is a "target" car?',
              'img' => '1_test_2.jpg',
              'correct' => [1]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'false',
              'prompt' => 'Which of the following images is a "target" car?',
              'img' => '1_test_3.jpg',
              'correct' => [1]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'false',
              'prompt' => 'Which of the following images is a "target" car?',
              'img' => '1_test_4.jpg',
              'correct' => [2]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'false',
              'prompt' => 'Which of the following images is a "target" car?',
              'img' => '1_test_5.jpg',
              'correct' => [3]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'false',
              'prompt' => 'Which of the following images is a "target" car?',
              'img' => '1_test_6.jpg',
              'correct' => [2]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'false',
              'prompt' => 'Which of the following images is a "target" car?',
              'img' => '1_test_7.jpg',
              'correct' => [2]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'false',
              'prompt' => 'Which of the following images is a "target" car?',
              'img' => '1_test_8.jpg',
              'correct' => [3]],
            ], // End blocks
    ], // End cars_1

    'bikes_1' => [
        'test_name' => 'bikes_1',
        'task_type' => 'images',
        'type' => 'task',
        'directory' => '/img/memory-task/bikes/',
        'blocks' => [
          ['type' => 'review',
            'text' => '',
            'targets' => ['1_targets_1.png', '1_targets_2.png', '1_targets_3.png'],
            'review_time' => 20,],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" bicycle?',
              'img' => '1_test_1.png',
              'correct' => [1]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" bicycle?',
              'img' => '1_test_2.png',
              'correct' => [2]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" bicycle?',
              'img' => '1_test_3.png',
              'correct' => [1]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" bicycle?',
              'img' => '1_test_4.png',
              'correct' => [2]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" bicycle?',
              'img' => '1_test_5.png',
              'correct' => [3]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" bicycle?',
              'img' => '1_test_6.png',
              'correct' => [3]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" bicycle?',
              'img' => '1_test_7.png',
              'correct' => [2]],
            ['type' => 'test',
              'selection_type' => 'select_one',
              'show_numbers' => 'true',
              'prompt' => 'Which of the following images is a "target" bicycle?',
              'img' => '1_test_8.png',
              'correct' => [3]],
            ], // End blocks
    ], // End bikes_1

    'words_1' => [
          'test_name' => 'words_1',
          'task_type' => 'words',
          'type' => 'task',
          'blocks' => [
              ['type' => 'review',
              'text' => '',
              'targets' => ['horse', 'cave', 'lion', 'opal', 'tiger',
                          'pearl', 'hut', 'emerald', 'sapphire',
                          'tent', 'hotel', 'cow'],
              'review_time_each' => 2,
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
                'correct' => [1, 3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['boat', 'penny', 'cat'],
                'correct' => []],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['lion', 'sapphire', 'cave'],
                'correct' => [1, 2, 3]],


          ] // End blocks

    ], // End words_1

    'words_2' => [
          'test_name' => 'words_2',
          'task_type' => 'words',
          'type' => 'task',
          'blocks' => [
              ['type' => 'review',
              'text' => '',
              'targets' => ['pistol', 'fork', 'pot', 'sword', 'vodka',
                          'rum', 'bomb', 'pan', 'wine',
                          'spatula', 'bourbon', 'rifle'],
              'review_time_each' => 2,
              'review_time' => null],
              ['type' => 'test',
               'selection_type' => 'select_all',
               'prompt' => 'Which of the following are target words',
               'choices' => ['fork', 'pan', 'knife'],
               'correct' => [1, 2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['spatula', 'beer', 'bomb'],
                'correct' => [1, 3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['whiskey', 'lemon', 'gun'],
                'correct' => []],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['gun', 'pistol', 'trout'],
                'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['wine', 'fork', 'sword'],
                'correct' => [1, 2, 3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['rum', 'pencil', 'pot'],
                'correct' => [1, 3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['can', 'vodka', 'spoon'],
                'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['rifle', 'gold', 'strainer'],
                'correct' => [1]],


          ] // End blocks

    ], // End words_2

    'words_3' => [
          'test_name' => 'words_3',
          'task_type' => 'words',
          'type' => 'task',
          'blocks' => [
              ['type' => 'review',
              'text' => '',
              'targets' => ['garlic', 'wood', 'sugar', 'coal', 'clarinet',
                            'trumpet', 'cinnamon', 'flute', 'kerosine',
                            'vanilla', 'gasoline', 'violin'],
              'review_time_each' => 2,
              'review_time' => null],
              ['type' => 'test',
               'selection_type' => 'select_all',
               'prompt' => 'Which of the following are target words',
               'choices' => ['oil', 'kerosine', 'priest'],
               'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['salt', 'basement', 'piano'],
                'correct' => []],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['wood', 'harmonica', 'trumpet'],
                'correct' => [1, 3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['flute', 'clarinet', 'piano'],
                'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['garlic', 'violin', 'vanilla'],
                'correct' => [1, 2, 3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['chair', 'pepper', 'horn'],
                'correct' => []],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['sand', 'sugar', 'drum'],
                'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['coal', 'electricity', 'lemon'],
                'correct' => [1]],


          ] // End blocks

    ], // End words_3

    'words_4' => [
          'test_name' => 'words_4',
          'task_type' => 'words',
          'type' => 'task',
          'blocks' => [
              ['type' => 'review',
              'text' => '',
              'targets' => ['bluebird', 'chisel', 'eagle', 'screwdriver', 'crow',
                            'wrench', 'pants', 'nails', 'shoes',
                            'canary', 'skirt', 'blouse'],
              'review_time_each' => 2,
              'review_time' => null],
              ['type' => 'test',
               'selection_type' => 'select_all',
               'prompt' => 'Which of the following are target words',
               'choices' => ['child', 'bluebird', 'chapel'],
               'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['canary', 'socks', 'robin'],
                'correct' => [1]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['hammer', 'skirt', 'apple'],
                'correct' => [2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['shirt', 'saw', 'wren'],
                'correct' => []],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['chisel', 'screwdriver', 'sparrow'],
                'correct' => [1, 2]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['silver', 'nails', 'eagle'],
                'correct' => [2, 3]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['crow', 'rock', 'rook'],
                'correct' => [1]],
              ['type' => 'test',
                'selection_type' => 'select_all',
                'prompt' => 'Which of the following are target words',
                'choices' => ['blouse', 'pants', 'wrench'],
                'correct' => [1, 2, 3]],


          ] // End blocks

    ], // End words_4

    'story_1' => [
        'test_name' => 'story_1',
        'task_type' => 'story',
        'type' => 'task',
        'directory' => '/img/memory-task/faces/',
        'blocks' => [
            ['type' => 'text',
             'text' => 'The last memory task asks you to remember
                             two very short stories. Once again, we’ll start with a
                             practice. In the practice round each "story" will only have one sentence.'],
            ['type' => 'review',
            'text' => 'Practice stories:',
            'targets' => ['Peter was hungry, so he went to the store on the
                            corner of his street and bought a hamburger.',
                          'Yesterday, a local woman found a 10-foot crocodile
                          in her kitchen, an event the fire department
                          described as "unusual".'],
            'review_time' => 15],
            [ 'type' => 'practice_test',
              'selection_type' => 'select_one',
              'prompt' => 'Why did Peter go to the store?',
              'choices' => ['Because he was hungry',
                            'To get coffee',
                            'To buy food for his dog'],
              'correct' => [1]],
            [ 'type' => 'practice_test',
              'selection_type' => 'select_one',
              'prompt' => 'Where was a crocodile found yesterday?',
              'choices' => ['In a kitchen in Australia',
                            'On a roof in Manhattan',
                            'On the moon'],
              'correct' => [1]],
            ['type' => 'text',
             'text' => 'Now for the actual task. You will be presented with two longer stories.
                        You will have 30 seconds to read them. Try to take in as much information as possible.
                        There is a timer in the top right of the screen.
                        After the 30 seconds are up, we’ll ask you some questions about the stories.
                        Your 30 seconds will start when you hit continue.'],
            ['type' => 'review',
            'text' => '',
            'targets' => ['Anna Thompson of South Boston, a cook in a school cafeteria, reported to the police
                          that she had been robbed of $56 on State Street the night before last. She had four
                          small children, the rent was due, and they had not eaten for two days. The police,
                          touched by the woman’s story, collected money for her.',
                          'A 67 year old woman in Greensville, Florida used a black umbrella to stop an
                          attack by two men. The woman was walking down Main Street when the attackers
                          got out of a yellow pickup and approached her. She hit one with her umbrella and
                          the other man fled. Both men were arrested by police.'],
            'review_time' => 30],

            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'On what street was Anna Thompson robbed?',
              'choices' => ['State Street',
                            'Main Street',
                            'Sixth Street'],
              'correct' => [1]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'In which town was an attack stopped by an umbrella?',
              'choices' => ['Greensville',
                            'Gainessville',
                            'Greensboro'],
              'correct' => [1]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'How old was the woman who defended herself with an umbrella?',
              'choices' => ['56',
                            '57',
                            '67'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What was Anna Thompson\'s job?',
                'choices' => ['Cook',
                              'She didn\'t have a job',
                              'Janitor'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'When did Anna report being robbed?',
                'choices' => ['One night after the robbery',
                              'Two nights after the robbery',
                              'A week after the robbery'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How long had it been since Anna\'s family had eaten?',
                'choices' => ['2 days',
                              '1 day',
                              'They missed 2 meals'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What color was the pickup truck used by the attackers in Florida?',
                'choices' => ['Yellow',
                              'Black',
                              'It wasn\'t mentioned'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What did the police do to help Anna Thompson?',
                'choices' => ['Make arrests',
                              'Collect money for her',
                              'Give her food'],
                'correct' => [2]],

        ] // End blocks
    ], // End story_1

    'story_2' => [
        'test_name' => 'story_2',
        'task_type' => 'story',
        'type' => 'task',
        'blocks' => [
            ['type' => 'text',
             'text' => 'The last memory task asks you to remember
                             two very short stories. Once again, we’ll start with a
                             practice. In the practice round each "story" will only have one sentence.'],
            ['type' => 'review',
            'text' => 'Practice stories:',
            'targets' => ['Peter was hungry, so he went to the store on the
                           corner of his street and bought a hamburger.',
                         'Yesterday, a local woman found a 10-foot crocodile
                         in her kitchen, an event the fire department
                         described as "unusual".'],
            'review_time' => 15],
            [ 'type' => 'practice_test',
             'selection_type' => 'select_one',
             'prompt' => 'Why did Peter go to the store?',
             'choices' => ['Because he was hungry',
                           'To get coffee',
                           'To buy food for his dog'],
             'correct' => [1]],
            [ 'type' => 'practice_test',
             'selection_type' => 'select_one',
             'prompt' => 'Where was a crocodile found yesterday?',
             'choices' => ['In a kitchen in Australia',
                           'On a roof in Manhattan',
                           'On the moon'],
             'correct' => [1]],
            ['type' => 'text',
             'text' => 'Now for the actual task. You will be presented with two longer stories.
                        You will have 30 seconds to read them. Try to take in as much information as possible.
                        There is a timer in the top right of the screen.
                        After the 30 seconds are up, we’ll ask you some questions about the stories.
                        Your 30 seconds will start when you hit continue.'],
            ['type' => 'review',
            'text' => '',
            'targets' => ['A recent survey of supermarket shoppers in Baytown revealed that eight
                          out of ten shopping carts have faulty wheels or are difficult to steer.
                          More than half of people reported having had accidents with their carts.
                          These included collisions with other shoppers and bumping into groceries.
                          Retailers claim that the problem is not with the carts, but that shoppers
                          are not using them carefully.',
                          'There were violent scenes at Grangers, a London department store, when
                          animal rights protesters invaded the furs section.  Two expensive mink
                          jackets were ruined and one leather skirt was ripped.  A protester was
                          taken to hospital after a confrontation with police.  The manager said
                          that tomorrow, business would be back to normal.'],
            'review_time' => 30],

            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'More than half the respondents to the supermarket survey reported what?',
              'choices' => ['Collisions with other shoppers',
                            'Running into stacks of groceries',
                            'Having accidents with their carts'],
              'correct' => [3]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'When was the supermarket survey conducted?',
              'choices' => ['Recently',
                            'Last month',
                            'A week ago'],
              'correct' => [1]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'How many people were arrested after the Department store protest in London?',
              'choices' => ['None',
                            'One',
                            'It\'s unclear based on the story'],
                'correct' => [3]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What problems did customers identify with the shopping carts?',
                'choices' => ['They make an annoying noise',
                              'They have faulty wheels',
                              'They can be difficult to move'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What was the name of the Department Store in London?',
                'choices' => ['Grangers',
                              'Graysons',
                              'Greysons'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'Retailers responded to the supermarket survey by:',
                'choices' => ['Saying they will fix their shopping carts',
                              'Claiming the problem is with the customers',
                              'Promising they’ll look into the issue'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What proportion of shopping carts had issues with faulty wheels or steering?',
                'choices' => ['More than half',
                              'Almost all',
                              '8 out of 10'],
                'correct' => [3]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How were the mink jackets described?',
                'choices' => ['Black',
                              'Expensive',
                              'New'],
                'correct' => [2]]

        ] // End blocks
    ], // End story_2

    'story_3' => [
        'test_name' => 'story_3',
        'task_type' => 'story',
        'type' => 'task',
        'blocks' => [
            ['type' => 'text',
             'text' => 'The last memory task asks you to remember
                             two very short stories. Once again, we’ll start with a
                             practice. In the practice round each "story" will only have one sentence.'],
            ['type' => 'review',
            'text' => 'Practice stories:',
            'targets' => ['Peter was hungry, so he went to the store on the
                           corner of his street and bought a hamburger.',
                         'Yesterday, a local woman found a 10-foot crocodile
                         in her kitchen, an event the fire department
                         described as "unusual".'],
            'review_time' => 15],
            [ 'type' => 'practice_test',
             'selection_type' => 'select_one',
             'prompt' => 'Why did Peter go to the store?',
             'choices' => ['Because he was hungry',
                           'To get coffee',
                           'To buy food for his dog'],
             'correct' => [1]],
            [ 'type' => 'practice_test',
             'selection_type' => 'select_one',
             'prompt' => 'Where was a crocodile found yesterday?',
             'choices' => ['In a kitchen in Australia',
                           'On a roof in Manhattan',
                           'On the moon'],
             'correct' => [1]],
            ['type' => 'text',
             'text' => 'Now for the actual task. You will be presented with two longer stories.
                        You will have 30 seconds to read them. Try to take in as much information as possible.
                        There is a timer in the top right of the screen.
                        After the 30 seconds are up, we’ll ask you some questions about the stories.
                        Your 30 seconds will start when you hit continue.'],
            ['type' => 'review',
            'text' => '',
            'targets' => ['Clothing makers in Europe and China have a problem.  The shape of the
                          American male has changed.  American men now have slimmer waists and larger chests
                          than they did in 1933 when the last measurements were taken.  Manufacturers will
                          alter their designs and have promised to update their statistics more frequently.',
                          'Michael Simpson earned a reputation for being stubborn after refusing to
                          accept pay cheques.  Instead of cheques, he wanted his wages to be paid in
                          cash.  He eventually collected ten thousand dollars in back pay.  His wife
                          was pleased because she had been forced to cook on a camping stove, after
                          services to their home were cut off eighteen months ago.'],
            'review_time' => 30],

            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'Clothing makers from which areas are mentioned in the story?',
              'choices' => ['Europe and Mexico',
                            'Europe and China',
                            'China and Mexico'],
              'correct' => [2]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'Michael had a reputation for being:',
              'choices' => ['Stubborn',
                            'Cheap',
                            'Rude'],
              'correct' => [1]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'How long ago did the services in Michael’s house get turned off?',
              'choices' => ['18 months ago',
                            '6 months ago',
                            '12 months ago'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What was Michael’s last name?',
                'choices' => ['Simpson',
                              'Sanderson',
                              'Sandford'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'When did clothing makers last "measure the American male"?',
                'choices' => ['1933',
                              '1932',
                              '1923'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How much back pay did Michael receive?',
                'choices' => ['Ten thousand dollars',
                              'Eleven thousand dollars',
                              'Twelve thousand dollars'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How has the shape of the American male changed?',
                'choices' => ['Slimmer waists and larger arms',
                              'Larger waists and slimmer legs',
                              'Slimmer waists and larger chests'],
                'correct' => [3]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How did Michael’s wife feel when he finally got paid?',
                'choices' => ['Relieved',
                              'Pleased',
                              'Grateful'],
                'correct' => [2]],

        ] // End blocks
    ], // End story_3

    'story_4' => [
        'test_name' => 'story_4',
        'task_type' => 'story',
        'type' => 'task',
        'blocks' => [
            ['type' => 'text',
             'text' => 'The last memory task asks you to remember
                             two very short stories. Once again, we’ll start with a
                             practice. In the practice round each "story" will only have one sentence.'],
            ['type' => 'review',
            'text' => 'Practice stories:',
            'targets' => ['Peter was hungry, so he went to the store on the
                           corner of his street and bought a hamburger.',
                         'Yesterday, a local woman found a 10-foot crocodile
                         in her kitchen, an event the fire department
                         described as "unusual".'],
            'review_time' => 15],
            [ 'type' => 'practice_test',
             'selection_type' => 'select_one',
             'prompt' => 'Why did Peter go to the store?',
             'choices' => ['Because he was hungry',
                           'To get coffee',
                           'To buy food for his dog'],
             'correct' => [1]],
            [ 'type' => 'practice_test',
             'selection_type' => 'select_one',
             'prompt' => 'Where was a crocodile found yesterday?',
             'choices' => ['In a kitchen in Australia',
                           'On a roof in Manhattan',
                           'On the moon'],
             'correct' => [1]],
            ['type' => 'text',
             'text' => 'Now for the actual task. You will be presented with two longer stories.
                        You will have 30 seconds to read them. Try to take in as much information as possible.
                        There is a timer in the top right of the screen.
                        After the 30 seconds are up, we’ll ask you some questions about the stories.
                        Your 30 seconds will start when you hit continue.'],
            ['type' => 'review',
            'text' => '',
            'targets' => ['At 7:35pm on Monday, Joe Garcia of San Francisco was watching television as he
                          dressed to go out. A weather bulletin interrupted the program to warn of a
                          thunderstorm. The announcer said the storm could bring hail and up to four
                          inches of rain. Joe decided to stay home. He took off his coat and sat down
                          to watch old movies.',
                          'A Tokyo barmaid is suing a customer for two hundred and twenty thousand
                          dollars. The complaint arose after the man attempted a goodnight kiss,
                          causing the couple to fall down a flight of stairs.  The forty six year
                          old woman suffered facial injuries in the fall but avoided the attempted
                          kiss.'],
            'review_time' => 30],

            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'In which city was there bad weather predicted?',
              'choices' => ['San Jose',
                            'San Diego',
                            'San Francisco'],
              'correct' => [3]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'On which day was bad weather predicted?',
              'choices' => ['Monday',
                            'Sunday',
                            'Tuesday'],
              'correct' => [1]],
            [ 'type' => 'test',
              'selection_type' => 'select_one',
              'prompt' => 'How much is the Tokyo barmaid suing for?',
              'choices' => ['$220,000',
                            '$200,000',
                            '$20,000'],
                'correct' => [1]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How much rain was the storm predicted to bring?',
                'choices' => ['At least 4 inches',
                              'Up to 4 inches',
                              'More than 4 inches'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How old was the Tokyo barmaid?',
                'choices' => ['36',
                              '46',
                              '26'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'Who is the Tokyo barmaid suing?',
                'choices' => ['Her manager',
                              'Her employer',
                              'Her customer'],
                'correct' => [3]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'What did Joe do when he heard the news about bad weather?',
                'choices' => ['Call in sick',
                              'Watch old movies',
                              'Go back to watching TV programs'],
                'correct' => [2]],
              [ 'type' => 'test',
                'selection_type' => 'select_one',
                'prompt' => 'How did Joe find about the weather?',
                'choices' => ['He was watching a news program',
                              'A weather report interrupted the program he was watching',
                              'He saw a weather bulletin between shows'],
                'correct' => [2]],

        ] // End blocks
    ], // End story_4

  ]; // End memoryTests


  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['true', 'false'],
                                     'test' => ['images_instructions', 'faces_1', 'faces_2',
                                                'cars_1', 'bikes_1', 'words_1', 'words_2',
                                                'words_3', 'words_4', 'story_1', 'story_2',
                                                'story_3', 'story_4']];

  public function getTests() {
    return $this->prompts;
  }

  public function setTests($tests) {
    $this->memoryTests = $tests;
  }

  public function getRandomTest() {
    return $this->memoryTests[array_rand($this->memoryTests)];
  }

  public function getTest($test) {
    return $this->memoryTests[$test];
  }


  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
