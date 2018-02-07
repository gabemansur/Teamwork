<?php
namespace Teamwork\Tasks;

class Optimization {


  private $functions = ['a'];


  public function getFunctions() {
    return $this->prompts;
  }

  public function setFunctions($functions) {
    $this->functions = $functions;
  }


  public function getRandomFunction() {
    return $this->functions[array_rand($this->functions)];
  }


}
