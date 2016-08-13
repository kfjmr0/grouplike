@extends('layouts.app')

@section('content')
@include('menubar')
<div class="container">
  <div class="message-header">
      <div class="left">
        <a href="{{ url('/message/write') }}">
          <button type="button" class="btn btn-danger makeNewButton">
            <i class="glyphicon glyphicon-pencil"></i>Write Message
          </button>
        </a>
      </div>
      <div class="right">
        <a href="{{ url('/message/sent') }}">
          <button type="button" class="btn btn-info makeNewButton">
            Sent Message
          </button>
        </a>
      </div>
  </div>

  <table class="table message-table">
    <thead>
        <tr>
          <th>From</th>
          <th>Title</th>
          <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($messages as $message)
          <tr data-href="{{ url('/message/show/' .$message->id) }}" data-hasRead="{{ $message->hasRead }}">
            <td>{{ $message->sender_name }}</td>
            <td>{{ $message->title }}</td>
            <td>
              <form action="{{ url('/message/destroy/' .$message->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" name="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td>No message exists</td></tr>
        @endforelse
    </tbody>
  </table>
  {{ $messages->links() }}
</div>
@endsection
@section('script')
  @include('table_clickable')
@endsection
