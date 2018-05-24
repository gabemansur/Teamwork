@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/timer.js') }}"></script>
  <script src="{{ URL::asset('js/instructionPaginator.js') }}"></script>
  <script src="{{ URL::asset('js/cryptography.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')
<script>
  var mapping = ['J', 'E', 'H', 'G', 'D', 'B', 'A', 'C', 'F', 'I'];
  var trialStage = 1;
  var hypothesisCount = 0;

  console.log(mapping);

$( document ).ready(function() {
  $(".alert").hide();
  $(".next-prompt").hide();

  instructionPaginator(function(){window.location = '/cryptography';});

  var crypto = new Cryptography(mapping);


  $(".submit-equation").on("click", function(event) {

    $(".alert").hide();
    var equation = $("#equation").val().toUpperCase();
    if(equation == '' || !equation) {
      $("#alert").html('Enter your equation in the box below!');
      $("#alert").show();
      event.preventDefault();
      return;
    };

    try {
      var answer = crypto.parseEquation(equation);
      console.log(answer);
      $("#result").append('<br>' + equation + ' = ' + answer);
      $("#equation").val('');
      $(".next-prompt").show();
      trialStage++;
      if(trialStage > 2) {
        $("#submit-equation").prop("disabled",true);
        $(".next-prompt").hide();
      }
    }

    catch(e) {
      $("#alert-" + trialStage).html(e);
      $("#alert-" + trialStage).show();
    }

    event.preventDefault();
  });

  $(".submit-hypothesis").on("click", function(event) {
    $("#alert-hypothesis").hide();
    if(hypothesisCount < 2){
      hypothesisCount++;
      var result = crypto.testHypothesis($("#hypothesis-left").val(), $("#hypothesis-right").val());
      var output = (result) ? "true" : "false";
      $("#hypothesis-result").append('<h3>' + $("#hypothesis-left").val() + " = " + $("#hypothesis-right").val() + " is " + output + '</h3>');
      $("#alert-hypothesis").html('Have another practice.');
      if(hypothesisCount < 2){
        $("#alert-hypothesis").show();
      }
    }
  });
});

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-10 offset-md-1 text-center">
      <div id="inst_1" class="inst">
        <h2 class="text-primary">Cryptography Task</h2>
        <h3>
          In this task, letters each correspond to a number. The goal of the
          task is to find out which letter corresponds to each number.
        </h3>
        <h3>
          We’ll start with a practice. To make things clear, say the
          correspondence [which you won’t know] is as follows: <br><br>
          <span class="bg-light p-md-2 mt-md-4">
            A = 6;  B = 5;  C = 7;  D = 4;  E = 1;  F = 8;  G = 3;  H = 2;  I = 9;  J = 0
          </span>
        </h3>
        <h3>
          Your goal is to uncover this mapping with the minimum number of
          "trials". A trial involves three steps. The first step is to propose
          an <span class="text-equation">equation</span>: this is a combination of letters (with + and -). For
          example, you might propose A+B. A is 6, B is 5, and E is 1, so the
          computer would tell you A+B=EE.<br> As another example, you might say
          F-G. Here the computer would say F-G=B.<br> Last, you might say BB-HJ
          and the computer would say BB-HJ = GB.
        </h3>
        <div id="practice" class="mb-lg-5">
          <div class="row">
            <div class="col-md-8 offset-md-2">
              <h3 class="text-equation">
                Practice: enter an equation!
              </h3>
              <div class="alert alert-danger" id="alert" role="alert"></div>
              <form class="form-inline">
                <input type="text" class="form-control form-control-lg mr-lg-5 ml-lg-5" name="equation" id="equation">
                <button class="btn btn-lg btn-primary submit-equation" id="submit-equation" type="submit">Submit</button>
              </form>
              <h3 class="text-success" id="result"></h3>
              <h3 class="text-equation next-prompt">Now, try entering another equation.</h3>
            </div>
          </div>
        </div>
      </div> <!-- End inst_1 -->

      <div id="inst_2" class="inst">
        <h3>
          Second you can suggest a <span class="text-hypothesis">HYPOTHESIS</span>. For example: C=3. If this were
          your <span class="text-hypothesis">hypothesis</span>, the computer would tell you “FALSE”. If you had
          proposed C=2 then, in this case the computer would say “TRUE”
        </h3>
        <div id="hypothesis">
          <h3 class="text-hypothesis">
            Practice: enter a hypothesis!
          </h3>
          <h3>
            Use the drop-downs to propose a mapping for one of the letters.
          </h3>
          <select class="form-control propose" id="hypothesis-left">
              <option>---</option>
              @foreach($sorted as $key => $el)
                <option>{{ $el }}</option>
              @endforeach
          </select>
          <span>
            =
          </span>
          <select class="form-control propose" id="hypothesis-right">
              <option>---</option>
              @for($i = 0; $i < count($sorted); $i++)
                <option>{{ $i }}</option>
              @endfor
          </select>
          <div class="text-center">
            <button class="btn btn-lg btn-primary submit-hypothesis" id="submit-hypothesis" type="submit">Submit</button>
          </div>
        </div>
        <div class="text-primary" id="hypothesis-result"></div>
        <div class="alert alert-success" id="alert-hypothesis" role="alert"></div>
      </div> <!-- End inst_2 -->

      <div id="inst_3" class="inst">
        <h3>
          Third, and last, at the end of each trial, you will <span class="text-guess">guess at the
          whole mapping</span>. If you are correct, the task is complete! If not,
          we start another trial.
        </h3>
      </div> <!-- End inst_3 -->

      <div id="inst_4" class="inst">
        <h2 class="text-primary">>
          To review:
        </h2>
        <h3>
          You will have a maximum of 15 trials and 10 minutes to solve
          the cryptography task. Each trial has three elements:
        </h3>
        <div class="row">
          <div class="col-md-6 offset-md-3 text-left">
            <h3>
              1. Propose an <span class="text-equation">equation</span> (e.g. CC+B-A = ?)<br>
              2. <span class="text-hypothesis">Hypothesis</span> (e.g. C=1)<br>
              3. <span class="text-guess">Guess the mapping</span>
            </h3>
          </div>
        </div>
        <h3>
          The overall goal is to solve the whole puzzle in the minimum number
          of trials. If you don’t solve the task, you will get some points for
          each letter-number combination you correctly identify.
        </h3>
      </div> <!-- End inst_4 -->
      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
  </div>
</div>
@stop
