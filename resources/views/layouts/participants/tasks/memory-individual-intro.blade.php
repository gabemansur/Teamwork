@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/instructionPaginator.js') }}"></script>
@stop

@section('content')

<script>

    $( document ).ready(function() {
      instructionPaginator(function(){ window.location = '/memory-individual';});
    });

</script>

<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      <div id="inst_1" class="inst">
        <h2 class="text-primary">Memory Task</h2>
        <h4>
          Last are some tests of memory. We’ll start with a practice.<br>
          Please do not write anything down during these tasks.
        </h4>
      </div>

      <div id="instr_nav" class="text-center">
        <input class="btn btn-primary instr_nav btn-lg" type="button" name="next" id="next" value="Next &#8680;"><br />
      </div>
    </div>
  </div>
</div>
@stop
