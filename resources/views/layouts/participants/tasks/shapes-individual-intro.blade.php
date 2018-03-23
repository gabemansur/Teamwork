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
        <h3>
          Look at the first example. On the top, there are four boxes.
          The last one is empty. Below you see six
          more boxes, marked a, b, c, d, e, and f. Of those six boxes,
          one will fit correctly in the empty box.
        </h3>
        <h3>
          Here the little tree is bending over more and more in the first
          three pictures. Choose the correct box from six presented choices
          on the right to complete the sequence. The correct answer has been
          given to you in this first example. It’s the tree in the third box,
          because that’s the one that has tilted over more than the last one
          in the boxes on the left. Notice that the correct answer, c, has
          been marked for you in this first example.
        </h3>
        <img src="/img/shapes-task/subtest1/example_01.png" class="img-fluid">
      </div>
      <div id="inst_2" class="inst">
        <h3>
          Look at the second example. The black part comes down lower and lower
          each time. So at the next step it would come more than half way down.
          The correct answer for the second example is e.
        </h3>
        <img src="/img/shapes-task/subtest1/example_02.png" class="img-fluid">
        <div class="row">
          <div class="col-md-2 offset-md-5">
            <form class="form mb-lg-5">
              <div class="form-group mb-lg-2">
                <label for="example">Your answer:</label>
                <select class="form-control ml-lg-2" name="exanple">
                  <option>------</option>
                  <option value="a">a</option>
                  <option value="b">b</option>
                  <option value="c">c</option>
                  <option value="d">d</option>
                  <option value="e">e</option>
                  <option value="f">f</option>
                </select>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div id="inst_3" class="inst">
        <h3>
          Now take a look at the third example. See, it’s as if something is growing,
          step by step. In the third box there are three, beginning from the top,
          so four will go in the empty box. Here, the correct answer is e again.
          You can see that none of the other choices is quite right.
        </h3>
        <img src="/img/shapes-task/subtest1/example_03.png" class="img-fluid">
      </div>
      <div id="inst_4" class="inst">
        <h3>
          After clicking the “next” button you will be asked to complete the rest yourself.
        </h3>
        <h3>
          In each row, choose just one of the boxes on the right which would
          correctly go in the empty box and type in your answer in the answer
          box, as you did in the example. You may not have time to finish them
          all, but work as quickly and carefully as you can. In all the tests
          you’ll be taking, you may change your answer if you change your mind,
          but not after the time is over.
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