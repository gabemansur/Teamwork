<?php

namespace Teamwork;

use Illuminate\Database\Eloquent\Model;

class GroupTask extends Model
{
    protected $fillable = ['group_id', 'name', 'parameters', 'order'];

    private static $TASKS = [
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

      $taskArray = '[{"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":"all"}},{"taskName":"BigFive","taskParams":{"hasIndividuals":"true","hasGroup":"false","statementOrder":"random"}},{"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},{"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"10"}},{"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"a","maxResponses":"9","useAltIntro":"no"}},{"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"b","maxResponses":"9","useAltIntro":"yes"}},{"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},{"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["faces_1","words_1","story_1"]}}]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);

    }

    public static function initializeIQTasks($group_id, $randomize) {
      $taskArray = '[{"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},{"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},{"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"c","useAltIntro":"no","maxResponses":"9"}},{"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"f","useAltIntro":"yes","maxResponses":"9"}},{"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["faces_1","words_1","story_1"]}}]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeEQTasks($group_id, $randomize) {
      $taskArray = '[{"taskName":"BigFive","taskParams":{"hasIndividuals":"true","hasGroup":"false","statementOrder":"random"}},{"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},{"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":"all"}}]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeBlockATasks($group_id, $randomize) {
      $taskArray = '[
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},
          {"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"1","useAltIntro":"no","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"2","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"3","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"4","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["faces_1","words_1","story_1"]}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["cars_1","words_2","story_2"]}},
          {"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":["1","2"]}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeBlockBTasks($group_id, $randomize) {
      $taskArray = '[
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},
          {"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"4","useAltIntro":"no","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"3","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"5","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"6","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["cars_1","words_2","story_2"]}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["faces_2","words_3","story_3"]}},
          {"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":["2","3"]}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeBlockCTasks($group_id, $randomize) {
      $taskArray = '[
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},
          {"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"6","useAltIntro":"no","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"5","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"7","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"8","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["faces_2","words_3","story_3"]}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["bikes_1","words_4","story_4"]}},
          {"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":["3","4"]}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
    }

    public static function initializeBlockDTasks($group_id, $randomize) {
      $taskArray = '[
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Cryptography","taskParams":{"hasIndividuals":"true","hasGroup":"false","mapping":"random","maxResponses":"15"}},
          {"taskName":"Shapes","taskParams":{"hasIndividuals":"true","hasGroup":"false","subtest":"subtest1"}},
          {"taskName":"Eyes","taskParams":{"hasIndividuals":"true","hasGroup":"false"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"8","useAltIntro":"no","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"7","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"2","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Optimization","taskParams":{"hasIndividuals":"true","hasGroup":"false","function":"1","useAltIntro":"yes","maxResponses":"9"}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["bikes_1","words_4","story_4"]}},
          {"taskName":"Memory","taskParams":{"hasIndividuals":"true","hasGroup":"false","test":["faces_1","words_1","story_1"]}},
          {"taskName":"TeamRole","taskParams":{"hasIndividuals":"true","hasGroup":"false","scenarios":["4","1"]}}
        ]';
      return Self::initializeTasks($group_id, $taskArray, $randomize);
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
