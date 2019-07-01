<?php

namespace Teamwork;

use Illuminate\Database\Eloquent\Model;

class GroupTask extends Model
{
    protected $fillable = ['group_id', 'name', 'parameters', 'order'];

    private static $TASKS = [
                      ['name' => 'Consent',
                      'params' => [],
                      'hasIndividuals' => true],
                      ['name' => 'Intro',
                      'params' => [],
                      'hasIndividuals' => true],
                      ['name' => 'Eyes',
                      'params' => [],
                      'hasIndividuals' => true],
                      ['name' => 'Memory',
                      'params' => [],
                      'hasIndividuals' => true],
                      ['name' => 'BigFive',
                       'params' => [],
                       'hasIndividuals' => true],
                      ['name' => 'TeamRole',
                       'params' => [],
                       'hasIndividuals' => true],
                      ['name' => 'Cryptography',
                       'params' => [],
                       'hasIndividuals' => false],
                      ['name' => 'Optimization',
                       'hasIndividuals' => true],
                      ['name' => 'UnscrambleWords',
                       'hasIndividuals' => false],
                      ['name' => 'Brainstorming',
                       'hasIndividuals' => true],
                      ['name' => 'Shapes',
                       'hasIndividuals' => true],
                      ['name' => 'Feedback',
                       'hasIndividuals' => true],
                       ['name' => 'Conclusion',
                       'params' => [],
                       'hasIndividuals' => true],
                    ];

    public function group() {
      return $this->belongsTo('\Teamwork\Group');
    }

    public function individualTasks() {
      return $this->hasMany('\Teamwork\IndividualTask');
    }

    public function response() {
      return $this->hasMany('\Teamwork\Response', 'group_tasks_id', 'id');
    }

    public function progress() {
      return $this->hasMany('\Teamwork\Progress', 'group_tasks_id', 'id');
    }

    public static function getTasks() {
      $tasks = [];
      foreach (Self::$TASKS as $key => $task) {
        $class = "\Teamwork\Tasks\\".$task['name'];
        $tasks[$key]['name'] = $task['name'];
        $tasks[$key]['params'] = $class::getAvailableParams();
      }
      return $tasks;
    }

    public static function initializeDefaultTasks($group_id, $randomize) {

      $taskArray = '[{"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":"all"}},{"taskName":"BigFive","taskParams":{"hasIndividuals":"true","hasGroup":"false","statementOrder":"random"}},{"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},{"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"10"}},{"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"a","maxResponses":"9","intro":"individual"}},{"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"b","maxResponses":"9","intro":"individual_alt"}},{"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},{"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["faces_1","words_1","story_1"]}}]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);

    }

    public static function initializeIQTasks($group_id, $randomize) {
      $taskArray = '[{"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},{"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},{"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"c","intro":"individual","maxResponses":"9"}},{"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"f","intro":"individual_alt","maxResponses":"9"}},{"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["faces_1","words_1","story_1"]}}]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeEQTasks($group_id, $randomize) {
      $taskArray = '[{"taskName":"BigFive","taskParams":{"hasIndividuals":"true","hasGroup":"false","statementOrder":"random"}},{"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},{"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":"all"}}]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeTestingTasks($group_id, $randomize) {
      $taskArray = '[
          {"taskName":"Consent","taskParams":{"hasIndividuals":"true","hasGroup":"false","subjectPool":"mturk"}},
          {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"hdsl_individual"}},
          {"taskName":"BigFive","taskParams":{"hasIndividuals":"true","hasGroup":"false","statementOrder":"random"}}

        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeGroupMemoryTasks($group_id, $randomize) {
      $taskArray = '[
        {"taskName":"ChooseReporter","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_4_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_4"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeGroupTestTasks($group_id, $randomize) {
      $taskArray = '[
        {"taskName":"ChooseReporter","taskParams":{"hasIndividuals":"true","hasGroup":"true"}},
        {"taskName":"Shapes","taskParams":{"hasIndividuals":"false","hasGroup":"true","subtest":"subtest5"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"4","intro":"group_1","maxResponses":"15"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"6","intro":"group_alt_intro","maxResponses":"15"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_1_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_1"}},
        {"taskName":"Cryptography","taskParams":{"hasIndividuals":"false","intro":"group_1","hasGroup":"true","mapping":"random","maxResponses":"15"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeGroupOneTasks($group_id, $randomize) {
      $taskArray = '[
        {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"group_1"}},
        {"taskName":"ChooseReporter","taskParams":{"hasIndividuals":"true","hasGroup":"true"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"4","intro":"group_1","maxResponses":"15"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"6","intro":"group_alt_intro","maxResponses":"15"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_1_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_1"}},
        {"taskName":"Cryptography","taskParams":{"hasIndividuals":"false","intro":"group_1","hasGroup":"true","mapping":"random","maxResponses":"15"}},
        {"taskName":"Shapes","taskParams":{"hasIndividuals":"false","hasGroup":"true","subtest":"subtest2"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeGroupTwoTasks($group_id, $randomize) {
      $taskArray = '[
        {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"group_2"}},
        {"taskName":"ChooseReporter","taskParams":{"hasIndividuals":"true","hasGroup":"true"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"4","intro":"group_2","maxResponses":"15"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"2","intro":"group_alt_intro","maxResponses":"15"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_2_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_2"}},
        {"taskName":"Cryptography","taskParams":{"hasIndividuals":"false","intro":"group_2","hasGroup":"true","mapping":"random","maxResponses":"15"}},
        {"taskName":"Shapes","taskParams":{"hasIndividuals":"false","hasGroup":"true","subtest":"subtest3"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeGroupThreeTasks($group_id, $randomize) {
      $taskArray = '[
        {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"group_2"}},
        {"taskName":"ChooseReporter","taskParams":{"hasIndividuals":"true","hasGroup":"true"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"4","intro":"group_3","maxResponses":"15"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"5","intro":"group_alt_intro","maxResponses":"15"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_3_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_3"}},
        {"taskName":"Cryptography","taskParams":{"hasIndividuals":"false","intro":"group_3","hasGroup":"true","mapping":"random","maxResponses":"15"}},
        {"taskName":"Shapes","taskParams":{"hasIndividuals":"false","hasGroup":"true","subtest":"subtest4"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeGroupFourTasks($group_id, $randomize) {
      $taskArray = '[
        {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"group_2"}},
        {"taskName":"ChooseReporter","taskParams":{"hasIndividuals":"true","hasGroup":"true"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"4","intro":"group_3","maxResponses":"15"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"false","hasGroup":"true","function":"5","intro":"group_alt_intro","maxResponses":"15"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_4_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"false","hasGroup":"true","test":"group_4"}}
        {"taskName":"Shapes","taskParams":{"hasIndividuals":"false","hasGroup":"true","subtest":"subtest4"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeMemoryTasks($group_id, $randomize) {
      $taskArray = '[
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"intro"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_1"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"faces_1"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_1"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"results"}},
        {"taskName":"Conclusion","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk","hasCode":"true"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeBlockATasks($group_id, $randomize) {
      $taskArray = '[
          {"taskName":"Consent","taskParams":{"hasIndividuals":"true","hasGroup":"false","subjectPool":"mturk"}},
          {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk"}},
          {"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","intro":"individual","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"1","intro":"individual","maxResponses":"15"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"4","intro":"individual_alt","maxResponses":"15"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","intro":"individual_alt","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":["1","2"]}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"faces_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_short_intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"cars_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_short_intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_2"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_short_intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_2"}},
          {"taskName":"Feedback","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk","hasCode":"true"}},
          {"taskName":"Conclusion","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk","hasCode":"true"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeBlockBTasks($group_id, $randomize) {

      $taskArray = '[
        {"taskName":"Consent","taskParams":{"hasIndividuals":"true","hasGroup":"false","subjectPool":"mturk"}},
        {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk"}},
        {"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},
        {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","intro":"individual","hasGroup":"false","mapping":"random","maxResponses":"15"}},
        {"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"2","intro":"individual","maxResponses":"15"}},
        {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"6","intro":"individual_alt","maxResponses":"15"}},
        {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","intro":"individual_alt","hasGroup":"false","mapping":"random","maxResponses":"15"}},
        {"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":["2","3"]}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"intro"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"cars_1"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_short_intro"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"faces_2"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_2"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_short_intro"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_3"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_instructions"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_2"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_short_intro"}},
        {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_3"}},
        {"taskName":"Feedback","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk","hasCode":"true"}},
        {"taskName":"Conclusion","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk","hasCode":"true"}}
        ]';

      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeBlockCTasks($group_id, $randomize) {
      $taskArray = '[
          {"taskName":"Consent","taskParams":{"hasIndividuals":"true","hasGroup":"false","subjectPool":"mturk"}},
          {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk"}},
          {"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","intro":"individual","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"3","intro":"individual","maxResponses":"15"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"8","intro":"individual_alt","maxResponses":"15"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","intro":"individual_alt","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":["3","4"]}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"faces_2"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_short_intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"bikes_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_3"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_short_intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_4"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_3"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_short_intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_4"}},
          {"taskName":"Feedback","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk","hasCode":"true"}},
          {"taskName":"Conclusion","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk","hasCode":"true"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeBlockDTasks($group_id, $randomize) {
      $taskArray = '[
          {"taskName":"Consent","taskParams":{"hasIndividuals":"true","hasGroup":"false","subjectPool":"mturk"}},
          {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk"}},
          {"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","intro":"individual","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"5","intro":"individual","maxResponses":"15"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"7","intro":"individual_alt","maxResponses":"15"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","intro":"individual_alt","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":["4","1"]}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"bikes_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_short_intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"faces_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_4"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_short_intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_4"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_short_intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_1"}},
          {"taskName":"Feedback","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk","hasCode":"true"}},
          {"taskName":"Conclusion","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"mturk","hasCode":"true"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeLabIndividualTasks($group_id, $randomize) {
      $taskArray = '[
          {"taskName":"Consent","taskParams":{"hasIndividuals":"true","hasGroup":"false","subjectPool":"hdsl_individual"}},
          {"taskName":"Intro","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"hdsl_individual"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"1","intro":"individual","maxResponses":"15"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"2","intro":"individual_alt","maxResponses":"15"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"3","intro":"individual_alt","maxResponses":"15"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"intro"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"words_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"images_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"faces_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_instructions"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"story_1"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":"results"}},
          {"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},
          {"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
          {"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":["1","2", "3", "4"]}},
          {"taskName":"BigFive","taskParams":{"hasIndividuals":"true","hasGroup":"false","statementOrder":"random"}},
          {"taskName":"Feedback","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"hdsl_individual","hasCode":"false"}},
          {"taskName":"Conclusion","taskParams":{"hasIndividuals":"true","hasGroup":"false","type":"hdsl_individual","hasCode":"false"}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeAssignedBlockTasks($group_id) {
      $nextBlock = null;
      $lastBlock = \DB::table('random_block_assignments')->orderBy('created_at', 'desc')->first();

      switch ($lastBlock->block) {
        case 'A':
          $nextBlock = 'B';
          Self::initializeBlockBTasks($group_id, false);
          break;

        case 'B':
          $nextBlock = 'C';
          Self::initializeBlockCTasks($group_id, false);
          break;

        case 'C':
          $nextBlock = 'D';
          Self::initializeBlockDTasks($group_id, false);
          break;

        case 'D':
        default:
          $nextBlock = 'A';
          Self::initializeBlockATasks($group_id, false);
          break;
      }

      \DB::table('random_block_assignments')
          ->insert(['group_id' => $group_id, 'block' => $nextBlock,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()]);
      return;
    }


    public static function initializeTasks($group_id, $requiredTasks, $randomize = false) {
      $tasks = json_decode($requiredTasks);
      foreach ($tasks as $key => $task) {
        $g = new GroupTask;
        $g->group_id = $group_id;
        $g->name = $task->taskName;
        $g->order = $key + 1;
        $g->parameters = serialize($task->taskParams);
        $g->save();

        if($task->taskParams->hasIndividuals == 'true') {
          \Teamwork\IndividualTask::create(['group_task_id' => $g->id]);
        }
      }

      return GroupTask::where('group_id', $group_id)
                      ->with('individualTasks')
                      ->orderBy('order', 'ASC')
                      ->get();
    }

    public static function setDefaultTaskParameters($taskName) {
      $parameters = [];
      if($taskName == 'Brainstorming') {
        $parameters = ['prompt' => (new \Teamwork\Tasks\Brainstorming)->getRandomPrompt()];
      }
      if($taskName == 'Optimization') {
        $parameters = ['function' => (new \Teamwork\Tasks\Optimization)->getRandomFunction(),
                       'maxResponses' => 6];
      }
      if($taskName == 'Cryptography') {
        $parameters = ['mapping' => (new \Teamwork\Tasks\Cryptography)->randomMapping(),
                       'maxResponses' => 10];
      }

      return $parameters;
    }
}
