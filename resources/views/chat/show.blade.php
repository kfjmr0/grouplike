@extends('layouts.app')
@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@include('menubar')
<div class="container">
    <div class="chat-container">
        <div class="topic-title">
            {{ $topic->title }}
        </div>

        <div class="chat-content" id="view" data-latest="{{ $latest }}">
          <?php $i = 1; ?>
          @foreach($chats as $chat)
              @if( $chat->user_id !== $currentUser)
                <div class="left">
                  <div class="name">{{ $chat->name }}</div>
                  <div class="remarks">{!! nl2br(e($chat->body)) !!}</div>
                </div>
              @else
                <div class="right">
                  <div class="remarks ownRemark">{!! nl2br(e($chat->body)) !!}</div>
                </div>
              @endif
              @if ( $start_point === $i and $chat->chat_id !== $latest)
                <div id="hasRead-tag">
                    <i class="glyphicon glyphicon-tags"></i>Previously displayed so far
                </div>
              @endif
              <?php $i++; ?>
          @endforeach
        </div>

        <!-- ajax Error message-->
        <div id="ajax-error"></div>

        <form id="add" action="" method="post">
          {{ csrf_field() }}
          <div class="chatform">
            <div class="body">
              <textarea name="body" rows="3"></textarea>
            </div>
            <div class="button">
        			<button type="submit" class="btn btn-danger">Post</button>
        		</div>
          </div>
        </form>

    </div>
</div>
@endsection

@section('script')
<script>
$(function() {
    var $body = $('textarea[name="body"]');
    var $view = $('#view');
    var $tag = $('#hasRead-tag');
    if ($tag.get(0)) {
      $view.scrollTop($tag.position().top - 200);
    } else {
      $view.scrollTop($view.get(0).scrollHeight);
    }

    /* get and save posts by ajax */
    function error(XMLHttpRequest, textStatus, errorThrown) {
        //this function is called in ajax error
        $("#ajax-error").text('Internal Server Error')
        //$("#XMLHttpRequest").html("XMLHttpRequest : " + XMLHttpRequest.status);
        //$("#textStatus").html("textStatus : " + textStatus);
        //$("#errorThrown").html("errorThrown : " + errorThrown.message);
    }

    //settings of ajax
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        chache: false,
        type: 'POST',
        dataType: 'json',
        error : error,
    });

    //post client's remark
    $('#add').submit(function(event) {
        event.preventDefault();
        if ($body.val() !== '') {
          $.post('{{ url("chat/ajax/" .$topic->id) }}',
              {
                mode: 'add',
                body: $body.val(),
              },
              function(data) {
                  $view.attr('data-latest', data.latest);
                  $body.val('');
                  var remark = $('<div>').html(data.body).addClass('remarks ownRemark');
                  var right = $('<div>').addClass('right').append(remark);
                  $view.append(right);
                  $view.scrollTop($view.get(0).scrollHeight);
              }
          );
        }
    });

    // function for get other user's remark in realtime
    (function checkUpdate() {
        $.ajax({
            url: '{{ url("chat/ajax/" .$topic->id) }}',
            data: {
              mode : 'check',
              latest : $view.attr('data-latest'),
            },
            success: function(data) {
                if (data.isUpdated) {
                    $view.attr('data-latest', data.latest);
                    var name = $('<div>').html(data.user_name).addClass('name');
                    var remark = $('<div>').html(data.body).addClass('remarks');
                    var left = $('<div>').addClass('left').append(name).append(remark);
                    $view.append(left);
                    $view.scrollTop($view.get(0).scrollHeight);
                } else {
                    //console.log('nothing');
                }
            },
            complete: function() {
                // Schedule the next request when the current one's complete
                setTimeout(checkUpdate, 1000);
            }
        });
    })();

});
</script>
@endsection
