@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/memory.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')

<script>

    var tests = <?php echo  $enc_tests; ?>;
    $( document ).ready(function() {
      console.log(tests);
      var callback = function() {

        $("#memory-form").submit();

      };
      var memory = new Memory(tests, callback);
      memory.begin();

      $('.memory-nav').on('click', function(event) {
        memory.advance();
        event.preventDefault();
      });

      // Target images
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
      <form id="memory-form" action="/memory-individual" method="post">
        {{ csrf_field() }}
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
                  <div class="row">
                    <div class="col-md-2 offset-md-3"><h2>1</h2></div>
                    <div class="col-md-2"><h2>2</h2></div>
                    <div class="col-md-2"><h2>3</h2></div>
                  </div>
                </div>
              @endif {{-- End if blocktype = practice_test --}}

              @if($block['type'] == 'test')
                <div class="memory test" id="memory_{{ $key }}_{{ $b_key }}">
                  <h2>{{ $block['prompt'] }}</h2>
                  <h2>Type [1], [2], or [3]</h2>
                  <img src="{{ $test['directory'].$block['img'] }}">
                  <div class="row">
                    <div class="col-md-2 offset-md-3"><h2>1</h2></div>
                    <div class="col-md-2"><h2>2</h2></div>
                    <div class="col-md-2"><h2>3</h2></div>
                  </div>
                  <input type="hidden" name="response_{{ $key }}_{{ $b_key }}"
                         id="response_{{ $key }}_{{ $b_key }}">
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

          @if($test['task_type'] == 'words')
            @foreach($test['blocks'] as $b_key => $block)

              @if($block['type'] == 'review')
                <div class="memory memory-review review" id="memory_{{ $key }}_{{ $b_key }}">
                  <h4>{{ $block['text'] }}</h4>
                  @foreach($block['targets'] as $word_key => $word)
                    <div class="target-word target target-{{ $word_key }}">
                      <h1 class="text-center">{{ $word }}</h1>
                    </div>
                  @endforeach
                  <div class="text-center mt-lg-2">
                    <input class="btn btn-primary target-nav target-nav-back btn-lg" type="button" name="back" id="back" value="&#8678; Back">
                    <input class="btn btn-primary target-nav target-nav-next btn-lg" type="button" name="next" id="next" value="Next &#8680;">
                  </div>

                </div>
              @endif {{-- End if blocktype = review --}}

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

              @if($block['type'] == 'test' || $block['type'] == 'practice_test')
                <div class="memory test" id="memory_{{ $key }}_{{ $b_key }}">
                  <h2>{{ $block['prompt'] }}</h2>
                  <h2>Select all that apply, then click "Next"</h2>
                  <div class="row justify-content-md-center word-choices">
                    @foreach($block['choices'] as $c_key => $choice)
                      <div class="col-md-3 form-group">
                        <h2>
                        <label
                               for="response_{{ $key }}_{{ $b_key }}">
                               {{ $choice }}
                        </label><br>
                        <input class="checkbox" type="checkbox"
                               name="response_{{ $key }}_{{ $b_key }}[]"
                               value="{{ $c_key + 1 }}">
                        </h2>
                      </div>
                    @endforeach
                  </div>
                  <div class="text-center">
                    <input class="btn btn-primary memory-nav btn-lg"
                           type="button" name="next"
                           id="continue_{{ $key }}_{{ $b_key }}"
                           value="Next">
                  </div>
                </div>
              @endif {{-- End if blocktype = test --}}

            @endforeach {{-- End for each block --}}
          @endif {{-- End if type = words --}}

        @endforeach {{-- End foreach test --}}

      </form>
    </div>
  </div>
</div>
@stop
