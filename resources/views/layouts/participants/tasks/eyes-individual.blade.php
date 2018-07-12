@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/instructionPaginator.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')
<script>
$( document ).ready(function() {
  instructionPaginator(function(){$("#eyes-responses").submit()});
});

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12">
      <form name="eyes-responses" id="eyes-responses" action="/rmet-individual" method="post">
        {{ csrf_field() }}
        @foreach($tests as $key => $test)
          <div id="inst_{{ $key + 1 }}" class="inst">
            <div class="text-center">
              <img class="eyes" src="{{ $dir.$test['img'] }}">
            </div>
            <div class="row mt-md-4">
              <div class="col-md-2 offset-md-5">
                @foreach($test['choices'] as $c_key => $choice)
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="{{ $key }}"  value="{{ $choice }}">
                    <label class="form-check-label" for="exampleRadios1">
                      {{ $choice }}
                    </label>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        @endforeach
      </form>
      <div id="instr_nav" class="text-center mt-md-4">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
  </div>
</div>


@stop
