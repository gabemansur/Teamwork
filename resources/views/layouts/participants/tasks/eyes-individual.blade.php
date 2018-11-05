@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/instructionPaginator.js') }}"></script>
  <script src="{{ URL::asset('js/image-preloader.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')
<script>
$( document ).ready(function() {

  $(".alert-danger").hide();
  $("#next").on("click", function(event) {
    //Form validation
    $(".alert-danger").hide();
    $('.form-check-input:visible').each(function(){
      console.log($(this).attr('name'));
      name = $(this).attr('name');
      if ($("input:radio[name=" + name + "]:checked").length == 0) {
        $(".alert-danger").show();
        event.stopImmediatePropagation();
        return;
      }
    })
    event.preventDefault();
  });

  instructionPaginator(function(){$("#eyes-responses").submit()});

  var preloadImages = <?= json_encode($imgsToPreload); ?>

  // Preload all images
  preload(preloadImages);
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
                    <input class="form-check-input form-check-large" type="radio" name="{{ $key }}"  value="{{ $choice }}">
                    <label class="form-check-label" for="exampleRadios1">
                      <a class="text-dark" href="https://www.dictionary.com/browse/{{ $choice }}?s=t" target="_blank">{{ $choice }}</a>
                    </label>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        @endforeach
      </form>
      <div id="instr_nav" class="text-center mt-md-4 mb-md-4">
        <div class="alert alert-danger" role="alert">
          Please make a choice before continuing.
        </div>
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
        <span class="text-primary text-lg" id="pagination-display">
          <span id="curr-page">1</span> / {{ count($tests) }}
        </span>
      </div>
    </div>
  </div>
</div>

@stop
