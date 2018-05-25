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
  var functionName = "{{ $function }}";
  var MAX_RESPONSES = "{{ $maxResponses }}";
  var hasGroup = "{{ $hasGroup }}";
  var f = taskFunctions.{{ $function }};
  var guessNumber = 0;
  var responses = [];

  // Let's put the function as a string into the final submission form
  $("#final-function").val(f.toString());

  $("#timer-container").hide();
  $("#guess-prompt").hide();

  $("#submit-final").on("click", function(event){
    $("#final-result").val(f($("#final-guess").val()));
    $("#optimization-final-form").submit();
    event.preventDefault();
  });

  $("#continue").on("click", function(event){

    $.get( "/check-task-completion", function( response ) {
      if(response == true) {
        window.location = '/get-individual-task';
      }

      else {
        $(".modal-title").html('Please wait for the rest of the group to finish their responses.');
      }
    });
  });

  $("#group-login").on("click", function(event) {

    $.get( "/group-login-allowed", function( response ) {
      if(response == true) {
        $.post('/store-task-data', {
            _token: "{{ csrf_token() }}",
            data: JSON.stringify(responses)
        });
        window.location = '/group-login';
      }

      else {
        $(".modal-title").html('Please wait for the rest of the group to finish their responses.');
      }

    });

  });

  $("#submit-guess").on("click", function(event) {

    $("#warning").hide();

    var n = $("#guess").val();

    if(n < 0 || n > 300 || n == '') {
      $("#warning").show();
      event.preventDefault();
      return;
    }

    guessNumber++;
    console.log(f(n));

    $.get( "/get-prob-val", { mean: f(n) } )
        .done(function( data ) {
          result = Math.round(Number.parseFloat(data));
          responses.push({guess: n, result: result});
          $("#guess-history").append("<tr><td>" + guessNumber + " of " + MAX_RESPONSES +"</td><td>" + n + "</td><td>" + result + "</td></tr>");
          $("#guess").val('');
          $("#guess-prompt").hide();
        });

    $.post("/optimization-individual", {
        _token: "{{ csrf_token() }}",
        function: functionName,
        guess: n
      } );

    if(guessNumber == MAX_RESPONSES) {

      $.post("/mark-individual-response-complete", {
          _token: "{{ csrf_token() }}",
          maxResponses: MAX_RESPONSES,
          completeGroupTaskAlso: 0
        });

      if(hasGroup == 'true'){
        $('#group-prompt').modal({
          backdrop: 'static',
          keyboard: false
        });

      }
      else {
        $('#individual-prompt').modal({
          backdrop: 'static',
          keyboard: false
        });
        $("#guess-prompt").html('Enter your final answer');
      }
    }

    // Their final guess
    else if(guessNumber > MAX_RESPONSES) {
      $("#final-guess").val($("#guess").val());
      $("#final-result").val(f($("#guess").val()));
      $("#optimization-final-form").submit();
    }

    event.preventDefault();
  });

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
        <div class="alert alert-danger" id="warning" role="alert">
          Your guess must be between 0 and 300.
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <h5 id="guess-prompt">
        Enter your guess below to try to find the number <br>that generates
        the biggest possible output.
      </h5>
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
  <div class="row text-center">
    <div class="col-md-6 offset-md-3">
      <table class="table table-bordered table-sm" id="guess-history">
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

<div class="modal fade" id="individual-prompt">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center">
        Your next guess is your final answer. Based on your previous {{ $maxResponses }} guesses,
        type the number that you think will result in the biggest value.
        </h4>
      </div>
      <div class="modal-body text-center">
        <button class="btn btn-lg btn-primary pull-right" id="ok-final" data-dismiss="modal" type="button">Ok</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="group-prompt">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center">
        You have reached the maximum number of guesses. Decide which member will log in to input the final
        answer for the group.<br>
        The other members of the group can click the 'Continue' button once the group answer has been submitted.
        </h4>
      </div>
      <div class="modal-body text-center">
          <button class="btn btn-lg btn-primary pull-left" id="group-login" type="button">Group Sign In</button>
          <button class="btn btn-lg btn-primary pull-right" id="continue" type="button">Continue</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<form action="/optimization-individual-final" id="optimization-final-form" style="display:none;" method="post">
          {{ csrf_field() }}
          <div class="form-group">
            <input class="form-control" type="text" name="final_guess" id="final-guess">
            <input type="hidden" name="final_result" id="final-result">
            <input type="hidden" name="function" id="final-function" value="{{ $function }}">
          </div>
</form>

@stop
