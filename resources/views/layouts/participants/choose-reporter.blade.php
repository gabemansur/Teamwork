@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/instructionPaginator.js') }}"></script>
@stop

@section('content')
<script>
$( document ).ready(function() {

  instructionPaginator(function(){ return ;});

  $("#next").on('click', function(event) {
    if($("#inst_2").is(":visible")) {
      $("#instr_nav").hide();
      event.stopImmediatePropagation();
    }
  });
});
</script>
<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      @if(isset($reporterChosen))
        <h3>A reporter has already been selected for your group. You will NOT be
          the reporter.</h3>
        <div class="text-center">
          <a class="btn btn-primary memory-nav btn-lg reporter mb-md-4"
                 href="/end-group-task" role="button"
                 >Continue</a>
        </div>
      @else
        <div id="inst_1" class="inst">
          <h2>Entering your Group’s Answers</h2>
          <h4>Your group will only submit one answer for each problem.</h4>
          <h4>
            <strong>At this point, choose one member of your group to be "The Reporter"</strong>.
            This person will be responsible for entering the group’s answers.
          </h4>
          <h4>Take a moment to discuss who will be The Reporter.</h4>
          <h4>When you have decided, all three group members should hit "Next"</h4>
        </div>
        <div id="inst_2" class="inst">
          <div class="text-center">
            <a class="btn btn-success memory-nav btn-lg reporter mb-md-4"
                   href="/choose-reporter/true" role="button"
                   >I am the Reporter</a><br>
            <a class="btn btn-warning memory-nav btn-lg not-reporter"
                  href="/choose-reporter/false" role="button"
                  >I am NOT the Reporter</a>
          </div>
        </div>
        <div id="instr_nav" class="text-center">
          <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
        </div>
      @endif
    </div>
  </div>
</div>
@stop
