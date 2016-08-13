@extends('layouts.app')

@section('content')
@include('menubar')
<div class="container">
    <form action="{{ url('/message') }}" method="post">
        {{ csrf_field() }}
        <div id="address-box">To:</div>

        <div class="btn-group">
          	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          		--Select Address--
          		<span class="caret"></span>
          	</button>
          	<ul class="dropdown-menu" role="menu">
              <li id="selectAll" role="presentation"><a role="menuitem" tabindex="-1" href="#">
                ALL
              </a></li>
              @foreach($users as $user)
                <li class="address" userid="{{ $user->id }}" data-username="{{ $user->name }}" role="presentation"><a role="menuitem" tabindex="-1" href="#">
                  {{ $user->name }}
                </a></li>
              @endforeach
          	</ul>
        </div>

      	<div class="form-group">
      		<label for="InputText">Title:</label>
      		<input name="title" type="text" class="form-control" id="InputText" value="{{ old('title') }}">

      	</div>
        <div class="form-group">
      		<label for="InputTextarea">Body:</label>
      		<textarea name="body" class="form-control" id="InputTextarea" rows="10" cols="40">{{ old('body') }}</textarea>
      	</div>

        <button type="submit" class="btn btn-danger">
          <i class="glyphicon glyphicon-send"></i>Send
        </button>
    </form>
    @include('common.errors')
</div>
@endsection
@section('script')
<script>
  $(function() {
    function select() {
        $(this).off('click');
        var span = $('<span>').text($(this).data('username')).addClass('label label-primary');
        var i = $('<i>').attr('userid', $(this).attr('userid')).addClass('glyphicon glyphicon-remove');
        var hiddenform = ($('<input>').attr({
                                          type : 'hidden',
                                          name : 'addresses[]',
                                          value : $(this).attr('userid'),
                                      }));
        span.append(i).append(hiddenform);
        $('#address-box').append(span);
    };

    $('.address').click(select);

    $('#address-box').on('click', '.glyphicon-remove', function() {
        $('.address[userid="' + $(this).attr('userid') + '"]').on('click', select);
        $(this).parent().remove();
    });

    $('#selectAll').click(function() {
        $('.address').each(function() {
          $(this).trigger('click');
        });
    });
    //Hold old addresses when validation errors occur
    @if(null !== old('addresses'))
      @foreach(old('addresses') as $old_address)
        $('.address[userid="' + {{ $old_address }} + '"]').trigger('click');
      @endforeach
    @endif
  });
</script>
@endsection
