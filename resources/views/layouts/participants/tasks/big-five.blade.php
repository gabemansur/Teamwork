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

      $(".alert-danger").hide();

      $("#submit").on('click', function(event) {
        $('.input:visible .form-check-input').each(function(){
          var name = $(this).attr("name");
          if ($("input:radio[name=" + name + "]:checked").length == 0) {
            $(".alert-danger").show();
            event.preventDefault();
            return;
          }
        })

      });
    });

</script>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <h3>
        Describe yourself as you generally are now, not as you wish to be in
        the future. Describe yourself as you honestly see yourself, in relation
        to other people you know of the same sex as you are, and roughly your
        same age. So that you can describe yourself in an honest manner, your
        responses will be kept in absolute confidence. Indicate for each
        statement whether it is
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <ol class="text-left">
              <li>Very true</li>
              <li>Somewhat true</li>
              <li>Neither true nor untrue</li>
              <li>Moderately true</li>
              <li>Very true</li>
            </ol>
          </div>
        </div>
      </h3>
      <form id="big-five-form" action="/big-five" method="post">
        {{ csrf_field() }}

        <table class="table table-striped">
          <tr>
            <th class="key rotate">
              <div><span>Very True</span></div>
            </th>
            <th class="key rotate">
              <div><span>Somewhat True</span></div>
            </th>
            <th class="key rotate">
              <div><span>Neither true nor untrue</span></div>
            </th>
            <th class="key rotate">
              <div><span>Moderately Untrue</span></div>
            </th>
            <th class="key rotate">
              <div><span>Very Untrue</span></div>
            </th>
            <td class="blank"></td>
          </tr>
            @foreach($statements as $statement)
              <tr>
                @for($i = 5; $i > 0; $i--)
                  <td class="text-center input">
                      <input class="form-check-input" type="radio" name="{{ $statement['number'] }}" value="{{ $i }}">
                  </td>
                @endfor
                <td class="text-left">
                  {{ $statement['statement'] }}
                </td>
              </tr>
            @endforeach
          </table>
          <div class="alert alert-danger">
            <h6>Please be sure to answer each question before continuing.</h6>
          </div>
          <div class="text-center">
            <input class="btn btn-primary instr_nav btn-lg" type="submit" id="submit" value="Submit"><br />
          </div>
      </form>
    </div>
  </div>
</div>

@stop
