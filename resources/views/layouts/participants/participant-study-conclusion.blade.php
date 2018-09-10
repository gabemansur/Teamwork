@extends('layouts.master')


@section('content')
<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      @if($code)
        <h4>Your participation code is:<br>
          <span class="text-success">{{ $code }}</span>
        </h4>
        <h4>
          Nobody else has this unique code. Please enter the code back in MTurk so
          that we can verify you completed the tasks and we can pay you.
        </h4>
        <h4>
          Thanks again!
        </h4>
      @endif
    </div>
  </div>
</div>
@stop
