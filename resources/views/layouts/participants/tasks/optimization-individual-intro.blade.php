@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/optimization.js') }}"></script>
  <script src="{{ URL::asset('js/probability-distributions.js') }}"></script>
  <script src="{{ URL::asset('js/instructionPaginator.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')
<script>
$( document ).ready(function() {
  instructionPaginator(function(){ window.location = '/optimization-individual';});

  var functionName = "{{ $function }}";
  var MAX_RESPONSES = 9;
  var f = taskFunctions.{{ $function }};
  var guessNumber = 0;
  var responses = [];

  $("#guess-prompt").hide();

  $("#submit-guess").on("click", function(event) {

    var n = $("#guess").val();

    if(n < 0 || n > 300 || n == '') {
      $("#warning").show();
      return;
    }

    guessNumber++;

    $.get( "/get-prob-val", { mean: f(n) } )
        .done(function( data ) {
          result = Math.round(Number.parseFloat(data));
          responses.push({guess: n, result: result});
          $("#guess-history").append("<tr><td>" + guessNumber +"</td><td>" + n + "</td><td>" + result + "</td></tr>");
          $("#guess").val('');
          $("#guess-prompt").hide();
        });

    if(guessNumber == MAX_RESPONSES) {

    }

    else {

    }

    $("#practice-prompt").html('Try entering another number between 0 and 300')

    event.preventDefault();
  });
});
</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      <div id="inst_1" class="inst">
        <h2 class="text-primary">Optimization Task</h2>
        <h4>
          The goal of this task is to try to find the number (between 0 and 300)
          that results in your computer returning the biggest possible value.
          You will have 9 guesses.
          A guess can be any number between 0 and 300.
        </h4>
        <h4>
          After you enter your guess, the computer will give you back a number.
          There is a systematic relationship between the number you guess, and
          the number you receive, but the relationship may be difficult to
          understand. Every time you enter the same number, the output you
          receive will be similar (but there is some randomness added in).
          Usually, numbers that are close to each other will receive
          very similar outputs.
        </h4>
        <h4>
          After your 9 guesses, you will be asked to enter the number that you
          believe gives the highest response.
        </h4>
      </div>

      <div id="inst_2" class="inst">
        <h2 class="text-primary">Optimization Practice</h2>
        <h4>
          Let&#39;s start with a practice. Say the underlying relationship
          (which you won’t know) looks like this:
        </h4>
        <img src="/img/optimization-task/function-example.png" class="img-fluid">
        <h4>
          If you look at the graph you can see that when you enter
          the number 50, the output will be close to 100. From the graph, you
          can also see that you will get the biggest output when you enter 240.
          Last, if you enter a number close to 140 the computer will give you
          a negative number.
        </h4>
        <h4 class="text-warning" id="practice-prompt">
          Practice: enter a number between 0 and 300
        </h4>
        <div class="row text-center">
          <div class="col-md-4 offset-md-4">
            <form class="form-inline optimization-practice" name="optimization">
              <div class="form-group">
                <input type="number" class="form-control" id="guess" min="0" max="300">
              </div>
              <div class="form-group">
                <button class="btn btn-primary" id="submit-guess" type="submit">Guess</button>
              </div>
            </form>
            <table class="table table-bordered table-sm optimization-practice" id="guess-history">
              <tr class="text-center">
                <th>Guess #</th>
                <th>Your guess</th>
                <th>Result</th>
              </tr>
            </table>
            </div>
          </div>
      </div>
      <div id="inst_3" class="inst">
        <h4>
          Now, you will do the optimization task {{ count($totalTasks) }}
          separate times. Each time, there will be a different underlying
          relationship. Each time, you will have {{ $maxResponses }} guesses
          to try to find a number that gives you a big value in return.
        </h4>
      </div>

      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>

    </div>
  </div>
</div>
@stop
