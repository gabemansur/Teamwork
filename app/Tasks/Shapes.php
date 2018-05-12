<?php
namespace Teamwork\Tasks;

class Shapes {

  private $shapes = [
    'subtest1' => ['length' => 13,
                   'answers' => ['b', 'c', 'b', 'd', 'e', 'b', 'd', 'b',
                                 'f', 'c', 'b', 'b', 'e']],
    'subtest2' => ['length' => 14],
    'subtest3' => ['length' => 15],
    'subtest4' => ['length' => 12]
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['false'], 'subtest' => ['subtest1']];


  public function getShapes($test) {
    return $this->shapes[$test];
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
