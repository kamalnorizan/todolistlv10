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
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('tasks.ajaxloadtasks') }}",
                method: 'POST',
                data: function(d){
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title'
                },
                {
                    data: 'user',
                    name: 'user.name'
                },
                {
                    data: 'due_date'
                },
                {
                    data: 'action'
                }
            ]
        });
    </script>
@endsection
