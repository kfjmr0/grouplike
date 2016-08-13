@extends('layouts.app')

<?php
$selected_month = $date->format('n');
$selected_day = $date->format('j');

$selected_start_hour = 9;
$selected_start_minute = 0;
$selected_end_hour = 17;
$selected_end_minute = 0;
$last_day = $date->format('t');

?>

@section('content')
@include('menubar')
<div class="container">
  <div class="add-task">
    <form class="task-form" action="{{ url('/task') }}" method="post">
      {{ csrf_field() }}

      <div class="ymd-input">
        <div class="ib">
          <div class="date-input">
            <label class="" for="InputYear">Y:</label>
            <select name="year" id="InputYear">
              <option value="{{ $date->format('Y') }}">{{ $date->format('Y') }}</option>
              <option value="{{ $date->format('Y') + 1 }}">{{ $date->format('Y') + 1 }}</option>
            </select>
          </div>
          <div class="date-input">
              <label class="" for="InputMonth">M:</label>
              <select name="month" id="InputMonth">
                @for($i = 1; $i < 13; $i++)
                  @if("$i" === $selected_month)
                   <option value="{{ $i }}" selected>{{ $i }}</option>
                  @else
                   <option value="{{ $i }}">{{ $i }}</option>
                  @endif
                @endfor
              </select>
          </div>
          <div class="date-input">
              <label class="" for="InputDay">D:</label>
              <select name="day" id="InputDay">
                @for($i = 1; $i <= $last_day; $i++)
                  @if("$i" === $selected_day)
                   <option value="{{ $i }}" selected>{{ $i }}</option>
                  @else
                   <option value="{{ $i }}">{{ $i }}</option>
                  @endif
                @endfor
              </select>
          </div>
        </div>
      </div>


      <div class="start_time">
        <div class="ib">
            <div class="date-input">
                <label class="" for="InputStartHour">Start :</label>
                <select name="startHour" id="InputStartHour">
                  @for($i = 0; $i < 24; $i++)
                    @if($i === $selected_start_hour)
                     <option value="{{ $i }}" selected>{{ sprintf("%02d", $i) }}</option>
                    @else
                     <option value="{{ $i }}">{{ sprintf("%02d", $i) }}</option>
                    @endif
                  @endfor
                </select>
              </div>
            <div class="date-input">:</div>
            <div class="date-input">
                <select name="startMinute" id="InputStartMinute">
                  @for($i = 0; $i < 60; $i += 10)
                    @if($i === $selected_start_minute)
                     <option value="{{ $i }}" selected>{{ sprintf("%02d", $i) }}</option>
                    @else
                     <option value="{{ $i }}">{{ sprintf("%02d", $i) }}</option>
                    @endif
                  @endfor
                </select>
            </div>
        </div>
      </div>
      <div class="end_time">
        <div class="ib">
            <div class="date-input">
                <label for="InputEndHour">End :&nbsp;&nbsp;</label>
                <select name="endHour" id="InputEndHour">
                  @for($i = $selected_start_hour; $i < 24; $i++)
                    @if($i === $selected_end_hour)
                     <option value="{{ $i }}" selected>{{ sprintf("%02d", $i) }}</option>
                    @else
                     <option value="{{ $i }}">{{ sprintf("%02d", $i) }}</option>
                    @endif
                  @endfor
                </select>
            </div>
            <div class="date-input">:</div>
            <div class="date-input">
                <select name="endMinute" id="InputEndMinute">
                  @for($i = 0; $i < 60; $i += 10)
                    @if($i === $selected_end_minute)
                     <option value="{{ $i }}" selected>{{ sprintf("%02d", $i) }}</option>
                    @else
                     <option value="{{ $i }}">{{ sprintf("%02d", $i) }}</option>
                    @endif
                  @endfor
                </select>
            </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-1 control-label" for="InputTask">Task:</label>
        <div class="col-sm-11">
          <input type="text" name="task_name" class="form-control" id="InputTask">
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Add</button>

    </form>
    @include('common.errors')
  </div>
</div>
@endsection
@section('script')
<script>
$(function() {
    var $year = $('#InputYear');
    var $month = $('#InputMonth');
    var $day = $('#InputDay');
    $year.change(dateCheck);
    $month.change(dateCheck);

    var $start_hour = $('#InputStartHour');
    var $start_minute = $('#InputStartMinute');
    var $end_hour = $('#InputEndHour');
    var $end_minute = $('#InputEndMinute');
    $start_hour.change(timeCheck);
    $start_minute.change(timeCheck);
    $end_hour.change(timeCheck);

    function dateCheck() {
        var y = $year[0].value;
        var m = $month[0].value;
        var d = $day[0].value;
        var ds = new Date(y, m, 0); //get last day of the month
        var dl = ds.getDate();

        var options = "";
        for (var i = 1; i <= dl; i++) {
          if (i == d) {
            options += "<option value='" + i + "' selected>" + i + "</option>";
          } else {
            options += "<option value='" + i + "'>" + i + "</option>";
          }
        }
        $day.html(options);
    }

    function timeCheck() {
        var sh = Number($start_hour[0].value);
        var sm = Number($start_minute[0].value);
        var eh = Number($end_hour[0].value);
        var em = Number($end_minute[0].value);
        //console.log(typeof sh,sm,eh,em);
        var options = "";
        for (var i = sh; i < 24; i++) {
          if (i == eh) {
            options += "<option value='" + i + "' selected>" + ("0"+i).slice(-2) + "</option>";
          } else {
            options += "<option value='" + i + "'>" + ("0"+i).slice(-2) + "</option>";
          }
        }
        $end_hour.html(options);

        if (sh == eh) {
            var options = "";
            for (var i = sm; i < 60; i += 10) {
              if (i == em) {
                options += "<option value='" + i + "' selected>" + ("0"+i).slice(-2) + "</option>";
              } else {
                options += "<option value='" + i + "'>" + ("0"+i).slice(-2) + "</option>";
              }
            }
            $end_minute.html(options);
        } else if (sh < eh) {
            var options = "";
            for (var i = 0; i < 60; i += 10) {
              if (i == em) {
                options += "<option value='" + i + "' selected>" + ("0"+i).slice(-2) + "</option>";
              } else {
                options += "<option value='" + i + "'>" + ("0"+i).slice(-2) + "</option>";
              }
            }
            $end_minute.html(options);
        }
    }
});
</script>
@endsection
