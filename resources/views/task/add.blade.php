@extends('task.layouts.form')

@section('action', url('/task'))

@section('date_setting')
<?php
    $selected_month = $date->format('n');
    $selected_day = $date->format('j');
    $last_day = $date->format('t');
    $selected_start_hour = 9;
    $selected_start_minute = 0;
    $selected_end_hour = 17;
    $selected_end_minute = 0;
?>
@endsection

@section('submit_button')
  <button type="submit" class="btn btn-primary">Add</button>
@endsection
