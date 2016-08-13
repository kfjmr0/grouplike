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
        <a href="{{ url('/message') }}">
          <button type="button" class="btn btn-info makeNewButton">
            Inbox
          </button>
        </a>
      </div>
  </div>

  <table class="table message-table">
    <thead>
        <tr>
          <th>Sent Message</th>
        </tr>
    </thead>
    <tbody>
        @forelse($messages as $message)
          <tr data-href="{{ url('/message/sent/' .$message->id) }}">
            <td>
              To:
              @foreach($address_names[$message->id] as $address_name)
                {{ $address_name->name }}&nbsp;
              @endforeach
              <br/>{{ $message->title }}
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
