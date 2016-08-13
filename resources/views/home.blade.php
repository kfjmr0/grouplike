@extends('layouts.app')

<?php
$weekArray = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
$period = new \DatePeriod(
    $origin,
    $interval,
    $endpoint
);
?>

@section('content')
@include('menubar')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">New Message</div>
                <table class="table message-table">
                  <tbody>
                      @forelse($new_messages as $message)
                        <tr data-href="{{ url('/message/show/' .$message->id) }}">
                          <td>{{ $message->sender_name }}</td>
                          <td>{{ $message->title }}</td>
                        </tr>
                      @empty
                        <div class="panel-body"></div>
                      @endforelse
                  </tbody>
                </table>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">My Schedule</div>
                <div class="calendar">
                  <div class="weekly">
                    <table>
                        <tr>
                            @foreach($period as $day)
                              <th class="{{ $weekArray[$day->format('w')] }}">
                                {{ $day->format('n/j(D)') }}
                              </th>
                            @endforeach
                        </tr>
                        @foreach($user_tasks as $user_task)
                          <tr>
                              <?php $i = 0; ?>
                              @foreach($period as $day)
                                <td class="{{ $weekArray[$day->format('w')] }}">
                                    <!-- make add-task function invalid for now 
                                    <a href="{{ url('/task/add/' .$day->format('Y-m-d')) }}"><i class="glyphicon glyphicon-plus"></i></a><br/>
                                    -->
                                    @if(!empty($user_task['task'][$i]))
                                        @foreach($user_task['task'][$i] as $task)
                                          {{ $task['start_time'] .'~'. $task['end_time']}}<br/>
                                          {{ $task['name'] }}<br/>
                                        @endforeach
                                    @endif
                                </td>
                                <?php $i++; ?>
                              @endforeach
                          </tr>
                        @endforeach
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
  @include('table_clickable')
@endsection
