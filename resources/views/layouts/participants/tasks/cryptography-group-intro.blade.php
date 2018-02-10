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
        This is a group task.
      </h3>
      <h3>
        On the next page etc...
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
