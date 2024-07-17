@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tasks</div>

                    <div class="card-body">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>Bil</th>
                                    <th>Title</th>
                                    <th>User</th>
                                    <th>Due Date</th>
                                    <th>Action(s)</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                            <a href="{{ route('tasks.show', ['task' => $task->uuid]) }}"
                                                class="btn btn-primary">Show</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        $('#myTable').DataTable();
    </script>
@endsection
