@extends('layouts.app')

@section('content')
@include('menubar')
<div class="container">
  <div class="calendar">
    <div class="month"></div>
    <table>
        <tr>
            <th class="sun">Sun</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th class="sat">Sat</th>
        </tr>
        <tr>
          <?php $cnt = 0; ?>
          @foreach($calendar as $value)
              @if($cnt === 0)
                  <td class="sun">
              @elseif($cnt === 6)
                  <td class="sat">
              @else
                  <td>
              @endif
              <?php $cnt++; echo e($value['day']); ?>
              @if($value['day'])
                  <a href="#"><i class="glyphicon glyphicon-plus"></i></a>
              @endif
              </td>

              @if($cnt === 7)
                </tr>
                <tr>
                <?php $cnt = 0; ?>
              @endif
          @endforeach
        </tr>
    </table>
  </div>






</div>

@endsection
