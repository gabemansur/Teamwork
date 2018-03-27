<?php
namespace Teamwork\Tasks;

class Brainstorming {

  private $prompts = [
    'List different uses for a brick',
    'List as many words as possible that start with S and end in N',
  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['true', 'false'], 'prompt' => ['brick', 'Start with S, ends with N', 'random']];

  public function getPrompts() {
    return $this->prompts;
  }

  public function setPrompts($prompts) {
    $this->prompts = $prompts;
  }

  public function getRandomPrompt() {
    return $this->prompts[array_rand($this->prompts)];
  }

  public function checkResponses($prompt, $responses) {
    $numCorrect = 0;

    return $numCorrect;
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

}
