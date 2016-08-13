@extends('layouts.app')

@section('content')
@include('menubar')
<div class="container">
    <form action="{{ url('/message') }}" method="post">
        {{ csrf_field() }}
        <div id="address-box">To:<span class="label label-primary">{{ $sender->name }}</span></div>
        <input type="hidden" name="addresses[]" value="{{ $sender->id }}">

      	<div class="form-group">
      		<label for="InputText">Title:</label>
      		<input name="title" type="text" class="form-control" id="InputText" value="{{ old('title', 'Re:' .$message->title) }}">

      	</div>
        <div class="form-group">
      		<label for="InputTextarea">Body:</label>
      		<textarea name="body" class="form-control" id="InputTextarea" rows="10" cols="40">{{ old('body', $message->body) }}</textarea>
      	</div>

        <button type="submit" class="btn btn-danger">
          <i class="glyphicon glyphicon-send"></i>Send
        </button>
    </form>
    @include('common.errors')
</div>
@endsection
