@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/cryptography.js') }}"></script>
  <script src="{{ URL::asset('js/timer.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')
<script>

var mapping = <?php echo  $mapping; ?>;
var maxResponses = {{ $maxResponses }};

var trialStage = 1;
var trials = 1;

$( document ).ready(function() {

  $("#alert").hide();
  $("#hypothesis").hide();
  $("#guess-full-mapping").hide();
  $("#task-end").hide();

  var crypto = new Cryptography(mapping);


  initializeTimer(600, function() {
    $("#crypto-form").hide();
    $("#task-end").show();
    $("#success").hide();
    $("#fail").show();
    $('#time-up').modal();
  });

  $("#ok-time-up").on('click', function(event) {
    $("#task-result").val(0);
    $("#cryptography-end-form").submit();
    event.preventDefault();
  })

  $("#submit-equation").on("click", function(event) {

    $("#alert").hide();

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
        $("#answers").append('<h5 class="answer">' + equation + ' = ' + answer + '</h5>');
        $("#equation").val('');
        $('#hypothesis-left option:eq(0)').prop('selected', true);
        $('#hypothesis-right option:eq(0)').prop('selected', true);
        $("#hypothesis").slideDown();
        $("#propose-equation").slideUp();

        $.post("/cryptography", {
            _token: "{{ csrf_token() }}",
            prompt: "Propose Equation",
            guess: equation + '=' + answer
          } );
      }

      catch(e) {
        trialStage = 1;
        $("#alert").html(e);
        $("#alert").show();
      }
    }

    else if(trialStage == 2) {
      trialStage++;
      var result = crypto.testHypothesis($("#hypothesis-left").val(), $("#hypothesis-right").val());
      var output = (result) ? "true" : "false";
      $("#hypothesis-result").append('<h5>' + $("#hypothesis-left").val() + " = " + $("#hypothesis-right").val() + " is " + output + '</h5>');
      $("#hypothesis").slideUp();
      $("#guess-full-mapping").slideDown();

      $.post("/cryptography", {
          _token: "{{ csrf_token() }}",
          prompt: "Propose Hypothesis",
          guess: $("#hypothesis-left").val() + '=' + $("#hypothesis-right").val() + ' : ' + output
        } );
    }

    else if(trialStage == 3) {
      trialStage = 1;
      var result = true;
      var guessStr = '';
      var mappingList = '';

      $(".full-mapping").each(function(i, el){
        mappingList += '<span>' + $(el).attr('name') + ' = ' + $(el).val() + '</span>';
        guessStr += $(el).attr('name') + '=' + $(el).val() + ',';
        if(crypto.testHypothesis($(el).attr('name'), $(el).val()) == false) result = false;
      });

      $("#mapping-list").html(mappingList);
      $.post("/cryptography", {
          _token: "{{ csrf_token() }}",
          prompt: "Guess Full Mapping",
          mapping: JSON.stringify(mapping),
          guess: guessStr
        } );

      if(result) {
        $("#crypto-ui").hide();
        $("#task-end").show();
        $("#fail").hide();
        $("#success").show();
        $("#task-result").val(1);
      }
      else if(trials < maxResponses) {
        trials++;
        $("#trial-counter").html(trials);
        $("#mapping-result").html('Your guess of the full mapping was incorrect.');
        $("#mapping-result").show();
        $("#guess-full-mapping").slideUp();
        $("#propose-equation").slideDown();
      }
      else {
        $("#crypto-ui").hide();
        $("#task-end").show();
        $("#success").hide();
        $("#fail").show();
      }
    }

    event.preventDefault();
  });


});

</script>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="float-right text-primary" id="timer"></div>
      <h3 class="mb-lg-4">
        Cryptography Task
      </h3>
    </div>
  </div>
  <div class="row" id="crypto-ui">
      <div class="col-md-5 text-center">
      <h5>Trial <span id="trial-counter">1</span> of {{ $maxResponses }}</h5>
      <form name="cryptography" id="crypto-form">

        <div id="propose-equation">
          <h4 class="text-primary" id="mapping-result"></h4>
          <h4 class="text-equation">Propose an equation</h4>
          <h5>Enter the left-hand side of an equation, using letters, addition and
            subtraction: e.g. “A+B”. Please only use the letters A-J plus '+' and '-'.
          </h5>
          <div id="alert" class="alert alert-danger" role="alert"></div>
          <div class="form-group">
            <input type="text" class="form-control form-control-lg" name="equation" id="equation">
          </div>
        </div>

        <div id="hypothesis">
          <h4 class="text-hypothesis">Propose a hypothesis</h4>
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
        </div>
        <!-- <div class="text-primary" id="hypothesis-result"></div> -->

        <div id="guess-full-mapping">
              <h4 class="text-guess">Guess the full letters</h4>
              <h5>
                Use the drop-downs to guess a value for each letter.
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

        <div class="text-center">
          <button class="btn btn-lg btn-primary" id="submit-equation" type="submit">Submit</button>
        </div>
        <!-- <div id="answers"></div> -->
      </form>
      </div>
      <div class="col-md-3 crypto-result">
        <h4 class="text-equation">Equations</h4>
        <div id="answers"></div>
      </div>

      <div class="col-md-2 crypto-result">
        <h4 class="text-hypothesis">Hypotheses</h4>
        <div id="hypothesis-result"></div>
      </div>

      @if(Auth::user()->role_id == 3)
        <div class="col-md-2 crypto-result">
          <h4 class="text-guess">Current Guesses</h4>
          <div id="mapping-list">
            <span>A = ---</span>
            <span>B = ---</span>
            <span>C = ---</span>
            <span>D = ---</span>
            <span>E = ---</span>
            <span>F = ---</span>
            <span>G = ---</span>
            <span>H = ---</span>
            <span>I = ---</span>
            <span>J = ---</span>
          </div>
        </div>
      @endif
    </div>
    <div class="row" id="task-end">
      <div class="col-md-8 offset-md-2">
        <form action="/cryptography-end" id="cryptography-end-form" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="task_result" id="task-result" value="0">
          <h3 class="text-center" id="success">Congratulations, you solved the task!</h3>
          <h3 class="text-center" id="fail">This is the end of this task.</h3>
          <div class="text-center">
            <button class="btn btn-lg btn-primary" id="continue" type="submit">Continue</button>
          </div>
        </form>
      </div>
  </div>

  <div class="modal fade" id="time-up">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center">
          Your time is up. You will get points for your current guesses
          that are correct.
          </h4>
        </div>
        <div class="modal-body text-center">
          <button class="btn btn-lg btn-primary pull-right" id="ok-time-up" data-dismiss="modal" type="button">Ok</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->
@stop
