@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/timer.js') }}"></script>
  <script src="{{ URL::asset('js/cryptography.js') }}"></script>

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
        $("#answers").append('<h3>' + equation + ' = ' + answer + '</h3>');
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
      $("#hypothesis-result").append('<h4>' + $("#hypothesis-left").val() + " = " + $("#hypothesis-right").val() + " is " + output + '</h4>');
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

      $(".full-mapping").each(function(i, el){
        guessStr += $(el).attr('name') + '=' + $(el).val() + ',';
        if(crypto.testHypothesis($(el).attr('name'), $(el).val()) == false) result = false;
      });

      $.post("/cryptography", {
          _token: "{{ csrf_token() }}",
          prompt: "Guess Full Mapping",
          guess: guessStr
        } );

      if(result) {
        $("#crypto-form").hide();
        $("#task-end").show();
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
        $("#crypto-form").hide();
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
  <div class="row vertical-center">
    <div class="col-md-8 offset-md-2 text-center">
      <h3>
        Cryptography Task
      </h3>
      <h5>Trial <span id="trial-counter">1</span> of {{ $maxResponses }}</h5>
      <form name="cryptography" id="crypto-form">

        <div id="propose-equation">
          <h4 class="text-primary" id="mapping-result"></h4>
          <h4 class="text-primary">1. Propose an equation</h4>
          <h5>Enter the left-hand side of an equation, using letters, addition and
            subtraction: e.g. “A+B”. Please only use the letters A-J plus '+' and '-'.
          </h5>
          <div id="alert" class="alert alert-danger" role="alert"></div>
          <div class="form-group">
            <input type="text" class="form-control form-control-lg" name="equation" id="equation">
          </div>
        </div>

        <div id="hypothesis">
          <h4 class="text-primary">2. Propose a hypothesis</h4>
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
        <div class="text-primary" id="hypothesis-result"></div>

        <div id="guess-full-mapping">
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

        <div class="text-center">
          <button class="btn btn-lg btn-primary" id="submit-equation" type="submit">Submit</button>
        </div>
        <div id="answers"></div>
      </form>

      <div id="task-end">
        <form action="/cryptography-end" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="task_result" id="task-result" val="0">
          <h3 id="success">Congratulations, you solved the task!</h3>
          <h3 id="fail">This is the end of this task.</h3>
          <div class="text-center">
            <button class="btn btn-lg btn-primary" id="continue" type="submit">Continue</button>
          </div>
        </form>
      </div>

    </div>
  </div>

@stop
