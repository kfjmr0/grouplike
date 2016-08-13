<!-- resources/views/task/index.blade.php -->
@extends('layouts.app')

<?php
$weekArray = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
$next_week = clone $origin;
$next_week->add(\DateInterval::createFromDateString('7day'));
$last_week = clone $origin;
$last_week->sub(\DateInterval::createFromDateString('7day'));
$period = new \DatePeriod(
    $origin,
    $interval,
    $endpoint
);
$j = 0;
?>

@section('content')
@include('menubar')
<div class="calendar" id="schedule-page-weekly-calendar">
  <div class="calendar-nav">
    <div class="btn-group" role="group">
      <a href="{{ url('/task/add') }}" class="btn btn-primary" role="button">
        Add Task
      </a>
    	<a href="{{ url('/task/' .$last_week->format('Y-m-d')) }}" class="btn btn-default" role="button">
        <i class="glyphicon glyphicon-chevron-left"></i>Last Week
      </a>
    	<a href="{{ url('/task/' .$next_week->format('Y-m-d')) }}" class="btn btn-default" role="button">
        Next Week<i class="glyphicon glyphicon-chevron-right"></i>
      </a>
    </div>
  </div>


  <div class="weekly">
    <table>
        <tr>
            <th></th>
            @foreach($period as $day)
              <th class="{{ $weekArray[$day->format('w')] }}">
                {{ $day->format('n/j(D)') }}
              </th>
            @endforeach
        </tr>
        @foreach($user_tasks as $user_task)
          <tr>
              <th class="username">
                {{ $user_task['user_name'] }}<br/>
                <!--
                <a href="#"><button type="button">Monthly</button></a>
                -->
              </th>
              <?php $i = 0; ?>
              @foreach($period as $day)
                <td class="{{ $weekArray[$day->format('w')] }}">
                    @if( $j === 0 )
                      <a href="{{ url('/task/add/' .$day->format('Y-m-d')) }}"><i class="glyphicon glyphicon-plus"></i></a><br/>
                    @endif
                    @if(!empty($user_task['task'][$i]))
                        @foreach($user_task['task'][$i] as $task)
                          @if( $j === 0 )
                            <a class="edit" href="{{ url('/task/edit/' .$task['id']) }}">
                              {{ $task['start_time'] .'~'. $task['end_time']}}<br/>
                              {{ $task['name'] }}<br/>
                            </a>
                          @else
                            {{ $task['start_time'] .'~'. $task['end_time']}}<br/>
                            {{ $task['name'] }}<br/>
                          @endif
                        @endforeach
                    @endif
                </td>
                <?php $i++; ?>
              @endforeach
          </tr>
          <?php $j++; ?>
        @endforeach
    </table>
  </div>
</div>
@endsection
