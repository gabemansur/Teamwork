@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/timer.js') }}"></script>
  <script src="{{ URL::asset('js/teamRolePaginator.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')

<script>

    var scenario = 1;

    $( document ).ready(function() {

      $(".alert-danger").hide();

      var timer = initializeTimer(300, function(){
        $("#timerComplete").modal();
      });

      instructionPaginator(function(){
        $(".container").hide();
        $("#team-role-responses")[0].submit();
      });

      $("#next").on('click', function(event) {
        /* Form validation
        $('.input:visible .form-check-input').each(function(){
          var name = $(this).attr("name");
          if ($("input:radio[name=" + name + "]:checked").length == 0) {
            $(".alert-danger").show();
            event.stopImmediatePropagation();
            return;
          }
        })
        */

        // If next is clicked they are now on a scenario (because they are seeing a ul)
        if($("ul").is(":visible")) {

          if(scenario == 1) {
            $("#scenario1Complete").modal();
            clearInterval(timer);
            event.stopImmediatePropagation();
          }

        }

        event.preventDefault();
      });

      $("#timer-complete").on('click', function(event){

        if(scenario == 1) {
          scenario++;
          goToPage(2); // The page that you want them to move on from
          $(".inst").hide();
          $("#next").click();
          $("#timerComplete").modal('toggle');
          $(".modal-title").html('Your time is up. You must submit your answers now.');
          initializeTimer(540, function(){
            $("#timerComplete").modal();
          });
        }

        else {
          $("#team-role-responses")[0].submit();
        }

        event.preventDefault();
      });

      $("#next-scenario").on('click', function(event){
        if(scenario == 1) {
          scenario++;
          goToPage(2); // The page that you want them to move on from
          $(".inst").hide();
          $("#next").click();
          $("#scenario1Complete").modal('toggle');
          initializeTimer(540, function(){
            $("#timerComplete").modal();
          });
        }

        event.preventDefault();
      });

    });

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      <div class="float-right text-primary" id="timer"></div><br>
      <form id="team-role-responses" name="team-role-responses" action="/team-role" method="post">
        {{ csrf_field() }}


        @for($i = 1; $i <= count($scenarios); $i++)

          <div id="inst_{{ $i * 2 - 1 }}" class="inst scenario">
            <div class="alert alert-secondary">
              Instructions: The scenario below describes a situation that may
              be encountered while working in a team.
              {{ count($scenarios[$i - 1]['responses']) }} potential responses
              to the situation are also listed.  Please read the scenario and
              indicate how effective each of the responses would be.  Some of
              these responses are better than others.
            </div>
            <h4>Scenario {{ $i }}</h4>
            <ul class="text-left">
              @foreach($scenarios[$i - 1]['desc'] as $desc)
                <li>{{ $desc }}</li>
              @endforeach
            </ul>
          </div>
          <div id="inst_{{ $i * 2 }}" class="inst responses">
            <h3 class="text-center">Scenario {{ $i }}</h2>
            <table class="team-role table table-striped table-sm">
              <tr>
                <td class="blank"></td>
                <td class="blank"></td>
                @foreach($scenarios[$i - 1]['key'] as $key)
                  <th class="key">
                    <div><span>{{ $key }}</span></div>
                  </th>
                @endforeach
              </tr>

              @foreach($scenarios[$i - 1]['responses'] as $key => $response)
                <tr>
                  <td class="text-secondary">
                    {{ $key + 1 }}
                  </td>
                  <td class="text-left">
                    {{ $response['response'] }}
                  </td>
                  @for($j = count($scenarios[$i - 1]['key']); $j > 0; $j--)
                    <td class="text-center input">
                    <!--  <div class="form-check form-check-inline"> -->
                        <input class="form-check-input" type="radio" name="scenario_{{ $i - 1 }}_response_{{ $key }}" value="{{ $j }}">
                    <!--   </div> -->
                    </td>
                  @endfor
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
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="Back to scenario description">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next"><br />
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="scenario1Complete" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center">Thank you. There are three more scenarios. You have a total of 9 minutes to complete these.</h4>
      </div>
      <div class="modal-body text-center">
          <button class="btn btn-lg btn-primary" id="next-scenario" type="button">Continue</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="timerComplete" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center">Your time is up.<br>You will now move on to the next scenario.</h4>
      </div>
      <div class="modal-body text-center">
          <button class="btn btn-lg btn-primary" id="timer-complete" type="button">Continue</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop
