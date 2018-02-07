@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/timer.js') }}"></script>
  <script src="{{ URL::asset('js/optimization.js') }}"></script>
  <script src="{{ URL::asset('js/probability-distributions.js') }}"></script>

@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')
<script>

$( document ).ready(function() {
  var functionName = "{{ $function }}"
  var f = taskFunctions.{{ $function }};
  var guessNumber = 0;
  var responses = [],

  $("#timer-container").hide();
  $("#guess-prompt").hide();

  $("#continue").on("click", function(event){
      $.post('/store-task-data', {
          _token: "{{ csrf_token() }}",
          data: JSON.stringify{
            key: "currentTaskData",
            value: JSON.stringify(responses)
          }
      });
    });

    window.location = '/end-individual-task';
  });

  $("#group-login").on("click", function(event) {
    window.location = '/group-login';
  });

  $("#submit-guess").on("click", function(event) {

    guessNumber++;

    var n = $("#guess").val();
    var result = rnorm(1, f(n), 20);

    responses.push({guess: n, result: result});
    $("#guess-history").append("<tr><td>" + guessNumber + "</td><td>" + n + "</td><td>" + result + "</td></tr>");
    $("#guess").val('');
    $("#guess").prop( "readonly", true );
    $("#guess-prompt").hide();
    $("#timer-container").show();

    $.post("/optimization-individual", {
        _token: "{{ csrf_token() }}",
        function: functionName,
        guess: n
      } );


    if(guessNumber == 6) {
      $('#group-prompt').modal();
    }

    else {

      initializeTimer(5, function() {
        $("#guess").prop( "readonly", false );
        $("#timer-container").hide();
        $("#guess-prompt").show();
      });
    }

    event.preventDefault();
  });

  /*
  $("#timer-submit").on("click", function(event) {
    $("#brainstorming-responses").submit();
    event.preventDefault();
  });

  $("#manual-submit").on("click", function(event) {
    deleteCookie('task_timer');
  });

  initializeTimer(120, function() {
    $("input").prop( "readonly", true );
    $('#submitPrompt').modal();
  });
  */
});

</script>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="spacer">
        <div class="pull-right" id="timer-container">
          <h4 class="pull-right">Next guess in: <span class="text-primary" id="timer"></span></h4>
        </div>
        <div id="guess-prompt">
          <h4 class="text-primary">
            Make your next guess now
          </h4>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <h3>
        Enter your guess below to try to find the number <br>that generates
        the biggest possible output.
      </h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2 offset-md-5">
      <form name="optimization">
        <div class="form-group">
          <input type="number" class="form-control" id="guess" min="0" max="300">
        </div>
        <div class="text-center">
          <button class="btn btn-lg btn-primary" id="submit-guess" type="submit">Guess</button>
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <table class="table table-bordered" id="guess-history">
        <tr class="text-center">
          <th>Guess #</th>
          <th>Your guess</th>
          <th>Result</th>
        </tr>
      </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="group-prompt">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center">
          You have reached the maximum number of guesses.
          When all members of the group are finished guessing
          decide which member will log in to input the group's
          final, best answer.
        </h4>
      </div>
      <div class="modal-body text-center">
          <button class="btn btn-lg btn-primary pull-left" id="group-login" type="button">Group Sign In</button>
          <button class="btn btn-lg btn-primary pull-right" id="continue" type="button">Continue</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@stop
