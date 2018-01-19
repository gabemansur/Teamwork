<?php
namespace Teamwork\Tasks\UnscrambleWords;

class UnscrambleWords {

  private $words = [
    'unusual', 'guardrail', 'newspaper', 'guitar'
  ];


  public function getWords() {
    return $this->WORDS;
  }

  public function setWords($words) {
    $this->words = $words;
  }

  public function scrambleWords() {
    $words = $this->words;
    foreach ($words as $key => $value) {
      $words[$key] = str_shuffle($value);
    }
    return $words;
  }

}
