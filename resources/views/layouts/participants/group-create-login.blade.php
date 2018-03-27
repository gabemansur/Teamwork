@extends('layouts.master')

@section('js')
  <script src="{{ URL::asset('js/group-create.js') }}"></script>
@stop

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
          <h5 class="text-center">Add tasks for this group:</h5>
          <div class="ml-5">
            @foreach($tasks as $key => $task)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="{{ $task['name'] }}" name="tasks[]" value="{{ $task['name'] }}">
                <label class="form-check-label" for="{{ $task['name'] }}">{{ $task['name'] }}</label><br>
                  @foreach($task['params'] as $key => $param)
                    <label class="task-params-select" for="{{ $task['name'].'_'.$key }}">{{ $key }}</label>
                    <select class="form-control form-control-sm task-params-select" id="{{ $task['name'].'_'.$key }}">
                      @foreach($param as $option)
                        <option>{{ $option }}</option>
                      @endforeach
                    </select>
                  @endforeach
              </div>
            @endforeach
          </div>
          <input type="hidden" id="taskJSON" name="taskJSON">
          <div class="text-center">
            <button class="btn btn-lg btn-primary" id="addTask" type="button">Add</button>
          </div>
        </fieldset>
        <div class="text-center">
          <button class="btn btn-lg btn-primary" type="submit">Finished</button>
        </div>
      </form>
    </div>
  </div>
</div>
@stop
