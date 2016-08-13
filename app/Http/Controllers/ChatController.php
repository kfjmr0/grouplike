<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\User;
use App\Chat;
use App\ChatReadRemark;
use App\Topic;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index(Request $request)
  {
      //getting topic title and latest remark set
      $headlines = DB::table('chats')
                    ->join('topics', 'chats.topic_id','=','topics.id')
                    ->select('topics.id', 'topics.title', 'chats.body')
                    ->whereIn('chats.created_at', function($query) {
                        $query->select(DB::raw('max(created_at)'))
                              ->from('chats')
                              ->groupBy('topic_id');
                    })
                    ->orderBy('chats.created_at', 'desc')
                    ->get();
      //dd($headlines);

      $unreads = [];
      foreach ($headlines as $headline) {
          $readRemark = ChatReadRemark::where([
              'topic_id' => $headline->id,
              'user_id' => $request->user()->id,
          ])
          ->first();
          $hasRead = empty($readRemark)? 0 : $readRemark->hasRead;
          $unreads[$headline->id] = Chat::where('topic_id',$headline->id)->count()
                                      - $hasRead;
      }
      //dd($unreads);
      return view('chat.index', [
        'headlines' => $headlines,
        'unreads' => $unreads,
      ]);
  }

  public function show(Request $request, Topic $topic)
  {
      $chats = DB::table('chats')
                    ->join('users', 'chats.user_id','=','users.id')
                    ->select('chats.id as chat_id', 'users.id as user_id', 'users.name', 'chats.body')
                    ->where('chats.topic_id','=',$topic->id)
                    ->orderBy('chats.created_at', 'asc')
                    ->get();
      //dd($chats);

      /*save number of already read remarks of each user*/
      $readRemark = DB::table('chat_read_remarks')
                        ->where([
                            ['topic_id',$topic->id],
                            ['user_id',$request->user()->id],
                        ]);
      if (empty($readRemark->first())) {
          $start_point = 0;
          ChatReadRemark::create([
            'topic_id' => $topic->id,
            'user_id' => $request->user()->id,
            'hasRead' => count($chats),
          ]);
      } else {
          $start_point = $readRemark->first()->hasRead;
          $readRemark->update(['hasRead' => count($chats)]);
      }

      return view('/chat/show', [
        'currentUser' => $request->user()->id,
        'topic' => $topic,
        'chats' => $chats,
        'latest' => end($chats)->chat_id,
        'start_point' => $start_point,
      ]);
  }

  public function ajax(Request $request, Topic $topic)
  {
      if (isset($request->mode)) {
          switch ($request->mode) {
          case 'check':
              /**
              * Check Update.
              * when newly remark is detected,
              * pass that to the client for rendering.
              */
              $newRemark = DB::table('chats')
                                ->where([
                                    ['id', '>', $request->latest],
                                    ['topic_id', '=', $topic->id],
                                    ['user_id', '!=', $request->user()->id],
                                ])
                                ->orderBy('created_at', 'asc')
                                ->first();
              break;
          case 'add':
              /**
              * Add Data
              * save the client's remark
              */
              $newRemark = Chat::create([
                'topic_id' => $topic->id,
                'user_id' => $request->user()->id,
                'body' => $request->body,
              ]);
              break;
          }
      }

      if (empty($newRemark)) {
          echo json_encode(['isUpdated' => false]);
      } else {
          echo json_encode([
              'isUpdated' => true,
              'latest' => $newRemark->id,
              'user_name' => htmlspecialchars(User::find($newRemark->user_id)->name, ENT_QUOTES, 'UTF-8'),
              'body' => nl2br(htmlspecialchars($newRemark->body, ENT_QUOTES, 'UTF-8')),
          ]);
          ChatReadRemark::where([
            'topic_id' => $topic->id,
            'user_id' => $request->user()->id,
          ])->increment('hasRead');
      }
  }

/*
  public function post(Request $request, Topic $topic)
  {
      $this->validate($request, [
        'body' => 'required',
      ]);

      Chat::create([
        'topic_id' => $topic->id,
        'user_id' => $request->user()->id,
        'body' => $request->body,
      ]);

      return redirect('/chat/' .$topic->id);
  }
*/

  public function newTopic()
  {
      return view('chat.makeNew');
  }

  public function makeTopic(Request $request)
  {
      $this->validate($request, [
        'title' => 'required',
        'body' => 'required',
      ]);

      $topic = Topic::create(['title' => $request->title]);
      Chat::create([
        'topic_id' => $topic->id,
        'user_id' => $request->user()->id,
        'body' => $request->body,
      ]);

      ChatReadRemark::create([
        'topic_id' => $topic->id,
        'user_id' => $request->user()->id,
        'hasRead' => 1,
      ]);

      return redirect('/chat');
  }
}
