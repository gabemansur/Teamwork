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

      $("#next").on('click', function(event) {
        $('.input:visible .form-check-input').each(function(){
          var name = $(this).attr("name");
          if ($("input:radio[name=" + name + "]:checked").length == 0) {
            $(".alert-danger").show();
            event.stopImmediatePropagation();
            return;
          }
        })

      });

      instructionPaginator(function(){
        $("#team-role-form").submit();
      });
    });

</script>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="pull-right text-primary" id="timer"></div>
    </div>
  </div>
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      <form id="team-role-form" action="/team-role" method="post">
        {{ csrf_field() }}


        @for($i = 1; $i <= count($scenarios); $i++)
          <div id="inst_{{ $i }}" class="inst">
            <div class="alert alert-secondary">
              Instructions: The scenario below describes a situation that may
              be encountered while working in a team.
              {{ count($scenarios[$i - 1]['responses']) }} potential responses
              to the situation are also listed.  Please read the scenario and
              indicate how effective each of the responses would be.  Some of
              these responses are better than others.
            </div>

            <table class="team-role table table-striped">
              <tr>
                <td class="blank"></td>
                @foreach($scenarios[$i - 1]['key'] as $key)
                  <th class="key rotate">
                    <div><span>{{ $key }}</span></div>
                  </th>
                @endforeach
                <td class="desc text-left">
                  <h6>Scenario {{ $i }}</h6>
                  <ul>
                    @foreach($scenarios[$i - 1]['desc'] as $desc)
                      <li>{{ $desc }}</li>
                    @endforeach
                  </ul>
                  <h6>
                    {{ $scenarios[$i - 1]['prompt'] }}
                  </h6>
                </td>
              </tr>

              @foreach($scenarios[$i - 1]['responses'] as $key => $response)
                <tr>
                  <td class="text-secondary">
                    {{ $key + 1 }}
                  </td>
                  @for($j = count($scenarios[$i - 1]['key']); $j > 0; $j--)
                    <td class="text-center input">
                    <!--  <div class="form-check form-check-inline"> -->
                        <input class="form-check-input" type="radio" name="scenario_{{ $i - 1 }}_response_{{ $key }}" value="{{ $j }}">
                    <!--   </div> -->
                    </td>
                  @endfor
                  <td class="text-left">
                    {{ $response['response'] }}
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
        @endfor
      </form>
      <div class="alert alert-danger">
        <h6>Please be sure to answer each question before continuing.</h6>
      </div>
      <div id="instr_nav" class="text-center">
        <!-- <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back"> -->
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
  </div>
</div>

@stop
