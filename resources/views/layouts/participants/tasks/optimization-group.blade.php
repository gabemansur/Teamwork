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

});

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-4 offset-md-4 text-center">
      <h3>
        Enter your group's guess below.
      </h3>
      <form name="optimization" action="/optimization-group" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="function" value="{{ $function }}">
        <div class="form-group">
          <input type="number" class="form-control" name="guess" id="guess" min="0" max="300">
        </div>
        <div class="text-center">
          <button class="btn btn-lg btn-primary" id="submit-guess" type="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>

@stop
