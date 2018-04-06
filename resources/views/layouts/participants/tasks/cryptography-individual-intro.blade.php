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


  $(".submit-equation").on("click", function(event) {

    var target = $(this).attr('id');

    $(".alert").hide();

    if(trialStage == 1) {

      var equation = $("#equation").val().toUpperCase();
      if(equation == '') {
        event.preventDefault();
        return;
      };

      $("#hypothesis").hide();
      trialStage++;


      try {
        var answer = crypto.parseEquation(equation);
        $("#result-" + target).html(equation + ' = ' + answer);
      }

      catch(e) {
        trialStage = 1;
        $("#alert-" + target).html(e);
        $("#alert-" + target).show();
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
        <h5>
          Practice: enter an equation!<br>
          <div id="alert" class="alert alert-danger" id="alert-submit-equation-2" role="alert"></div>
          <div class="form-group text-center">
            <input type="text" class="form-control form-control-lg" name="equation" id="equation" style="width:40%; margin: 0 auto;">
          </div>
          <h3 class="text-success" id="result-submit-equation-1"></h3>
          <div class="text-center">
            <button class="btn btn-lg btn-primary submit-equation" id="submit-equation-1" class="submit-equation" type="submit">Submit</button>
          </div>
        </h5>
        <h5>
          Try another equation:<br>
          <div id="alert" class="alert alert-danger" id="alert-submit-equation-2" role="alert"></div>
          <div class="form-group text-center">
            <input type="text" class="form-control form-control-lg" name="equation" id="equation" style="width:40%; margin: 0 auto;">
          </div>
          <h3 class="text-success" id="result-submit-equation-2"></h3>
          <div class="text-center">
            <button class="btn btn-lg btn-primary submit-equation" id="submit-equation-2" type="submit">Submit</button>
          </div>
        </h5>
      </div>
      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
  </div>
</div>
@stop
