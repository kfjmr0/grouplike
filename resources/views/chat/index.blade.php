@extends('layouts.app')

@section('content')
@include('menubar')
<div class="container">
      <a href="{{ url('/chat/new') }}">
        <button type="button" class="btn btn-danger makeNewButton">
          <i class="glyphicon glyphicon-plus-sign"></i>Create New Topic
        </button>
      </a>

      <div class="topic-container">
        @forelse($headlines as $headline)
          <a href="{{ url('/chat/' .$headline->id) }}">
              <div class="panel panel-info">
                <div class="panel-heading title">
                  {{ $headline->title }}
                  @if ($unreads[$headline->id] > 0)
                    <span class="badge">{{ $unreads[$headline->id] }}</span>
                  @endif
                </div>
                <div class="panel-body">
                  {{ $headline->body }}
                </div>
              </div>
          </a>
        @empty
          No Topic Exists
        @endforelse
      </div>
</div>


@endsection
