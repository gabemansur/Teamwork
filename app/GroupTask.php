<?php

namespace Teamwork;

use Illuminate\Database\Eloquent\Model;

class GroupTask extends Model
{
    protected $fillable = ['group_id', 'name', 'order'];

    private static $TASKS = [
                      ['name' => 'UnscrambleWords', 'hasIndividuals' => false],
                      ['name' => 'Brainstorming', 'hasIndividuals' => true]
                    ];

    public function group() {
      return $this->belongsTo('\Teamwork\Group');
    }

    public function individualTasks() {
      return $this->hasMany('\Teamwork\IndividualTask');
    }

    public function response() {
      return $this->hasMany('\Teamwork\Resonse');
    }

    public static function initializeDefaultTasks($group_id, $randomize) {

      $tasks = Self::$TASKS;

      if($randomize) shuffle($tasks);

      foreach($tasks as $key => $task) {

        $g = GroupTask::create(['group_id' => $group_id, 'name' => $task['name'], 'order' => $key + 1]);
        dump($g);
        if($task['hasIndividuals']) {
          \Teamwork\IndividualTask::create(['group_task_id' => $g->id]);
        }
      }

      return GroupTask::where('group_id', $group_id)
                      ->with('individualTasks')
                      ->orderBy('order', 'ASC')
                      ->get();
    }
}
