<?php

namespace Teamwork;

use Illuminate\Database\Eloquent\Model;

class GroupTask extends Model
{
    protected $fillable = ['group_id', 'name', 'parameters', 'order'];

    private static $TASKS = [
                      ['name' => 'OptimizationTask',
                       'hasIndividuals' => true],
                      ['name' => 'UnscrambleWords',
                       'hasIndividuals' => false],
                      ['name' => 'Brainstorming',
                       'hasIndividuals' => true]
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

    public static function initializeTasks($group_id, $requiredTasks, $randomize = true) {

      $tasks = Self::$TASKS;

      if($randomize) shuffle($tasks);

      foreach($tasks as $key => $task) {

        if(in_array($task['name'], $requiredTasks)) {
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
      if($taskName == 'OptimizationTask') {
        $parameters = ['function' => (new \Teamwork\Tasks\Optimization)->getRandomFunction(),
                       'maxResponses' => 6];
      }
      return $parameters;
    }
}
