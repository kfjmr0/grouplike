<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\Message;
use App\MessageUser;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // comment out 2016/7/24
        //$this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Instead of middleware, manually check if the user'S loged in.
        //Maybe it's possible do the same thing in other way. 2016/7/24
        if (!Auth::check()) {
            return view('welcome');
        }

        // getting new messages
        $new_messages = DB::table('messages')
                              ->join('message_inbox','messages.id','=','message_inbox.message_id')
                              ->join('users','messages.user_id','=','users.id')
                              ->where([
                                  ['message_inbox.user_id','=',$request->user()->id],
                                  ['message_inbox.hasRead','=','0'],
                              ])
                              ->orderBy('messages.created_at', 'desc')
                              ->select('messages.id','messages.title','users.name as sender_name')
                              ->get();
        //dd($new_messages);
        // getting weekly schedule

            //get [username, task[index[name, starttime, endtime]]]
            $user_tasks = [];
            $origin = new \DateTime();
            $d1 = new \DateTime();
            $endpoint = $d1->add(\DateInterval::createFromDateString('7day'));
            $interval = new \DateInterval('P1D');

            $this->_getWeeklyTask($request->user(), $user_tasks, $origin);
            /*
            $users = DB::table('users')->get();
            foreach ($users as $user) {
              if($user->id !== $request->user()->id) {
                $this->_getWeeklyTask($user, $user_tasks, $origin);
              }
            }
            */
            //dd($user_tasks);


        return view('home', [
            'new_messages' => $new_messages,
            'user_tasks' => $user_tasks,
            'origin' => $origin,
            'interval' => $interval,
            'endpoint' => $endpoint,
        ]);
    }

    private function _getWeeklyTask($user, &$user_tasks, $origin)
    {
        static $index = 0;
        $user_tasks[$index] = [];
        $user_tasks[$index]['user_name'] = $user->name;
        $user_tasks[$index]['task'] = [];
        $d1 = new \DateTime();
        $endpoint = $d1->add(\DateInterval::createFromDateString('7day'));
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod(
            $origin,
            new \DateInterval('P1D'),
            $endpoint
        );
        $i=0;
        foreach ($period as $day) {
            $user_tasks[$index]['task'][$i] = [];
            $tasks = User::find($user->id)->tasks()
                          ->where('date', $day->format('Y-m-d'))
                          ->orderBy('start_time','asc')
                          ->get();
            foreach ($tasks as $task) {
                $start_time = new \DateTime($task->start_time);
                $end_time = ($task->end_time)? new \DateTime($task->end_time) : '';
                $user_tasks[$index]['task'][$i][] = [
                  'name' => $task->name,
                  'start_time' =>  $start_time->format('G:i'),
                  'end_time' => $end_time ? $end_time->format('G:i') : '',
                ];
            }
            $i++;
        }
        //dd($user_tasks);
        $index++;
    }

}
