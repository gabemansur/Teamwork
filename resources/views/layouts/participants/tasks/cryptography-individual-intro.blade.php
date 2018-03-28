@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/timer.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')
<script>
$( document ).ready(function() {

});

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-10 offset-md-1 text-center inst">
      <h3>
        The letters A-J have been randomly mapped to
        the numbers 0-9. The goal for your group is to decipher this
        mapping in the minimum number of "trials".
      </h3>
      <h3>
        A trial involves three steps:
      </h3>
      <h3>
        <ol>
          <li>
            <em>Propose an Equation:</em>
            the group nominates the left-hand side of an equation, using
            letters, addition and subtraction: e.g. "A+B". The group then
            receives an answer, e.g. "A+B=EC"
          </li>
          <li>
            <em>Propose a Hypothesis:</em>
            the group makes a guess as to one element of the mapping, e.g. "E=1".
            The group then gets confirmation about whether their guess is
            correct: e.g. "E=1 is TRUE"
          </li>
          <li>
            <em>Guess Full Mapping:</em>
            at the end of each trial, you will guess at the whole
            mapping. If you are correct, the task is complete. Otherwise a new
            trial begins. You will have {{ $maxResponses }} trials to
            complete the task.
          </li>
        </ol>
      </h3>
      <div class="text-center">
        <a class="btn btn-lg btn-primary"
           role="button"
           href="/cryptography">Continue
        </a>
      </div>
    </div>
  </div>
</div>
@stop
