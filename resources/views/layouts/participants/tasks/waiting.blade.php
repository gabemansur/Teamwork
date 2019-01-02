@extends('layouts.master')

@section('content')
<script>
  $(document).ready(function() {
    setInterval(function(){
      $.get( "/check-task-completion", function( result ) {
        console.log(result);
        if(result == '1') window.location="/end-group-task";
      });
    }, 1000);
  });
</script>
<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      @if(\Session::get('waitingMsg'))
        <h3>{{ \Session::get('waitingMsg') }}</h3>
      @else
        <h3>
          For this part of the task, you'll be working on the Reporter's laptop.
        </h3>
        <h3>
          When the task is completed, you'll automatically advance to the next section.
        </h3>
      @endif
      <!--
      <div class="text-center">
        <a class="btn btn-lg btn-primary"
           role="button"
           href="/end-group-task">Continue
        </a>
      </div>
      -->
    </div>
  </div>
</div>
@stop
