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
      @if ($message = Session::get('message'))
      <div class="alert alert-success text-center" role="alert">
        {{ $message }}
      </div>
      @endif
      <form action="group-create" method="post">
        {{ csrf_field() }}
        <fieldset class="bg-light p-4 rounded">
          <div class="form-group">
            <label for="group_id">Group ID</label>
            <input type="text" class="form-control" name="group_id"
                   value="{{ old('group_id') }}">
          </div>
          <h5 class="text-center">Include the following tasks</h5>
          <div class="ml-5">
            @foreach($tasks as $key => $task)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="{{ $task['name'] }}" name="tasks[]" value="{{ $task['name'] }}">
                <label class="form-check-label" for="{{ $task['name'] }}">{{ $task['name'] }}</label>
              </div>
            @endforeach
          </div>
          <div class="text-center">
            <button class="btn btn-lg btn-primary" type="submit">Create</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
@stop