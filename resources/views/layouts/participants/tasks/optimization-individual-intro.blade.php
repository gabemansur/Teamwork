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
    <div class="col-md-12 text-center">
      <h3>
        Optimization Task
      </h3>
      <h3>
        Your task is to try to find the number that generates the biggest
        possible output. You each have [6] guesses, which you can enter
        into your own laptop. A guess can be any number between [0] and [300].
      </h3>
      <h3>
        After you enter your guess, the computer will give you back a number.
        There is a systematic relationship between the number you guess, and
        the number you receive, but the relationship will often be difficult
        for you to understand. Every time you type in the same number, the
        number you receive will be similar (but there may also be a bit of
        randomness added in). Usually, numbers that are close to each other
        will receive outputs.
      </h3>
      <div class="text-center">
        <a class="btn btn-lg btn-primary"
           role="button"
           href="/optimization-individual">Continue
        </a>
      </div>
    </div>
  </div>
</div>
@stop
