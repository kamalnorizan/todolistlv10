@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task Detail</div>

                <div class="card-body">
                   <h3>{{ $task->title }}</h3>
                   ~{{ $task->user->name }} || {{\Carbon\Carbon::parse($task->due_date)->format('d-m-Y')}}
                   <hr>
                   <h5>Comment(s)</h5>
                   @forelse ($task->comments as $comment)
                    <div class="comment">
                        <strong>{{ $comment->user->name }}</strong> <br>
                        {{ $comment->content }}
                        <br>
                        <hr>
                    </div>
                    @empty
                    <center>No Comment to show</center>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

