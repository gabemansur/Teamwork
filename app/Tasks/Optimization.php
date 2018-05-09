<?php
namespace Teamwork\Tasks;

class Optimization {


  private $functions = ['a', 'b'];
  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'],
                                     'hasGroup' => ['true', 'false'],
                                     'function' => ['a', 'b', 'c', 'd', 'e', 'f'],
                                     'useAltIntro' => ['yes', 'no'],
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

    else return $functionType;
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }
}
