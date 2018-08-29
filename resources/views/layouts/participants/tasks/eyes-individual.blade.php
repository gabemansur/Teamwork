@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/instructionPaginator.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')
<script>
$( document ).ready(function() {
  instructionPaginator(function(){$("#eyes-responses").submit()});
});

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12">
      <form name="eyes-responses" id="eyes-responses" action="/rmet-individual" method="post">
        {{ csrf_field() }}
        @foreach($tests as $key => $test)
          <div id="inst_{{ $key + 1 }}" class="inst">
            <div class="text-center">
              <img class="eyes" src="{{ $dir.$test['img'] }}">
            </div>
            <div class="row mt-md-4">
              <div class="col-md-2 offset-md-5">
                @foreach($test['choices'] as $c_key => $choice)
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="{{ $key }}"  value="{{ $choice }}">
                    <label class="form-check-label" for="exampleRadios1">
                      {{ $choice }}
                    </label>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        @endforeach
      </form>
      <div id="instr_nav" class="text-center mt-md-4">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
        <span class="text-primary ml-md-4 text-lg" id="pagination-display">
          <span id="curr-page">1</span> / {{ count($tests) }}
        </span>
      </div>
      <div class="float-left mt-lg-4">
        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#word-definitions">Word Definitions</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="word-definitions">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-left">
        <p>
          <span class="consent-em">ACCUSING</span> blaming<br>
                                                   <em>The policeman was <strong>accusing</strong> the man of stealing a wallet.</em>
        </p>
        <p>
          <span class="consent-em">AFFECTIONATE</span> showing fondness toward someone<br>
                                                   <em>Most mothers are <strong>affectionate</strong> to their babies by giving them lots of kisses and cuddles.</em>
        </p>
        <p>
          <span class="consent-em">AGHAST</span> horrified, astonished, alarmed<br>
                                                   <em>Jane was <strong>aghast</strong> when she discovered her house had been burgled.</em>
        </p>
        <p>
          <span class="consent-em">ALARMED</span> fearful, worried, filled with anxiety<br>
                                                   <em>Claire was <strong>alarmed</strong> when she thought she was being followed home.</em>
        </p>
        <p>
          <span class="consent-em">AMUSED</span> finding something funny<br>
                                                   <em>I was <strong>amused</strong> by a funny joke someone told me.</em>
        </p>
        <p>
          <span class="consent-em">ANNOYED</span> irritated, displeased<br>
                                                   <em>Jack was <strong>annoyed</strong> when he found out he had missed the last bus home.</em>
        </p>
        <p>
          <span class="consent-em">ANTICIPATING</span> expecting<br>
                                                   <em>At the start of the football match, the fans were <strong>anticipating</strong> a quick goal.</em>
        </p>
        <p>
          <span class="consent-em">ANXIOUS</span> worried, tense, uneasy<br>
                                                   <em>The student was feeling <strong>anxious</strong> before taking her final exams.</em>
        </p>
        <p>
          <span class="consent-em">APOLOGETIC</span> feeling sorry<br>
                                                   <em>The waiter was very <strong>apologetic</strong> when he spilt soup all over the customer.</em>
        </p>
        <p>
          <span class="consent-em">ARROGANT</span> conceited, self-important, having a big opinion of oneself<br>
                                                   <em>The <strong>arrogant</strong> man thought he knew more about politics than everyone else in the room.</em>
        </p>
        <p>
          <span class="consent-em">ASHAMED</span> overcome with shame or guilt<br>
                                                   <em>The boy felt <strong>ashamed</strong> when his mother discovered him stealing money from her purse.</em>
        </p>
        <p>
          <span class="consent-em">ASSERTIVE</span> confident, dominant, sure of oneself<br>
          <em>The <strong>assertive</strong> woman demanded that the shop give her a refund.</em>
        </p>
        <p>
          <span class="consent-em">BAFFLED</span> confused, puzzled, dumbfounded<br>
          <em>The detectives were completely <strong>baffled</strong> by the murder case.</em>
        </p>
        <p>
          <span class="consent-em">BEWILDERED</span> utterly confused, puzzled, dazed<br>
          <em>The child was <strong>bewildered</strong> when visiting the big city for the first time.</em>
        </p>
        <p>
          <span class="consent-em">CAUTIOUS</span> careful, wary<br>
          <em>Sarah was always a bit <strong>cautious</strong> when talking to someone she did not know.</em>
        </p>
        <p>
          <span class="consent-em">COMFORTING</span> consoling, compassionate<br>
          <em>The nurse was <strong>comforting</strong> the wounded soldier.</em>
        </p>
        <p>
          <span class="consent-em">CONCERNED</span> worried, troubled<br>
          <em>The doctor was <strong>concerned</strong> when his patient took a turn for the worse.</em>
        </p>
        <p>
          <span class="consent-em">CONFIDENT</span> self-assured, believing in oneself<br>
          <em>The tennis player was feeling very <strong>confident</strong> about winning his match.</em>
        </p>
        <p>
          <span class="consent-em">CONFUSED</span> puzzled, perplexed<br>
          <em>Lizzie was so <strong>confused</strong> by the directions given to her, she got lost.</em>
        </p>
        <p>
          <span class="consent-em">CONTEMPLATIVE</span> reflective, thoughtful, considering<br>
          <em>John was in a <strong>contemplative</strong> mood on the eve of his 60th birthday.</em>
        </p>
        <p>
          <span class="consent-em">CONTENTED</span> satisfied<br>
          <em>After a nice walk and a good meal, David felt very <strong>contented</strong>.</em>
        </p>
        <p>
          <span class="consent-em">CONVINCED</span> certain, absolutely positive<br>
          <em>Richard was <strong>convinced</strong> he had come to the right decision.</em>
        </p>
        <p>
          <span class="consent-em">CURIOUS</span> inquisitive, inquiring, prying<br>
          <em>Louise was <strong>curious</strong> about the strange shaped parcel.</em>
        </p>
        <p>
          <span class="consent-em">DECIDING</span> making your mind up<br>
          <em>The man was <strong>deciding</strong> whom to vote for in the election.</em>
        </p>
      </div>
      <div class="modal-body text-center">
        <button class="btn btn-lg btn-primary pull-right" data-dismiss="modal" type="button">Ok</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

@stop
