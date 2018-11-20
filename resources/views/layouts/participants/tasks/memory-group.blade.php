@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/memory.js') }}"></script>
  <script src="{{ URL::asset('js/image-preloader.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')

<script>

    var tests = <?php echo  $enc_tests; ?>;
    $( document ).ready(function() {

      var preloadImages = <?= json_encode($imgsToPreload); ?>
      // Preload all images
      preload(preloadImages);

      var callback = function() {
        $("#memory-form").submit();
      };
      var memory = new Memory(tests, callback);
      memory.begin();

      $('.memory-nav').on('click', function(event) {
        if(memory.hasPopup()) {
          event.stopImmediatePropagation();
          return;
        }
        memory.advance();
        event.preventDefault();
      });

      $('.choose-mem-review-type').on('click', function(event) {
        memory.setGroupTestReviewChoice($(this).data('type'));
        memory.advance();
        event.preventDefault();
      });

      $('.switch-mem-review-type').on('click', function(event) {
        //memory.setGroupTestReviewChoice($(this).data('type'));
        memory.switchMemReviewType($(this).data('type'));
        event.preventDefault();
      });

      $('.select-all').on('change', function(event) {
        var response = $(this).attr('name');
        $('.no-selection[name="'+response+'"]').prop('checked', false);
      });

      // Target images
      $('.target-nav').on('click', function(event) {
        memory.navImgTarget($(this).attr('name'));
        event.preventDefault();
      });

      $('.word-nav').on('click', function(event) {
        memory.navWordTarget($(this).attr('name'));
        event.preventDefault();
      });

      $(document).keydown(function(event) {
        var key = event.key;
        if((key == 1 || key == 2 || key == 3) && ($(".memory-img").is(":visible") || $(".story-choices").is(":visible"))) memory.advanceImageTest(key);
      });

      $("#popup-continue").on('click', function(event) {
        $("#popup").modal('toggle');
        //memory.advance();
      })
    });

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      <form id="memory-form" action="/memory-individual" method="post">
        {{ csrf_field() }}
        @foreach($tests as $key => $test)

          @if($test['task_type'] == 'intro')

          @endif {{-- End if type = intro --}}

          @if($test['task_type'] == 'mixed')

            @foreach($test['blocks'] as $b_key => $block)

              @if($block['type'] == 'text')
                <div class="memory memory-text text" id="memory_{{ $key }}_{{ $b_key }}">
                  @if(isset($block['header']))
                    <h2 class="text-primary">{{ $block['header'] }}</h2>
                  @endif
                  @foreach($block['text'] as $text)
                    <h4>{!! $text !!}</h4>
                  @endforeach
                  <div class="text-center">
                    <input class="btn btn-primary memory-nav btn-lg"
                           type="button" name="next"
                           id="continue_{{ $key }}_{{ $b_key }}"
                           value="Continue">
                  </div>
                </div>
              @endif {{-- End if blocktype = text --}}

              @if($block['type'] == 'review_choice')
                <div class="memory memory-text text" id="memory_{{ $key }}_{{ $b_key }}">
                  @if(isset($block['header']))
                    <h2 class="text-primary">{{ $block['header'] }}</h2>
                  @endif
                  @foreach($block['text'] as $text)
                    <h4>{!! $text !!}</h4>
                  @endforeach
                  <div class="row">
                    @foreach($block['choices'] as $choice)
                    <div class="col-md-4">
                      <input class="btn btn-block btn-{{$choice['color']}} choose-mem-review-type"
                             type="button" name="next"
                             data-type="{{ $choice['type'] }}"
                             value="{{ ucfirst($choice['type']) }}">
                    </div>
                    @endforeach
                  </div>
                </div>
              @endif {{-- End if blocktype = review_choice --}}

              @if($block['type'] == 'mixed_review')
                <div class="memory memory-text text" id="memory_{{ $key }}_{{ $b_key }}">
                  <div class="float-right text-primary timer" id="timer_{{ $key }}_{{ $b_key }}"></div><br>
                  @if(isset($block['header']))
                    <h2 class="text-primary">{{ $block['header'] }}</h2>
                  @endif
                  @foreach($block['text'] as $text)
                    <h4>{!! $text !!}</h4>
                  @endforeach

                  <ul class="nav nav-tabs">
                    @foreach($block['types'] as $memType)
                      <li class="nav-item">
                        <a class="nav-link switch-mem-review-type" data-type="{{ $memType['type'] }}" href="#">{{ ucfirst($memType['type']) }}</a>
                      </li>
                    @endforeach
                  </ul>

                  <div class="row">
                    @foreach($block['types'] as $memType)
                      <div id="{{ $memType['type'] }}_{{ $key }}_{{ $b_key }}" class="memory-review mixed-mem-targets">

                        @if($memType['type'] == 'images')
                          @foreach($memType['targets'] as $img_key => $img)
                            <img class="target-img target img-target-{{ $img_key }}" src="{{ $memType['directory'].$img }}">
                          @endforeach
                          <div class="text-center mt-lg-2">
                            <input class="btn btn-primary target-nav btn-lg" type="button" name="back" id="back" value="Change Perspective">
                          </div>
                        @endif {{-- end target images --}}

                        @if($memType['type'] == 'words')
                          @foreach($memType['targets'] as $word_key => $word)
                            <div class="target-word target word-target-{{ $word_key }}">
                              <h1 class="text-center">{{ $word }}</h1>
                            </div>
                          @endforeach
                          <div id="instr_nav" class="text-center">
                            <input class="btn btn-primary word-nav back btn-lg" type="button" name="back" id="back" disabled="true", value="Previous Word">
                            <input class="btn btn-primary word-nav next btn-lg" type="button" name="next" id="next" value="Next Word"><br />
                          </div>
                        @endif {{-- end target words --}}

                        @if($memType['type'] == 'stories')
                          @foreach($memType['targets'] as $num => $target)
                            <h4 class="text-left mt-lg-4">{{ $num + 1 }}: {{ $target }}</h4>
                            <hr>
                          @endforeach
                        @endif {{-- end target stories --}}

                      </div>
                    @endforeach
                  </div>
                </div>
              @endif {{-- End if blocktype = mixed_review --}}

            @endforeach {{-- End foreach block --}}
          @endif {{-- End if type = mixed --}}

        @endforeach {{-- End foreach test --}}

      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="popup" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center" id="popup-text"></h4>
      </div>
      <div class="modal-body text-center">
          <button class="btn btn-lg btn-primary" id="popup-continue" type="button">Continue</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop
