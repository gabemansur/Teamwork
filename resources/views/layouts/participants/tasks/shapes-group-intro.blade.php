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
      instructionPaginator(function(){ window.location = '/shapes-group';});
    });
</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      <div id="inst_1" class="inst">
        <h2 class="text-primary">Shapes Task</h2>
        <h3 class="text-success">
          Task {{ \Session::get('completedTasks') + 1 }} of {{ \Session::get('totalTasks') }}
        </h3>
        <h4>
          Last is a test of your group’s ability to recognize patterns and shapes.
        </h4>
        <h4>
          This is very similar to the shapes task you did individually. But,
          the questions are formatted differently, so we'll start with some examples.
        </h4>
        <h4>
          <strong>
            You only need one computer for this task. Everyone should be gathered
            around <em>The Reporter's</em> laptop.
          </strong>
        </h4>
        <h4>
          @if($isReporter)
            Click Next to see the examples.
          @else
            If you are not The Reporter, you can click "finish" and close your laptop:
            you won’t be needing it again.
          @endif
        </h4>
      </div>
      <div id="inst_2" class="inst">
        <h3>
          Instructions and examples
        </h3>
        <h4>
          In each question you will see five boxes. Three of the boxes will be
          alike in some way. The other two are different. Your job is to find
          the two shapes that don’t fit.
        </h4>
        <h4>
          Below is an example. You can see that three of the boxes contain
          triangles (boxes a, c and e). The other two contain rectangles.
          The correct answer is <strong>b</strong> and <strong>d</strong>.
          Click on the circles below the boxes
          to select your answers.
        </h4>
        <div class="text-center shapes-test-container">
          <img src="/img/shapes-task/subtest2/example_01.png" class="shapes-img">
          <table class="table shapes-test-table">
            <tr>
              @for($i = 1; $i < 6; $i++)
                <td>
                  <input class="form-check-large" type="checkbox" name="{{ $i }}[]" value="{{ $i }}">
                </td>
              @endfor
            </tr>
          </table>
        </div>
      </div>
      <div id="inst_3" class="inst">
        <h4>
          Here is another example. Two of the circles are filled-in dotted
          circles (in boxes c and e). The other three circles are empty. The
          correct answer is c and e. These are the boxes that don’t fit with
          the other three.
        </h4>
        <div class="text-center shapes-test-container">
          <img src="/img/shapes-task/subtest2/example_02.png" class="shapes-img">
          <table class="table shapes-test-table">
            <tr>
              @for($i = 1; $i < 6; $i++)
                <td>
                  <input class="form-check-large" type="checkbox" name="{{ $i }}" value="{{ $i }}">
                </td>
              @endfor
            </tr>
          </table>
        </div>
        <h4>
          When all three of your group members are ready, click "Next".
        </h4>
      </div>
      <div id="inst_4" class="inst">
        <h4>
          After clicking the "next" button, your group will complete the rest
          yourselves. Remember: <strong>choose two figures in each row that are
          <em>different</em> from the others</strong>.
        </h4>
        <h4>
          Also remember that you're working as a team! Take a moment to discuss
          how you will approach this task.
        </h4>
        <h4>
          There are 14 questions and you have 4 minutes. You may not have time
          to finish all the questions, but you should work as quickly and
          carefully as you can. There will be a timer in the top right of
          your screen.
        </h4>
        <h4>
          You may change your answers if you change your mind, but not after the 4 minutes is up.
        </h4>
        <h4>
          Click "Next" to begin!
        </h4>
      </div>
      @if($isReporter)
        <div id="instr_nav" class="text-center">
          <input class="btn btn-primary instr_nav btn-lg" type="button" name="back" id="back" value="&#8678; Back">
          <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
        </div>
      @else
        <div class="text-center">
          <a href="/end-group-task" class="btn btn-primary btn-lg" role="button" name="finish" id="finish" >Finish</a><br />
        </div>
      @endif
    </div>
  </div>
</div>
@stop
