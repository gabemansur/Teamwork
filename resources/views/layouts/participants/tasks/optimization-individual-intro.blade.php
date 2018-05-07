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
      <h2 class="text-primary">Optimization Task</h2>
      <h3>
        The goal of this task is to try to find the number (between 0 and 300)
        that results in your computer returning the biggest possible value.
        You will have [6] guesses, which you enter into your own laptop.
        A guess can be any number between [0] and [300].
      </h3>
      <h3>
        After you enter your guess, the computer will give you back a number.
        There is a systematic relationship between the number you guess, and
        the number you receive, but the relationship may be difficult to
        understand. Every time you enter the same number, the output you
        receive will be similar (but there is some randomness added in).
        Usually, numbers that are close to each other will receive outputs.
      </h3>
      <h3>
        After your 6 guesses, you will be asked to enter the number that you
        believe gives the highest response.
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
