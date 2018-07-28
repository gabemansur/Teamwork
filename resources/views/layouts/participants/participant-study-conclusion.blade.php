@extends('layouts.master')


@section('content')
<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      @foreach($conclusionContent as $content)
        @if($content['type'] == 'header')
          <h2 class="text-primary">{{ $content['content'] }}</h2>
        @elseif($content['type'] == 'sub-header')
          <h4>{{ $content['content'] }}</h4>
        @elseif($content['type'] == 'paragraph')
          <p>{{ $content['content'] }}</p>
        @endif
      @endforeach
      @if($code)
        <h4>Your participation code is:<br>
          <span class="text-success">{{ $code }}</span>
        </h4>
      @endif
    </div>
  </div>
</div>
@stop
