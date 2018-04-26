<?php
namespace Teamwork\Tasks;

class Eyes {

  private $DIRECTORY = '/img/rmet/';
  private $test = [
        ['img' => 'Eyes0.png',
        'choices' => ['jealous', 'panicked', 'arrogant', 'hateful'],
        'correct' => ''],
        ['img' => 'eyes1.png',
        'choices' => ['playful', 'comforting', 'irritated', 'bored'],
        'correct' => 'playful'],
        ['img' => 'eyes2.png',
        'choices' => ['terrified', 'upset', 'arrogant', 'annoyed'],
        'correct' => 'upset'],
        ['img' => 'eyes3.png',
        'choices' => ['joking', 'flustered', 'desire', 'convinced'],
        'correct' => 'desire'],
        ['img' => 'eyes4.png',
        'choices' => ['joking', 'insisting', 'amused', 'relaxed'],
        'correct' => 'insisting'],
        ['img' => 'eyes5.png',
        'choices' => ['irritated', 'sarcastic', 'worried', 'friendly'],
        'correct' => 'worried'],
        ['img' => 'eyes6.png',
        'choices' => ['aghast', 'fantasizing', 'impatient', 'alarmed'],
        'correct' => 'fantasizing'],
        ['img' => 'eyes7.png',
        'choices' => ['apologetic', 'friendly', 'uneasy', 'dispirited'],
        'correct' => 'uneasy'],
        ['img' => 'eyes8.png',
        'choices' => ['despondent', 'relieved', 'shy', 'excited'],
        'correct' => 'despondent'],
        ['img' => 'eyes9.png',
        'choices' => ['annoyed', 'hostile', 'horrified', 'preoccupied'],
        'correct' => 'preoccupied'],
        ['img' => 'eyes10.png',
        'choices' => ['cautious', 'insisting', 'bored', 'aghast'],
        'correct' => 'cautious'],
        ['img' => 'eyes11.png',
        'choices' => ['terrified', 'amused', 'regretful', 'flirtatious'],
        'correct' => 'regretful'],
        ['img' => 'eyes12.png',
        'choices' => ['indifferent', 'embarrassed', 'sceptical', 'dispirited'],
        'correct' => 'sceptical'],
        ['img' => 'eyes13.png',
        'choices' => ['decisive', 'anticipating', 'threatening', 'shy'],
        'correct' => 'anticipating'],
        ['img' => 'eyes14.png',
        'choices' => ['irritated', 'disappointed', 'depressed', 'accusing'],
        'correct' => 'accusing'],
        ['img' => 'eyes15.png',
        'choices' => ['contemplative', 'flustered', 'encouraging', 'amused'],
        'correct' => 'contemplative'],
        ['img' => 'eyes16.png',
        'choices' => ['irritated', 'thoughtful', 'encouraging', 'sympathetic'],
        'correct' => 'thoughtful'],
        ['img' => 'eyes17.png',
        'choices' => ['doubtful', 'affectionate', 'playful', 'aghast'],
        'correct' => 'doubtful'],
        ['img' => 'eyes18.png',
        'choices' => ['decisive', 'amused', 'aghast', 'bored'],
        'correct' => 'decisive'],
        ['img' => 'eyes19.png',
        'choices' => ['arrogant', 'grateful', 'sarcastic', 'tentative'],
        'correct' => 'tentative'],
        ['img' => 'eyes20.png',
        'choices' => ['dominant', 'friendly', 'guilty', 'horrified'],
        'correct' => 'friendly'],
        ['img' => 'eyes21.png',
        'choices' => ['embarrassed', 'fantasizing', 'confused', 'panicked'],
        'correct' => 'fantasizing'],
        ['img' => 'eyes22.png',
        'choices' => ['preoccupied', 'grateful', 'insisting', 'imploring'],
        'correct' => 'preoccupied'],
        ['img' => 'eyes23.png',
        'choices' => ['contented', 'apologetic', 'defiant', 'curious'],
        'correct' => 'defiant'],
        ['img' => 'eyes24.png',
        'choices' => ['pensive', 'irritated', 'excited', 'hostile'],
        'correct' => 'pensive'],
        ['img' => 'eyes25.png',
        'choices' => ['panicked', 'incredulous', 'despondent', 'interested'],
        'correct' => 'interested'],
        ['img' => 'eyes26.png',
        'choices' => ['alarmed', 'shy', 'hostile', 'anxious'],
        'correct' => 'hostile'],
        ['img' => 'eyes27.png',
        'choices' => ['joking', 'cautious', 'arrogant', 'reassuring'],
        'correct' => 'cautious'],
        ['img' => 'eyes28.png',
        'choices' => ['interested', 'joking', 'affectionate', 'contented'],
        'correct' => 'interested'],
        ['img' => 'eyes29.png',
        'choices' => ['impatient', 'aghast', 'irritated', 'reflective'],
        'correct' => 'reflective'],
        ['img' => 'eyes30.png',
        'choices' => ['grateful', 'flirtatious', 'hostile', 'disappointed'],
        'correct' => 'flirtatious'],
        ['img' => 'eyes31.png',
        'choices' => ['ashamed', 'confident', 'joking', 'dispirited'],
        'correct' => 'confident'],
        ['img' => 'eyes32.png',
        'choices' => ['serious', 'ashamed', 'bewildered', 'alarmed'],
        'correct' => 'serious'],
        ['img' => 'eyes33.png',
        'choices' => ['embarrassed', 'guilty', 'fantasizing', 'concerned'],
        'correct' => 'concerned'],
        ['img' => 'eyes34.png',
        'choices' => ['aghast', 'baffled', 'distrustful', 'terrified'],
        'correct' => 'distrustful'],
        ['img' => 'eyes35.png',
        'choices' => ['puzzled', 'nervous', 'insisting', 'contemplative'],
        'correct' => 'nervous'],
        ['img' => 'eyes36.png',
        'choices' => ['ashamed', 'nervous', 'suspicious', 'indecisive'],
        'correct' => 'suspicious'],

  ];

  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'], 'hasGroup' => ['false']];


  public function getTest() {
    return $this->test;
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }

  public function getDirectory() {
    return $this->DIRECTORY;
  }

}
