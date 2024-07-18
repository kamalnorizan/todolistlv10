<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    function index() {
        // $tasks = Task::all();
        // // select * from tasks

        // $tasks = Task::limit(10)->get();
        // // select * from tasks limit 10

        // $tasks = Task::latest()->limit(10)->get();
        // // select * from tasks order by created_at desc limit 10

        // $tasks = Task::where('id','<', 30)->get();
        // // select * from tasks where id < 30

        // $tasks = Task::where('id','<=', 30)
        //             ->where('id','>=',20)->get();
        // // select * from tasks where id < 30

        // $tasks = Task::whereBetween('id',[20,30])->first();
        // // select * from `tasks` where `id` between ? and ?

        // $tasks = Task::where('id', '=', 10)->limit(2)->get();
        // // select * from `tasks` where `id` 10
        // // dump($tasks);

        // $tasks = Task::where('title', 'like', '%Nulla%')->get();
        // select * from `tasks` where `id` 10
        // $task = Task::find(10);

        // $tasks = Task::all();
        $tasks = Task::with('user')->get();

        return view('tasks.index', compact('tasks'));
    }

    function show(Task $task) {
        $task = $task->load('comments.user','user');
        return view('tasks.show', compact('task'));
    }

    function ajaxloadtasks(Request $request) {
        $tasks = Task::with('user');

        return DataTables::of($tasks)
        ->addIndexColumn()
        ->addColumn('bil', function($task){
            return '1';
        })
        ->addColumn('user', function($task){
            return $task->user->name;
        })
        ->addColumn('due_date', function($task){
            return \Carbon\Carbon::parse($task->due_date)->format('d-m-Y');
        })
        ->addColumn('action', function($task){
            return '<a class="btn btn-primary btn-sm" href="'.route('tasks.show',['task'=>$task->uuid]).'">Show</a>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    function create() {
        $users = User::pluck('name','id');
        return view('tasks.create', compact('users'));
    }

    function store(Request $request) {
        $request->validate([
            "title" => 'required|max:255',
            "user_id" => 'required',
            "due_date" => 'required|date|after_or_equal:today',
            "description" => 'required'
        ],[
            'title.required' => 'Sila masukkan tajuk',
            'user_id.required' => 'Sila pilih user',
            'due_date.required' => 'Sila pilih tarikh',
            'due_date.after_or_equal' => 'Tarikh mesti selepas hari ini',
            'due_date.date' => 'Sila pilih tarikh',
            'description.required' => 'Sila masukkan description'
        ]);

        $task = new Task();
        $task->uuid = Uuid::uuid4();
        $task->title = $request->title;
        $task->user_id = $request->user_id;
        $task->due_date = $request->due_date;
        $task->description = $request->description;
        $task->save();

        return redirect()->route('tasks.index');
    }
}
