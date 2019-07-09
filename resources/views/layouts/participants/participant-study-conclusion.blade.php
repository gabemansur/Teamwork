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
          This concludes the study. Thanks again!
        </h4>
      @endif

      @if($score)
        <h2>Next Steps</h2>
        <h4>
          Having completed the online tasks, you are now eligible to take part
          in the group tasks at the Harvard Decision Science Lab.
        </h4>
        <h4>
          To participate in the trial, you need to commit to visiting the lab
          twice. On your first visit you will be paid $25. On the second visit,
          you will be paid a further $35, along with a bonus based on your performance.
        </h4>
        <h4>
          To sign up for sessions, look for [SONA STUDY NAME]: {{ $score }}
        </h4>
      @endif
    </div>
  </div>
</div>
@stop
