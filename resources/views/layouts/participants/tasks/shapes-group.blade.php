@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/instructionPaginator.js') }}"></script>
  <script src="{{ URL::asset('js/timer.js') }}"></script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/tasks.css') }}">
@stop

@section('content')

<script>

    var numShapes = {{ $shapes['length'] }};
    $( document ).ready(function() {

      $("#timer-submit").on("click", function(event) {
        $("#shapes-form").submit();
        event.preventDefault();
      });

      initializeTimer(240, function() {
        $('#submitPrompt').modal();
      });

      $("#back").on('click', function(event) {
        if(parseInt($("#curr-page").html() - 1) <= numShapes) {
          $("#next").show();
          $("#pagination-display").show();
        }
      });

      $("#next").on('click', function(event) {
        if(parseInt($("#curr-page").html()) == numShapes) {
          $("#next").hide();
          $("#pagination-display").hide();
        }
      });

      instructionPaginator(function(){

      });
    });

</script>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <h3><div class="float-right text-primary" id="timer"></div></h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <form id="shapes-form" action="/shapes-group" method="post">
        {{ csrf_field() }}
        @for($i = 1; $i <= $shapes['length']; $i++)
          <div id="inst_{{ $i }}" class="inst">

            <div class="text-center shapes-test-container">
              <img src="/img/shapes-task/subtest2/{{ $i }}.png" class="shapes-img">
              <table class="table shapes-test-table">
                <tr>
                  @for($j = 0; $j < 5; $j++)
                    <td>
                      <input class="form-check-large" type="checkbox" name="{{ $i }}" value="{{ strtolower(chr($j + 65)) }}">
                    </td>
                  @endfor
                </tr>
              </table>
            </div>

          </div>
        @endfor
        <div id="inst_{{ $shapes['length'] + 1 }}" class="inst mb-lg-5">
          <h3>
            You may submit your answers for this test, or use the back button
            to review and change your answers.
          </h3>
          <input class="btn btn-primary btn-lg" type="submit" value="Submit Answers"><br />
        </div>
      </form>
      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
        <span class="text-primary ml-md-4 text-lg" id="pagination-display">
          <span id="curr-page">1</span> / {{ $shapes['length'] }}
        </span>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="submitPrompt" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center">Your time is up.<br>Please submit your responses now</h4>
      </div>
      <div class="modal-body text-center">
          <button class="btn btn-lg btn-primary" id="timer-submit" type="button">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
