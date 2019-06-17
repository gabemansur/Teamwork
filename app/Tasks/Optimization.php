<?php
namespace Teamwork\Tasks;

class Optimization {


  private $functions =      ['t1', 't2', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
  private $functionLabels = ['a1', 'a2', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'],
                                     'hasGroup' => ['true', 'false'],
                                     'function' => ['a1', 'a2', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                                     'intro' => ['individual', 'individual_alt', 'group_1', 'group_2', 'group_3', 'group_alt_intro'],
                                     'maxResponses' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]];


  public function getFunctions() {
    return $this->functions;
  }

  public function setFunctions($functions) {
    $this->functions = $functions;
  }


  public function getRandomFunction() {
    return $this->functions[array_rand($this->functions)];
  }

  public function getFunction($functionType) {

    if($functionType == 'random') {
      return $this->functions[array_rand($this->functions)];
    }

    else return $this->functions[array_search($functionType, $this->functionLabels)];
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
