<?php

namespace App\Http\Controllers;

use App\Models\Task;
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

    function store(Request $request)  {
        dd($request);
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
}
