<?php
namespace Teamwork\Tasks;

class TeamRole {


  private static $avaialbleParams = ['hasIndividuals' => ['true', 'false'],
                                     'hasGroup' => ['false'],
                                     'function' => ['random']];


  private $scenarios = [
    ['desc' => ['You are the most experienced member of a newly formed '
                .'production team with several members who are new to this '
                .'type of manufacturing.',
                'The manufacturing process is complex, requiring compliance '
                .'with precise standards, to avoid large amounts of product '
                .'waste and possible equipment damage.',
                'Your supervisor has just informed your team that the sales '
                .'department had made a "rush order", committing to ship a '
                .'large batch of product five days before the anticipated ship date.'],
      'prompt' => 'Please rate the effectiveness of each of the following responses:',
      'key' => ['Very Effective', 'Somewhat Effective', 'Neutral', 'Somewhat Ineffective', 'Very Ineffective'],
      'responses' => [
                      ['response' => 'Immediately touch base with the other team members to '
                      .'find out who is the fastest at each of the manufacturing '
                      .'stations, and allocate tasks among you accordingly',
                      'scoring' => 'normal'],
                      ['response' => 'Avoid being overly assertive in the new '
                        .'team and let others determine the team’s direction, '
                        .'because it is important that the younger members take'
                        .'the lead.',
                      'scoring' => 'reverse'],
                      ['response' => 'Quickly decide to continue with your '
                        .'planned production schedule because it probably won\'t '
                        .'be possible to meet the rush order deadline.',
                      'scoring' => 'reverse'],
                      ['response' => 'Quickly meet with your team members to '
                        .'decide the priority that should be given to the '
                        .'"rush order".',
                      'scoring' => 'normal'],
                      ['response' => 'Meet with each of the team members, '
                        .'encouraging them and clarifying what each will '
                        .'have to do in order to reach the deadline.',
                      'scoring' => 'normal'],
                      ['response' => 'Gather the team together and map out a '
                        .'realistic timeline of what must be accomplished in '
                        .'order for the rush shipment to be completed.',
                      'scoring' => 'normal'],
                      ['response' => 'Help the team stay calm by letting them '
                        .'know that they shouldn’t be too stressed about meeting '
                        .'the deadline because Sales knew that it was an '
                        .'unrealistic deadline when they made the commitment.',
                      'scoring' => 'reverse'],
                      ['response' => 'Try not to react too strongly to the news '
                        .'to help the new team members understand that this kind '
                        .'of rush order occurs far too often.',
                      'scoring' => 'reverse'],
                      ['response' => 'Let the team know that although you have '
                        .'not produced an order so quickly in the past, you are '
                        .'confident that by staying focused your team can ship '
                        .'the rush order on time.',
                      'scoring' => 'reverse'],
]                   ]

  ]


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
    switch ($functionType) {
      case 'random':
        return $this->functions[array_rand($this->functions)];
        break;
    }
  }

  public static function getAvailableParams()
  {
    return Self::$avaialbleParams;
  }
}
