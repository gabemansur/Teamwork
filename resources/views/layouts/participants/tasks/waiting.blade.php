@extends('layouts.master')

@section('content')

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      @if(\Session::get('waitingMsg'))
        <h3>{{ \Session::get('waitingMsg') }}</h3>
      @else
        <h3>
          Please wait for the other members of your group to catch up!
        </h3>
        <h3>
          When all the members are ready, press "continue".
        </h3>
      @endif
      <div class="text-center">
        <a class="btn btn-lg btn-primary"
           role="button"
           href="/end-group-task">Continue
        </a>
      </div>
    </div>
  </div>
</div>
@stop
