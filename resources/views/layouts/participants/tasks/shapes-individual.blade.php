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

    $( document ).ready(function() {

      $("#timer-submit").on("click", function(event) {
        $("#shapes-form").submit();
        event.preventDefault();
      });

      initializeTimer(180, function() {
        $('#submitPrompt').modal();
      }, 'shapes-cookie');

      instructionPaginator(function(){

      });
    });

</script>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="float-right text-primary" id="timer"></div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <form id="shapes-form" action="/shapes-individual" method="post">
        {{ csrf_field() }}
        @for($i = 1; $i <= $shapes['length']; $i++)
          <div id="inst_{{ $i }}" class="inst">
            <img src="/img/shapes-task/subtest1/{{ $i }}.png" class="img-fluid">
            <div class="row">
              <div class="col-md-2 offset-md-5">
                <div class="form-group mb-lg-5">
                  <label for="{{ $i }}">Your answer:</label>
                  <select class="form-control ml-lg-2" name="{{ $i }}">
                    <option>------</option>
                    <option value="a">a</option>
                    <option value="b">b</option>
                    <option value="c">c</option>
                    <option value="d">d</option>
                    <option value="e">e</option>
                    <option value="f">f</option>
                  </select>
                </div>
              </div>
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
