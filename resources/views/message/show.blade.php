@extends('layouts.app')

@section('content')
@include('menubar')
<div class="container">
    <div class="panel panel-default">
      	<div class="panel-heading">
      		From : {{ $sender }}
      	</div>
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

    <a class="" href="{{ url('/message/reply/' .$message->id) }}">
        <button type="submit" class="btn btn-danger" name="">Reply</button>
    </a>

</div>



@endsection
