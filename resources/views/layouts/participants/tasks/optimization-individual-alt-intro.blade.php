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
        Now you'll perform the task again. Enter numbers between 0 and 300.
        This time, there's a different relationship between the number you
        enter and the output you receive.
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
