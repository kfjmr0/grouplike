@extends('layouts.app')

@section('content')
@include('menubar')
<div class="container">
      <form action="{{ url('/chat') }}" method="post">
          {{ csrf_field() }}
          <div class="form-group">
        		<label for="InputText">Title:</label>
            <input type="text" name="title" class="form-control" id="InputText" value="{{ old('title') }}">
        	</div>
        	<div class="form-group">
        		<label for="InputTextarea">First Remark:</label>
        		<textarea name="body" class="form-control" id="InputTextarea">{{ old('body') }}</textarea>
        	</div>

        	<button type="submit" class="btn btn-danger">Create</button>
      </form>
      @include('common.errors')

</div>

@endsection
