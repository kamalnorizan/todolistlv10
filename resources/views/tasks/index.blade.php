@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
@endsection

@section('pagetitle', 'Tasks')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript: void(0);">Todolist</a></li>
    <li class="breadcrumb-item active">Tasks</li>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Tasks
                        <a class="btn btn-sm btn-primary float-end" href="{{ route('tasks.create') }}">Add New Task</a>
                    </div>

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

    <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Kemaskini Task
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('tasks._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button id="btnKemaskini" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var myTable = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('tasks.ajaxloadtasks') }}",
                method: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [{
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

        $(document).on("click", ".btn-edit", function(e) {
            var uuid = $(this).data('uuid');

            $.ajax({
                type: "post",
                url: "{{ route('tasks.ajaxloadtask') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    uuid: uuid
                },
                dataType: "json",
                success: function(response) {
                    $('#editModal #title').val(response.title);
                    $('#editModal #user_id').val(response.user_id);
                    $('#editModal #due_date').val(response.due_date);
                    $('#editModal #description').val(response.description);
                    $('#editModal #btnKemaskini').attr('data-uuid', uuid);
                },
                error: function() {
                    alert("Error");
                }
            });
        });

        $(document).on("click", "#btnKemaskini", function(e) {
            e.preventDefault();
            $('.text-danger').text('');
            $('.is-invalid').removeClass('is-invalid');
            var id = $(this).attr('data-uuid');
            $.ajax({
                type: "post",
                url: "{{ route('tasks.update') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    uuid: id,
                    title: $('#title').val(),
                    user_id: $('#user_id').val(),
                    due_date: $('#due_date').val(),
                    description: $('#description').val()
                },
                dataType: "json",
                success: function (response) {
                    $('#editModal').modal('hide');
                    swal("Task telah berjaya dikemaskini",{
                        icon:'success',
                        buttons: {
                            cancel: {
                                text: "OK",
                                value: null,
                                visible: true,
                                className: "",
                                closeModal: true,
                            }
                        }
                    });
                    myTable.ajax.reload();

                },
                error: function(err){
                    var errors = err.responseJSON.errors;
                    $.each(errors, function (indexInArray, valueOfElement) {
                        $('#'+indexInArray).addClass('is-invalid');
                        $('#'+indexInArray).closest('.form-group').find('.text-danger').text(valueOfElement);
                    });
                }
            });
        });

        $(document).on("click",".btn-delete",function (e) {
            var uuid = $(this).data('uuid');

            swal({
                title: "Are you sure?",
                text: "The task will be deleted!",
                icon: "warning",
                buttons: {cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, i'm sure!",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }}
            }).then((value)=>{
                if(value==true){
                    $.ajax({
                        type: "post",
                        url: "{{ route('tasks.delete') }}",
                        data: {
                            _token: '{{csrf_token()}}',
                            uuid: uuid
                        },
                        dataType: "json",
                        success: function (response) {
                            swal("Deleted!", "The task has been deleted successfully.", "success");
                            myTable.ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
