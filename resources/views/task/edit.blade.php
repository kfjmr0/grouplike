@extends('task.layouts.form')

@section('action', url('/task/edit/' .$task->id))
@section('http_method', method_field('PATCH'))

@section('date_setting')
<?php
    $selected_month = $date->format('n');
    $selected_day = $date->format('j');
    $last_day = $date->format('t');
    $selected_start_hour = (int)$start_time[0];
    $selected_start_minute = (int)$start_time[1];
    $selected_end_hour = 17;
    $selected_end_minute = 0;
?>
@endsection

@section('task_name', $task->name)

@section('submit_button')
  <button type="submit" class="btn btn-success">Save</button>
@endsection

@section('delete_button')
  <form class="delete-task" action="{{ url('/task/' .$task->id) }}" method="post">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="submit" class="btn btn-danger">Delete</button>
  </form>
@endsection
