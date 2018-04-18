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

      $tasks = Self::$TASKS;

      if($randomize) shuffle($tasks);

      foreach($tasks as $key => $task) {

        $g = new GroupTask;
        $g->group_id = $group_id;
        $g->name = $task['name'];
        $g->order = $key + 1;
        $g->parameters = serialize(Self::setDefaultTaskParameters($task['name']));
        $g->save();

        if($task['hasIndividuals']) {
          \Teamwork\IndividualTask::create(['group_task_id' => $g->id]);
        }
      }

      return GroupTask::where('group_id', $group_id)
                      ->with('individualTasks')
                      ->orderBy('order', 'ASC')
                      ->get();
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
