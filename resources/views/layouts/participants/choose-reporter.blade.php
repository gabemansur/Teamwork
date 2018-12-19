@extends('layouts.master')


@section('content')
<div class="container">
  <div class="row vertical-center">
    <div class="col-md-12 text-center">
      @if(isset($reporterChosen))
        <h3>A reporter has already been selected for your group. You will NOT be
          the reporter.</h3>
        <div class="text-center">
          <a class="btn btn-primary memory-nav btn-lg reporter mb-md-4"
                 href="/end-individual-task" role="button"
                 >Continue</a>
        </div>
      @else
        <h3>
          WHO IS THE REPORTER???
        </h3>

        <div class="text-center">
          <a class="btn btn-success memory-nav btn-lg reporter mb-md-4"
                 href="/choose-reporter/true" role="button"
                 >I am the Reporter</a><br>
          <a class="btn btn-warning memory-nav btn-lg not-reporter"
                href="/choose-reporter/false" role="button"
                >I am NOT the Reporter</a>
        </div>
      @endif
    </div>
  </div>
</div>
@stop
