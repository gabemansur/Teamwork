<?php
namespace Teamwork\Tasks;

class Cryptography {


  private $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H','I', 'J'];


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


}
