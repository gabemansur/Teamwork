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

      $(".alert-danger").hide();

      $("#submit").on('click', function(event) {
        $('.input:visible .form-check-input').each(function(){
          var name = $(this).attr("name");
          if ($("input:radio[name=" + name + "]:checked").length == 0) {
            $(".alert-danger").show();
            event.preventDefault();
            return;
          }
        })

      });



      instructionPaginator(function(){});
    });

</script>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <h5>
        Describe yourself as you generally are now, not as you wish to be in
        the future. Describe yourself as you honestly see yourself, in relation
        to other people you know of the same sex as you are, and roughly your
        same age. So that you can describe yourself in an honest manner, your
        responses will be kept in absolute confidence. Indicate for each
        statement whether it is
      </h5>
      <h5>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <ol class="text-left">
              <li>Very true</li>
              <li>Somewhat true</li>
              <li>Neither true nor untrue</li>
              <li>Moderately true</li>
              <li>Very true</li>
            </ol>
          </div>
        </div>
      </h5>
      <form id="big-five-form" action="/big-five" method="post">
        {{ csrf_field() }}

            @for($i = 0; $i < count($statements); $i++)
              @if($i == 0 || $i % 10 == 0)
                <div id="inst_{{ intdiv($i, 10) + 1}}" class="inst">
                  <h5 class="text-primary">
                    {{ intdiv($i, 10) + 1 }} / {{ count($statements) / 10 }}
                  </h5>
                  <table class="table table-striped table-sm">
                    <tr>
                      <td class="blank"></td>
                      <th class="key">
                        <div><span>Very<br>True</span></div>
                      </th>
                      <th class="key">
                        <div><span>Somewhat<br>True</span></div>
                      </th>
                      <th class="key">
                        <div><span>Neither true<br>nor untrue</span></div>
                      </th>
                      <th class="key">
                        <div><span>Moderately<br>Untrue</span></div>
                      </th>
                      <th class="key">
                        <div><span>Very<br>Untrue</span></div>
                      </th>
                    </tr>
              @endif
                      <tr>
                        <td class="text-left">
                          {{ $statements[$i]['statement'] }}
                        </td>
                        @for($j = 5; $j > 0; $j--)
                          <td class="text-center input">
                              <input class="form-check-input" type="radio" name="{{ $statements[$i]['number'] }}" value="{{ $j }}">
                          </td>
                        @endfor
                      </tr>
              @if(($i + 1) % 10 == 0)
                  </table>
                </div>
              @endif
            @endfor
          <div id="inst_{{ intdiv(count($statements), 10) + 1 }}" class="inst mb-lg-4">
            <h3>
              You may submit your answers for this test, or use the back button
              to review and change your answers.
            </h3>
            <input class="btn btn-primary btn-lg" type="submit" value="Submit Answers" id="submit"><br />
          </div>
      </form>
      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
    </div>
  </div>
</div>

@stop
