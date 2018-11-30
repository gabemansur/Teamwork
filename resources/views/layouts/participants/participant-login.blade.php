@extends('layouts.master')


@section('content')
<div class="container">
  <div class="row justify-content-center vertical-center">
    <div class="col-md-6 p-4">
      @if($errors)
        @foreach ($errors->all() as $error)
        <h5 class="text-white bg-danger p-2">
          {{ $error }}
        </h5>
        @endforeach
      @endif
      <form action="/participant-login" method="post">
        {{ csrf_field() }}
        <fieldset class="bg-light p-4 rounded">
          <div class="form-group">
            <label for="participant_id">Participant ID</label>
            <input type="text" class="form-control" name="participant_id"
                   value="{{ old('participant_id') }}">
          </div>
          <div class="form-group">
            <label for="group_id">Group ID</label>
            <input type="text" class="form-control" name="group_id"
                   value="{{ old('group_id') }}">
          </div>
          @if(isset($package))
            <input type="hidden" name="task_package" value="{{ $package }}">
          @endif
          <div class="text-center">
            <button class="btn btn-lg btn-primary" type="submit">Sign In</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
@stop
