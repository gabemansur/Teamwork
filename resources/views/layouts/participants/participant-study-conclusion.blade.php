@extends('layouts.master')


@section('content')
<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">

      @foreach($conclusionContent as $content)
        @if($content['type'] == 'header')
          <h2 class="text-primary">{!! $content['content'] !!}</h2>
        @elseif($content['type'] == 'sub-header')
          <h4>{!! $content['content'] !!}</h4>
        @elseif($content['type'] == 'paragraph')
          <h4>{!! $content['content'] !!}</h4>
        @endif
      @endforeach

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
        <h4>
          For randomization purposes, we have allocated you to a group.<br>
          You are in the <strong>{{ strtoupper($score) }}</strong> group.
        </h4>
        <div class="row">
          <div class="col-4 offset-4">
            <img src="/img/fruits/{{ $score }}.png" class="img-fluid">
          </div>
        </div>
        <h4>
          When you come to the lab we will ask you about your fruit, so please try to remember it.
        </h4>
      @endif

      @if($feedback)
        <h4>
          Click the button below to add any feedback or comments on this study. Even a short sentance is very helpful to us!
        </h4>
        <a class="btn btn-lg btn-success" href="/end-individual-task">Feedback</a>
      @endif


      @if($receiptSonaId)
        <a class="btn btn-lg btn-success" href="http://dashboard.harvarddecisionlab.org/new-receipt/?i={{ base64_encode($receiptSonaId) }}">Sign Your Digital Receipt</a>
      @endif
    </div>
  </div>
</div>
@stop
