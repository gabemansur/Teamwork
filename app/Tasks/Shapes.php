<?php
namespace Teamwork\Tasks;

class Shapes {

  private $shapes = [
    'subtest1' => ['length' => 13,
                   'answers' => ['b', 'c', 'b', 'd', 'e', 'b', 'd', 'b',
                                 'f', 'c', 'b', 'b', 'e']],
    'subtest2' => ['length' => 14,
                   'answers' => [['b', 'e'], ['a', 'e'], ['a', 'd'], ['c', 'e'],
                                 ['b', 'e'], ['a', 'd'], ['b', 'e'], ['b', 'e'],
                                 ['a', 'd'], ['b', 'd'], ['a', 'e'], ['c', 'd'],
                                 ['b', 'c'], ['a', 'b']]],
    'subtest3' => ['length' => 13,
                    'answers' => [['e'], ['e'], ['e'], ['b'],
                                  ['c'], ['d'], ['e'], ['e'],
                                  ['a'], ['a'], ['f'], ['c'], ['c']]],
    'subtest4' => ['length' => 10,
                    'answers' => [['b'], ['a'], ['d'], ['d'],
                                  ['a'], ['b'], ['c'], ['d'],
                                  ['a'], ['d']]],
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['false'], 'subtest' => ['subtest1', 'subtest2']];


  public function getShapes($test) {
    return $this->shapes[$test];
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
