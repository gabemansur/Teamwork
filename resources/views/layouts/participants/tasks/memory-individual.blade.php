@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/memory.js') }}"></script>
@stop

@section('content')

<script>

    var tests = <?php echo  $enc_tests; ?>;
    $( document ).ready(function() {
      console.log(tests);
      var memory = new Memory(tests);
      memory.begin();

      $('.memory-nav').on('click', function(event) {
        console.log('advance');
        memory.advance();
        event.preventDefault();
      });

      // Target images
      $('.target').hide();
      $('.target-nav').on('click', function(event) {
        memory.navTarget($(this).attr('name'));
        event.preventDefault();
      });

      $(document).keydown(function(event) {
        var key = event.key;
        if(key == 1 || key == 2 || key == 3) memory.advanceImageTest(key);
      });
    });

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      @foreach($tests as $key => $test)

        @if($test['task_type'] == 'images')

          @foreach($test['blocks'] as $b_key => $block)

            @if($block['type'] == 'review')
              <div class="memory memory-review review" id="memory_{{ $key }}_{{ $b_key }}">
                <h4>{{ $block['text'] }}</h4>
                @if(count($block['targets']) == 1)
                  <img src="{{ $test['directory'].$block['targets'][0] }}">
                  <div class="text-center mt-lg-2">
                    <input class="btn btn-primary memory-nav btn-lg mt-lg-4"
                           type="button" name="next"
                           id="continue_{{ $key }}_{{ $b_key }}"
                           value="Continue">
                  </div>
                @else
                  @foreach($block['targets'] as $img_key => $img)
                    <img class="target-img target target-{{ $img_key }}" src="{{ $test['directory'].$img }}">
                  @endforeach

                  <div class="text-center mt-lg-2">
                    <input class="btn btn-primary target-nav target-nav-back btn-lg" type="button" name="back" id="back" value="&#8678; Back">
                    <input class="btn btn-primary target-nav target-nav-next btn-lg" type="button" name="next" id="next" value="Next &#8680;">
                  </div>
                @endif {{-- End multiple images --}}
              </div>
            @endif {{-- End if blocktype = review --}}

            @if($block['type'] == 'practice_test')
              <div class="memory test practice-test" id="memory_{{ $key }}_{{ $b_key }}">
                <h2>{{ $block['prompt'] }}</h2>
                <h2>Type [1], [2], or [3]</h2>
                <img src="{{ $test['directory'].$block['img'] }}">
              </div>
            @endif {{-- End if blocktype = practice_test --}}

            @if($block['type'] == 'test')
              <div class="memory test" id="memory_{{ $key }}_{{ $b_key }}">
                <h2>{{ $block['prompt'] }}</h2>
                <img src="{{ $test['directory'].$block['img'] }}">
                <input type="hidden" name="response_{{ $key }}_{{ $b_key }}"
                       id="selection_{{ $key }}_{{ $b_key }}">
              </div>
            @endif {{-- End if blocktype = test --}}

            @if($block['type'] == 'text')
              <div class="memory memory-text text" id="memory_{{ $key }}_{{ $b_key }}">
                <h2>{{ $block['text'] }}</h2>
                <div class="text-center">
                  <input class="btn btn-primary memory-nav btn-lg"
                         type="button" name="next"
                         id="continue_{{ $key }}_{{ $b_key }}"
                         value="Continue">
                </div>
              </div>
            @endif {{-- End if blocktype = text --}}

          @endforeach {{-- End foreach block --}}
        @endif {{-- End if type = images --}}
      @endforeach {{-- End foreach test --}}

    </div>
  </div>
</div>
@stop
