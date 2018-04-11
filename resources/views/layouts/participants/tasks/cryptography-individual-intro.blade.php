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

$( document ).ready(function() {
  $(".alert").hide();

  instructionPaginator(function(){});

  var crypto = new Cryptography(mapping);


  $(".submit-equation").on("click", function(event) {
    console.log(trialStage);
    $(".alert").hide();

    var equation = $("#equation-" + trialStage).val().toUpperCase();
    console.log(equation);
    if(equation == '') {
      console.log('in if');
      event.preventDefault();
      return;
    };

    try {
      console.log('in try');
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
            A=1, B=0, C=2, D=3, E=9, F=4, G=6, H=5, I=8, J=7
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
              <div id="alert" class="alert alert-danger" id="alert-1" role="alert"></div>
              <form class="form-inline">
                <input type="text" class="form-control form-control-lg mr-lg-5 ml-lg-5" name="equation" id="equation-1">
                <button class="btn btn-lg btn-primary submit-equation" id="submit-equation-1" class="submit-equation" type="submit">Submit</button>
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
              <div id="alert" class="alert alert-danger" id="alert-2" role="alert"></div>
              <form class="form-inline">
                <input type="text" class="form-control form-control-lg mr-lg-5 ml-lg-5" name="equation" id="equation-2">
                <button class="btn btn-lg btn-primary submit-equation" id="submit-equation-2" class="submit-equation" type="submit">Submit</button>
              </form>
              <h3 class="text-success" id="result-2"></h3>
            </div>
          </div>
        </div>
      </div>
      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
  </div>
</div>
@stop
