<?php
namespace Teamwork\Tasks;

class Cryptography {


  private $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H','I', 'J'];
  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'],
                                     'hasGroup' => ['true', 'false'],
                                     'mapping' => ['random'],
                                     'maxResponses' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]];

  public function getLetters() {
    return $this->letters;
  }

  public function setFunctions($letters) {
    $this->letters = $letters;
  }


  public function randomMapping() {
    shuffle($this->letters);
    return $this->letters;
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

  public function getMapping($mapType) {
    $mapping = $this->letters;

    switch ($mapType) {
      case "random":
        shuffle($mapping);
        break;

    }
    return $mapping;
  }


}
