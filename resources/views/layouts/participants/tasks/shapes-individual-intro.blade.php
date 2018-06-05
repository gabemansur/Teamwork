@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/instructionPaginator.js') }}"></script>
@stop

@section('content')

<script>
    $( document ).ready(function() {
      instructionPaginator(function(){ window.location = '/shapes-individual';});
    });
</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      <div id="inst_1" class="inst">
        <h2 class="text-primary">Shapes Task</h2>
        <h3>
          First we have a task where you will try to understand patterns and
          shapes. You will have to identify what comes next. We’ll start with
          a practice.
        </h3>
      </div>
      <div id="inst_2" class="inst">
        <h3>
          On the top, there are four boxes.
          The last one is empty. Below you see six
          more boxes, marked a, b, c, d, e, and f. Of those six boxes,
          one will fit correctly in the empty box.
        </h3>
        <h3>
          The correct answer has been
          given to you in this first example. It’s box c.
        </h3>
        <img src="/img/shapes-task/subtest1/example_01.png" class="img-fluid">
      </div>
      <div id="inst_3" class="inst">
        <h3>
          Here's another example. The black part comes down lower and lower
          each time. So at the next step it would come more than half way down.
          The correct answer for the second example is box e.
        </h3>
        <img src="/img/shapes-task/subtest1/example_02.png" class="img-fluid">
      </div>
      <div id="inst_4" class="inst">
        <h3>
          After clicking the “next” button you will be asked to complete the
          rest yourself. As in the practices, select the box that continues
          the pattern!
        </h3>
        <h3>
          There are 13 questions and you have 3 minutes. You may not have time
          to finish all the questions, but work as quickly and carefully as you
          can. The questions will get harder as you progress. There will be a
          timer in the top right of your screen.
        </h3>
        <h3>
          You may change your answer if you change your mind, but not after the
          3 minutes is up.
        </h3>
      </div>
      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
  </div>
</div>
@stop
