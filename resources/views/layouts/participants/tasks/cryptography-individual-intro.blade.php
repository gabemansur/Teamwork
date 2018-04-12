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
  var mapping = <?php echo  $mapping; ?>;
  var trialStage = 1;
  var hypothesisCount = 0;

$( document ).ready(function() {
  $(".alert").hide();

  instructionPaginator(function(){window.location = '/cryptography';});

  var crypto = new Cryptography(mapping);


  $(".submit-equation").on("click", function(event) {

    $(".alert").hide();
    var equation = $("#equation-" + trialStage).val().toUpperCase();
    if(equation == '' || !equation) {
      $("#alert-" + trialStage).html('Enter your equation in the box below!');
      $("#alert-" + trialStage).show();
      event.preventDefault();
      return;
    };

    try {
      var answer = crypto.parseEquation(equation);
      console.log(answer);
      $("#result-" + trialStage).html(equation + ' = ' + answer);
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
    if(hypothesisCount < 2){
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
    <div class="col-md-10 offset-md-1 text-center">
      <h2 class="text-primary">Cryptography Task</h2>
      <div id="inst_1" class="inst">
        <h5>
          In this task, letters each correspond to a number. The goal of the
          task is to find out which letter corresponds to each number.
        </h5>
        <h5>
          We’ll start with a practice. To make things clear, say the
          correspondence [which you won’t know] is as follows: <br><br>
          <span class="bg-light p-md-2 mt-md-4">
            @foreach($aSorted as $key => $val)
              {{ $val }} = {{ $key }};&nbsp;
            @endforeach
          </span>
        </h5>
        <h5>
          Your goal is to uncover this mapping with the minimum number of
          "trials". A trial involves three steps: EQUATION; HYPOTHESIS; GUESS.
        </h5>
        <h5>
          1. 1)	First, let’s look at “EQUATION”. Write a combination of letters
          (with + and -).
        </h5>
        <h5>
          For example: <br>
          You might propose A+C. The computer will then tell you A+C=D <br>
          You could also propose CC-A. The computer will then tell you CC-A=CA
        </h5>
        <div id="practice-1" class="mb-lg-5">
          <div class="row">
            <div class="col-md-6 offset-md-3">
              <h4 class="text-warning">
                Practice: enter an equation!
              </h4>
              <div class="alert alert-danger" id="alert-1" role="alert"></div>
              <form class="form-inline">
                <input type="text" class="form-control form-control-lg mr-lg-5 ml-lg-5" name="equation" id="equation-1">
                <button class="btn btn-lg btn-primary submit-equation" id="submit-equation-1" type="submit">Submit</button>
              </form>
              <h3 class="text-success" id="result-1"></h3>
            </div>
          </div>
        </div>
        <div id="practice-2">
          <div class="row">
            <div class="col-md-6 offset-md-3">
              <h4 class="text-warning">
                Try another equation:<br>
              </h4>
              <div class="alert alert-danger" id="alert-2" role="alert"></div>
              <form class="form-inline">
                <input type="text" class="form-control form-control-lg mr-lg-5 ml-lg-5" name="equation" id="equation-2">
                <button class="btn btn-lg btn-primary submit-equation" id="submit-equation-2" type="submit">Submit</button>
              </form>
              <h3 class="text-success" id="result-2"></h3>
            </div>
          </div>
        </div>
      </div> <!-- End inst_1 -->

      <div id="inst_2" class="inst">
        <h5>
          Second you can suggest a HYPOTHESIS. For example: C=3. If this were
          your hypothesis, the computer would tell you “FALSE”. If you had
          proposed C=2 then, in this case the computer would say “TRUE”
        </h5>
        <div id="hypothesis">
          <h4 class="text-warning">
            Practice: enter an equation!
          </h4>
          <h5>
            Use the drop-downs to propose a mapping for one of the letters.
          </h5>
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
        <h5>
          Third, and last, at the end of each trial, the group guesses at the
          whole mapping. If you are correct, the task is complete! If not, we
          start another trial.
        </h5>
        <div id="guess-full-mapping">
          <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
              <h4 class="text-primary">3. Guess the full mapping</h4>
              <h5>
                Use the drop-downs to guess a value for each element.
              </h5>
              @foreach($sorted as $key => $el)
                <span>{{ $el }} = </span>
                <select class="form-control full-mapping" name="{{ $el }}">
                    <option>---</option>
                    @for($i = 0; $i < count($sorted); $i++)
                      <option>{{ $i }}</option>
                    @endfor
                </select>

              @endforeach
            </div>
          </div>
        </div>
      </div> <!-- End inst_3 -->

      <div id="inst_4" class="inst">
        <h5>
          To review:
        </h5>
        <h5>
          You will have a maximum of 15 trials and 10 minutes to solve
          the cryptography task. Each trial has three elements:
        </h5>
        <div class="row">
          <div class="col-md-6 offset-md-3">
            <h5>
              <ul>
                <li>
                  Propose an equation (e.g. CC+B-A = ?)
                </li>
                <li>
                  Hypothesis (e.g. C=1)
                </li>
                <li>
                  Guess the mapping
                </li>
              </ul>
            </h5>
          </div>
        </div>
        <h5>
          The overall goal is to solve the whole puzzle in the minimum number
          of trials. If you don’t solve the task, you will get some points for
          each letter-number combination you correctly identify.
        </h5>
      </div> <!-- End inst_4 -->
      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
  </div>
</div>
@stop
