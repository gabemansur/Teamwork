@extends('layouts.master')


@section('content')
<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      @foreach($feedbackMessage as $msg)
        @if($msg['type'] == 'header')
          <h2 class="text-primary">{!! $msg['content'] !!}</h2>
        @elseif($msg['type'] == 'paragraph')
          <h4>{!! $msg['content'] !!}</h4>
        @endif
      @endforeach
      <form name="feedback-form" action="/study-feedback" method="post">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="feedback">
            If you have any feedback about the tasks, or experienced any difficulties,
            please note them here.
          </label>
          <textarea class="form-control" name="feedback" rows="3"></textarea>
        </div>
        <div class="text-center">
          <button class="btn btn-lg btn-primary" type="submit">Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>
@stop
