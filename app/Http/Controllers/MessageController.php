<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests;
use DB;
use App\User;
use App\Message;
use App\MessageUser;
use App\MessageInbox;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index(Request $request)
  {
    $messages = DB::table('messages')
                  ->join('message_inbox','messages.id','=','message_inbox.message_id')
                  ->join('users','messages.user_id','=','users.id')
                  ->where('message_inbox.user_id',$request->user()->id)
                  ->select('messages.id','messages.title','messages.body','users.name as sender_name','message_inbox.hasRead')
                  ->orderBy('messages.created_at', 'desc')
                  //->get();
                  ->paginate(10);//test pagination
    //dd($messages);

    return view('message.index', [
      'messages' => $messages,
    ]);
  }

  public function write(Request $request)
  {
    $users = User::where('id','!=',$request->user()->id)->get();
    return view('message.write', [
        'users' => $users,
    ]);
  }

  public function send(Request $request)
  {
    //dd($request->addresses);
    $this->validate($request, [
      'addresses' => 'required',
      'title' => 'required',
      'body' => 'required',
    ]);

    $message = Message::create([
      'user_id' => $request->user()->id,
      'title' => $request->title,
      'body' => $request->body
    ]);
    //dd($message);

    foreach($request->addresses as $address) {
        //MessageUser is for address management.
        //Though users delete their messages, they remain in 'messages' and 'message_user' table.
        MessageUser::create([
          'message_id' => $message->id,
          'user_id' => $address,
        ]);
        //Inbox is for showing and deleting received messages.
        //Messags deleted from this table arent shown in users'inbox
        MessageInbox::create([
          'message_id' => $message->id,
          'user_id' => $address,
        ]);
    }

    return redirect('/message');
  }

  public function show(Request $request, Message $message)
  {
      $sender = DB::table('messages')
                    ->join('users','users.id','=','messages.user_id')
                    ->where('messages.id', $message->id)
                    ->first()
                    ->name;
      //dd($sender);
      $address_names = DB::table('message_user')
                            ->join('users','users.id','=','message_user.user_id')
                            ->select('users.name')
                            ->where('message_user.message_id', $message->id)
                            ->get();
      //
      DB::table('message_inbox')
          ->where([
            ['message_id','=',$message->id],
            ['user_id','=',$request->user()->id],
          ])
          ->update(['hasRead' => 1]);

      return view('message.show', [
          'message' => $message,
          'sender' => $sender,
          'address_names' => $address_names,
      ]);
  }

  public function reply(Message $message) {
      $sender = DB::table('messages')
                    ->join('users','users.id','=','messages.user_id')
                    ->select('users.id','users.name')
                    ->where('messages.id', $message->id)
                    ->first();
      //add quotation sign '>'
      $message->body = '>' . str_replace("\n", "\n>", $message->body);
      //dd($message->body);
      return view('message.reply', [
          'message' => $message,
          'sender' => $sender,
      ]);
  }

  public function indexOfSentMessage(Request $request)
  {
      $address_names = [];
      $messages = DB::table('messages')
                      ->where('user_id', $request->user()->id)
                      ->orderBy('created_at', 'desc')
                      //->get();
                      ->paginate(10);//test pagination

      //dd($messages);
      foreach ($messages as $message) {
          $address_names[$message->id] = DB::table('message_user')
                                              ->join('users','users.id','=','message_user.user_id')
                                              ->select('users.name')
                                              ->where('message_user.message_id', $message->id)
                                              //->get();
                                              ->paginate(10);//test pagination
      }
      //dd($address_names);
      return view('message.indexOfSentMessage', [
        'messages' => $messages,
        'address_names' => $address_names,
      ]);
  }

  public function showSentMessage(Message $message)
  {
      $address_names = DB::table('message_user')
                            ->join('users','users.id','=','message_user.user_id')
                            ->select('users.name')
                            ->where('message_user.message_id', $message->id)
                            ->get();
      //dd($address_names);
      return view('message.showSentMessage', [
          'message' => $message,
          'address_names' => $address_names,
      ]);
  }

  public function destroy(Request $request, Message $message)
  {
      //some policies are needed ... make later.


      DB::table('message_inbox')
            ->where([
              ['message_id','=',$message->id],
              ['user_id','=',$request->user()->id],
            ])
            ->delete();
      return redirect('/message');
  }
}
