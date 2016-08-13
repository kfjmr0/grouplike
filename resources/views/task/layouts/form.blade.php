@extends('layouts.app')

@yield('date_setting')

@section('content')
@include('menubar')
<div class="container">
  <div class="add-task">
    <form class="task-form" action="@yield('action')" method="post">
      {{ csrf_field() }}
      @yield('http_method')

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
          <input type="text" name="task_name" class="form-control" id="InputTask" value="@yield('task_name')">
        </div>
      </div>

      @yield('submit_button')

    </form>
    @include('common.errors')
    @yield('delete_button')
  </div>
</div>
@endsection
@section('script')
  @include('task.layouts.checkDate_script')
@endsection
