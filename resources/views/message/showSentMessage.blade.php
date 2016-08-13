@extends('layouts.app')

@section('content')
@include('menubar')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
          To :
      	  @foreach($address_names as $address_name)
            &nbsp;{{ $address_name->name }}
          @endforeach
      	</div>
        <div class="panel-heading">
          {{ $message->title }}
        </div>
      	<div class="panel-body">
          {!! nl2br(e($message->body)) !!}
      	</div>
    </div>

</div>
@endsection
