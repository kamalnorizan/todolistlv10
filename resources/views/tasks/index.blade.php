@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tasks</div>

                <div class="card-body">
                   <table class="table" id="myTable">
                    <tr>
                        <td>Bil</td>
                        <td>Title</td>
                        <td>User</td>
                        <td>Due Date</td>
                        <td>Action(s)</td>
                    </tr>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $task->title }}
                            </td>
                            <td>
                                {{ $task->user->name }}
                            </td>
                            <td>
                                {{ $task->due_date }}
                            </td>
                            <td>
                                <a href="{{ route('tasks.show',['task'=>$task->uuid]) }}" class="btn btn-primary">Show</a>
                            </td>
                        </tr>
                    @endforeach
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

