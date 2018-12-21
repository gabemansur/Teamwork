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
  // A = 1;  B = 5;  C = 3;  D = 9;  E = 6;  F = 8;  G = 4;  H = 2;  I = 7;  J = 0
  var mapping = ['J', 'A', 'H', 'C', 'G', 'B', 'E', 'I', 'F', 'D'];
  var trialStage = 1;
  var hypothesisCount = 0;
  var isReporter = {{ $isReporter }}


  console.log(mapping);


$( document ).ready(function() {

  if(!isReporter){
    setTimeout(function() {
      $("#waiting-for-reporter").modal();
    }, 5000);
    setTimeout(function(){
      $("#cryptography-end-form").submit();
    }, 20000);
  }

  $("#finish").on('click', function() {
    $("#cryptography-end-form").submit();
  });

  $("#next").on('click', function(event) {
    if($(".practice-equation").is(":visible") && $("#result").html() == '') {
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

  $(".submit-equation").on("click", function(event) {
    $(".alert").hide();
    var equation = $("#equation").val().toUpperCase().replace(/=/g, '');
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
      $("#alert").html(e);
      $("#alert").show();
    }

    event.preventDefault();
  });

  instructionPaginator(function(){window.location = '/cryptography';});

});

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      <div id="inst_1" class="inst">
        <h2 class="text-primary">Cryptography Task</h2>
        <h3 class="text-success">
          Task {{ \Session::get('completedTasks') + 1 }} of {{ \Session::get('totalTasks') }}
        </h3>
        <h4>
          Next is the Cryptography task, in which every letter from A to J has a numerical
          value. Your goal is to find out the value of each letter.
        </h4>
        <h4>
          This task is the same as the cryptography puzzle you completed as individuals.
          Now you will try to solve the task as a group.
        </h4>
        <h4>
          <strong>At this point everyone should gather around The Reporter’s laptop.</strong>
          If you are not The Reporter, you can click "finish" and close your laptop:
          you won’t be needing it again.
        </h4>
        <h4>
          Once all three members of the group can see the screen of The Reporter’s
          laptop, hit next. We will then review how the cryptography task works.
        </h4>
      </div> <!-- End inst_1 -->
      <div id="inst_2" class="inst">
        <h2 class="text-primary">Cryptography Task</h2>
        <h3>Instructions</h3>
        <h4>
          The goal of the task is to find the value of each letter using as few "trials" as possible. A trial has three steps.
        </h4>
        <h4>
          The first step is to enter an
          <span class="text-equation">equation</span>: this is a combination of
          letters with + and - (you can't multiply or divide). To make things clear,
          imagine the letters had the following values:
          <span class="bg-light p-md-2 mt-md-4 mb-lg-4">
            A = 1;  B = 5;  C = 3;  D = 9;  E = 6;  F = 8;  G = 4;  H = 2;  I = 7;  J = 0
          </span>
        </h4>
        <h4 class="mt-lg-4">
          If we entered the equation D - E, the computer would tell us D - E = C
          (as 9 - 6 = 3). As another example, you might enter DD + E. The computer
          would say DD + E = AJB (99 + 6 = 105).
        </h4>
        <h4>
          Practice <span class="text-equation">entering an equation</span>,
          then click "Submit Practice Equation". Once you're done
          practicing, click "Next".
        </h4>
        <div class="alert alert-danger" id="alert" role="alert"></div>
        <form class="form-inline justify-content-center practice-equation">
          <input type="text" class="form-control form-control-lg mr-lg-5 ml-lg-5" name="equation" id="equation">
          <button class="btn btn-lg btn-equation submit-equation" id="submit-equation" type="submit">Submit Practice Equation</button>
        </form>
        <h4 class="text-success" id="result"></h4>
        <h4 class="text-equation next-prompt">Now, try entering another equation. Once you're done
        practicing, click "Next".</h4>
      </div> <!-- End inst_2 -->
      <div id="inst_3" class="inst">
        <h4>
          Second you can <span class="text-hypothesis">make a HYPOTHESIS</span>.
          This is the part of each "trial" where you can get feedback from the computer
          about one letter. For example, you might hypothesize that C = 3. Recall
          again our example values:<br><br>
          <span class="bg-light p-md-2 mt-md-4 mb-lg-4">
            A = 1;  B = 5;  C = 3;  D = 9;  E = 6;  F = 8;  G = 4;  H = 2;  I = 7;  J = 0
          </span>
        </h4>
        <h4>
          So, if your <span class="text-hypothesis">hypothesis</span> were C = 3,
          the computer would tell you "TRUE".<br>If you had <span class="text-hypothesis">
          hypothesized</span> that C = 7 then, in this case, the computer would
          say "FALSE".
        </h4>
      </div> <!-- End inst_3 -->

      <div id="inst_4" class="inst">
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
      </div> <!-- End inst_4 -->

      <div id="inst_5" class="inst">
        <h4>
          Third, and last, at the end of each trial, you can
          <span class="text-guess">guess the letter values</span>. You can guess
          as many letters as you like. If you enter a guess for every letter AND
          all your guesses are correct, the computer will let you know that you
          have completed the task! If you choose not to enter a guess for some
          letters (or if any of your guesses were incorrect) you won't get any
          feedback: we'll just move straight on to the next trial.
        </h4>
      </div> <!-- End inst_5 -->

      <div id="inst_6" class="inst">
        <h2 class="text-primary">
          To review:
        </h2>
        <h4>
          Each trial has three elements:
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
        <h4>
          You will have a maximum of {{ $maxResponses }} trials and 10 minutes to
          solve the cryptography task.<br>
          No calculators are allowed.<br>
          When you press "Next" your 10 minutes will begin!
        </h4>
      </div> <!-- End inst_6 -->
      @if($isReporter)
        <div id="instr_nav" class="text-center">
          <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
          <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
        </div>
      @else
      <form action="/cryptography-end" id="cryptography-end-form" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="task_result" id="task-result" value="0">
        <div id="instr_nav" class="text-center">
          <input class="btn btn-primary instr_nav btn-lg" type="button" name="finish" id="finish" value="Finish"><br />
        </div>
      </form>
      @endif
    </div>
  </div>
</div>

@include('layouts.includes.gather-reporter-modal')

@stop
