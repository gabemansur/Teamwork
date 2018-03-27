<?php
namespace Teamwork\Tasks;

class Optimization {


  private $functions = ['a'];
  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['true', 'false'], 'function' => ['random']];


  public function getFunctions() {
    return $this->functions;
  }

  public function setFunctions($functions) {
    $this->functions = $functions;
  }


  public function getRandomFunction() {
    return $this->functions[array_rand($this->functions)];
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }
}
