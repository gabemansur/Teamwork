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

  var crypto = new Cryptography(mapping);

  $("#next").on('click', function(event) {
    if($("#result").html() == '') {
      $("#alert").html('Enter a practice equation in the box below!');
      $("#alert").show();
      event.stopImmediatePropagation();
    }
    else if($("#hypothesis-result").is(":visible") && $("#hypothesis-result").html() == '') {
      $("#alert-hypothesis").html('Make a practice hypothesis using the drop-downs below!');
      $("#alert-hypothesis").show();
      event.stopImmediatePropagation();
    }
  });

  instructionPaginator(function(){window.location = '/cryptography';});

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
    }

    catch(e) {
      $("#alert-" + trialStage).html(e);
      $("#alert-" + trialStage).show();
    }

    event.preventDefault();
  });

  $(".submit-hypothesis").on("click", function(event) {
    $("#alert-hypothesis").hide();
    if(hypothesisCount < 12){
      hypothesisCount++;
      var result = crypto.testHypothesis($("#hypothesis-left").val(), $("#hypothesis-right").val());
      var output = (result) ? "true" : "false";
      $("#hypothesis-result").append('<h4>' + $("#hypothesis-left").val() + " = " + $("#hypothesis-right").val() + " is " + output + '</h4>');
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
    <div class="col-md-12 text-center">
      <div id="inst_1" class="inst">
        <h2 class="text-primary">Cryptography Task</h2>
        <h4>
          In this task, every letter from A to J has a numerical value. The goal of the
          task is to find out the value of each letter.
        </h4>
        <h4>
          We’ll start with a practice. To make things clear, say the
          value of each letter is as follows: <br><br>
          <span class="bg-light p-md-2 mt-md-4 mb-lg-4">
            A = 6;  B = 5;  C = 7;  D = 4;  E = 1;  F = 8;  G = 3;  H = 2;  I = 9;  J = 0
          </span>
        </h4>
        <h4 class="mt-lg-4">
          Your goal is to uncover this mapping with the minimum number of
          "trials". A trial involves three steps. The first step is to enter
          an <span class="text-equation">equation</span>: this is a combination
          of letters with + and - (you can't multiply or divide). <br><br>
          For example, you might propose A+B. A is 6, B is 5, and E is 1, so the
          computer would tell you A+B=EE.<br> As another example, you might say
          F-G. Here the computer would say F-G=B.<br> Last, you might say BB-HJ
          and the computer would say BB-HJ = GB.
        </h4>
        <div id="practice" class="mb-lg-4 mt-lg-4">
          <div class="row">
            <div class="col-md-8 offset-md-2">
              <h4>
                Practice <span class="text-equation">entering an equation</span>,
                then click "Submit Practice Equation". Once you're done
                practicing, click "Next".
              </h4>
              <div class="alert alert-danger" id="alert" role="alert"></div>
              <form class="form-inline justify-content-center">
                <input type="text" class="form-control form-control-lg mr-lg-5 ml-lg-5" name="equation" id="equation">
                <button class="btn btn-lg btn-equation submit-equation" id="submit-equation" type="submit">Submit Practice Equation</button>
              </form>
              <h4 class="text-success" id="result"></h4>
              <h4 class="text-equation next-prompt">Now, try entering another equation. Once you're done
              practicing, click "Next".</h4>
            </div>
          </div>
        </div>
      </div> <!-- End inst_1 -->

      <div id="inst_2" class="inst">
        <h4>
          Second you can <span class="text-hypothesis">make a HYPOTHESIS</span>.
          This is the part of each "trial" where you can get feedback from the computer
          about one letter. For example, you might hypothesize that C = 3. Recall
          again our example values:<br><br>
          <span class="bg-light p-md-2 mt-md-4 mb-lg-4">
            A = 6;  B = 5;  C = 7;  D = 4;  E = 1;  F = 8;  G = 3;  H = 2;  I = 9;  J = 0
          </span>
        </h4>
        <h4>
          So, if your <span class="text-hypothesis">hypothesis</span> were C = 3,
          the computer would tell you "FALSE".<br>If you had <span class="text-hypothesis">
          hypothesized</span> that C = 7 then, in this case, the computer would
          say "TRUE".
        </h4>
        <h4>Practice making a <span class="text-hypothesis">hypothesis</span>,
          then click "Submit Practice Hypothesis".<br>Once you're done
          practicing, click "Next".
        </h4>
        <div id="hypothesis">
          <div class="alert alert-danger" id="alert-hypothesis" role="alert"></div>
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
            <button class="btn btn-lg btn-success submit-hypothesis" id="submit-hypothesis" type="submit">Submit Practice Hypothesis</button>
          </div>
        </div>
        <div class="text-primary" id="hypothesis-result"></div>
        <div class="alert alert-success" id="alert-hypothesis" role="alert"></div>
      </div> <!-- End inst_2 -->

      <div id="inst_3" class="inst">
        <h4>
          Third, and last, at the end of each trial, you can
          <span class="text-guess">guess the letter values</span>. You can guess
          as many letters as you like, but you will not get any feedback at this point.
          You don't have to enter a guess for every letter. But, to complete the
          task you must guess ALL the letters correctly.
        </h4>
      </div> <!-- End inst_3 -->

      <div id="inst_4" class="inst">
        <h2 class="text-primary">
          To review:
        </h2>
        <h4>
          You will have a maximum of 15 trials and 10 minutes to solve
          the cryptography task. Each trial has three elements:
        </h4>
        <div class="row">
          <div class="col-md-8 offset-md-2 text-left">
            <h4>
              1. <span class="text-equation">Enter an equation</span> (e.g. CC + B - A = ?)<br>
              2. <span class="text-hypothesis">Make a hypothesis</span> (e.g. C = 1)<br>
              3. <span class="text-guess">Guess the letter values</span>
            </h4>
          </div>
        </div>
        <h4>
          The overall goal is to solve the whole puzzle in the minimum number
          of trials.<br>
          If you don’t solve the task, <strong>you will get some points for
          each letter-number combination you correctly identify</strong>.
        </h4>
      </div> <!-- End inst_4 -->
      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
  </div>
</div>
@stop
