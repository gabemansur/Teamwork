@extends('layouts.master')

@section('content')

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      <h3>
        You have completed the {{ $taskName }}.
      </h3>
      @if($result === false)
        <h3>
          Your results are being evaluated by the researchers.
        </h3>
      @else
        <h3>
          You will contribute {{ $result }} points to your
          group's total points for this task.
        </h3>
      @endif
      <div class="text-center">
        <a class="btn btn-lg btn-primary"
           role="button"
           href="/end-individual-task">Continue
        </a>
      </div>
    </div>
  </div>
</div>
@stop
