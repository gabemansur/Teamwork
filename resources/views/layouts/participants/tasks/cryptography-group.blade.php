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

$( document ).ready(function() {

  var crypto = new Cryptography(mapping);

  $("#submit-equation").on("click", function(event) {
    var equation = $("#equation").val();
    var answer = crypto.parseEquation(equation);
    $("#answers").append('<h3>' + equation + ' = ' + answer);

    $("#equation").val('');
    
    event.preventDefault();
  });
});

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-4 offset-md-4 text-center">
      <h3>
        Cryptography Task
      </h3>
      <h5>Enter the left-hand side of an equation, using letters, addition and
        subtraction: e.g. “A+B”. Please only use the letters A-J plus '+' and '-'.
      </h5>
      <form name="cryptography">
        <div class="form-group">
          <input type="text" class="form-control form-control-lg" name="equation" id="equation">
        </div>
        <div class="text-center">
          <button class="btn btn-lg btn-primary" id="submit-equation" type="submit">Submit</button>
        </div>
      </form>
      <div id="answers"></div>
    </div>
  </div>

@stop
