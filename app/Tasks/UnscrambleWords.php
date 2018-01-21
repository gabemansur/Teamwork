<?php
namespace Teamwork\Tasks;

class UnscrambleWords {

  private $words = [
    'unusual', 'guardrail', 'newspaper', 'guitar'
  ];


  public function getWords() {
    return $this->words;
  }

  public function setWords($words) {
    $this->words = $words;
  }

  public function getScrambledWords() {
    $words = $this->words;
    foreach ($words as $key => $value) {
      $words[$key] = str_shuffle($value);
    }
    return $words;
  }

}
