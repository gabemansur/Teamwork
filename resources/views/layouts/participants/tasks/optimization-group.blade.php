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

  var isReporter = @if($isReporter) true @else false @endif;
  var functionName = "{{ $function }}";
  var MAX_RESPONSES = {{ floor($maxResponses / $groupSize) }};
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

    if(guessNumber > MAX_RESPONSES) {
      $("#final-guess").val($("#guess").val());
      $("#final-result").val(f($("#guess").val()));
      $("#optimization-final-form").submit();
      event.preventDefault();
      return;
    }

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
      $('#final-guess-prompt').modal();
    }

    event.preventDefault();
  });

  $("#final-guess-prompt-submit").on("click", function(event) {
    $('#final-guess-prompt').modal('hide');
    if(isReporter) $("#reporter-final-answer").modal('show');
    else window.location = '/end-group-task';
    event.preventDefault();
  });

  $("#final-guess-submit").on("click", function(event) {
    $("#final-result").val(f($("#final-guess").val()));
    $("#optimization-final-form").submit();
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
        Type a number and hit enter.
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
          <button class="btn btn-lg btn-primary" id="submit-guess" type="submit">Enter</button>
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
      <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#review-instructions" type="button">Review instructions</button>
      </div>
    </div>
  </div>

</div>

<div class="modal fade" id="individual-prompt">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center">
        Your next guess is your final answer. Remember, it is only this final
        guess that matters for your score. Based on your previous {{ $maxResponses }} guesses,
        type the number that you think will result in the biggest value.
        </h4>
      </div>
      <div class="modal-body text-center">
        <button class="btn btn-lg btn-primary pull-right" id="ok-final" data-dismiss="modal" type="button">Ok</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


@include('layouts.includes.optimization-group-final-answer-prompt')
@include('layouts.includes.optimization-group-reporter-final-answer')
@include('layouts.includes.optimization-group-instructions')
@include('layouts.includes.gather-reporter-modal')

<form action="/optimization-group-final" id="optimization-final-form" style="display:none;" method="post">
          {{ csrf_field() }}
          <div class="form-group">
            <input class="form-control" type="text" name="final_guess" id="final-guess">
            <input type="hidden" name="final_result" id="final-result">
            <input type="hidden" name="function" id="final-function" value="{{ $function }}">
          </div>
</form>

@stop
