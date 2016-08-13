<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    // the task repository instance
    protected $tasks;

    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;
    }

    private function _getWeeklyTask($user, &$user_tasks, $origin)
    {
        static $index = 0;
        $user_tasks[$index] = [];
        $user_tasks[$index]['user_name'] = $user->name;
        $user_tasks[$index]['task'] = [];
        //$d1 = new \DateTime();
        $d1 = clone $origin;
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
                  'id' => $task->id,
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

    public function index(Request $request, $date = '')
    {
        //check if the received date is valid
        $tmp = explode('-', $date);
        $ymd = array_map(function($v){return (int)$v;}, $tmp);
        if (count($ymd) === 3 and checkdate($ymd[1],$ymd[2],$ymd[0])) {
            $origin = new \DateTime($ymd[0] .'-'. $ymd[1] .'-'. $ymd[2]);
        } else {
            $origin = new \DateTime();
        }

        //get [username, task[index[name, starttime, endtime]]]
        $user_tasks = [];
        $this->_getWeeklyTask($request->user(), $user_tasks, $origin);
        $users = DB::table('users')->get();
        foreach ($users as $user) {
          if($user->id !== $request->user()->id) {
            $this->_getWeeklyTask($user, $user_tasks, $origin);
          }
        }
        //dd($user_tasks);

        // Maybe monthly calendar page will be made later
        $d1 = clone $origin;
        $endpoint = $d1->add(\DateInterval::createFromDateString('7day'));
        $interval = new \DateInterval('P1D');

        return view('task.index', [
            //'tasks' => $this->tasks->forUser($request->user()), // original laravel references intermediate task list
            'user_tasks' => $user_tasks,
            'origin' => $origin,
            'interval' => $interval,
            'endpoint' => $endpoint,
        ]);
    }

    public function add(Request $request, $date = '')
    {
        //check if the received date is valid
        $tmp = explode('-', $date);
        $ymd = array_map(function($v){return (int)$v;}, $tmp);
        if (count($ymd) === 3 and checkdate($ymd[1],$ymd[2],$ymd[0])) {
            $receivedDate = new \DateTime($ymd[0] .'-'. $ymd[1] .'-'. $ymd[2]);
        } else {
            $receivedDate = new \DateTime();
        }

        return view('task.add', [
            'date' => $receivedDate,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'task_name' => 'required|max:255',
        ]);

        //dd($request);
        $d1 = new \DateTime($request->year .'-'.
                            $request->month .'-'.
                            $request->day
                            );

        //dd($d1->format('Y-m-d H:i:s'));
        //$d2 = new \DateTime('2016-2-31');
        //dd($d2);
        Task::Create([
          'user_id' => $request->user()->id,
          'name' => $request->task_name,
          'date' => $d1->format('Y-m-d'),
          'start_time' => $request->startHour .':'. $request->startMinute ,
          'end_time' => $request->endHour .':'. $request->endMinute ,
        ]);

        return redirect('/task');

        // original laravel references intermediate task list
        /*
        $this->validate($request, [
          'name' => 'required|max:255',
        ]);

        //create the task
        $request->user()->tasks()->create([
          'name' => $request->name,
        ]);

        return redirect('/task');
        */
    }

    public function modify(Task $task)
    {
        $start_time = explode(':', $task->start_time);
        $end_time = explode(':', $task->end_time);
        return view('task.edit', [
          'task' => $task,
          'date' => new \DateTime($task->date),
          'start_time' => $start_time,
          'end_time' => $end_time,
        ]);
    }

    public function edit(Request $request, Task $task)
    {
        $this->validate($request, [
          'task_name' => 'required|max:255',
        ]);

        $d1 = new \DateTime($request->year .'-'.
                            $request->month .'-'.
                            $request->day
                            );
        //dd($d1->format('Y-m-d H:i:s'));
        //$d2 = new \DateTime('2016-2-31');
        //dd($d2);
        $task->update([
          'name' => $request->task_name,
          'date' => $d1->format('Y-m-d'),
          'start_time' => $request->startHour .':'. $request->startMinute ,
          'end_time' => $request->endHour .':'. $request->endMinute ,
        ]);

        return redirect('/task');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();
        return redirect('/task');

        // original laravel references intermediate task list
        /*
          $this->authorize('destroy', $task);

          $task->delete();
          return redirect('/task');
        */
    }

}
