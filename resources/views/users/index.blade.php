@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Senarai Pengguna</div>

                <div class="card-body">
                   <table class="table" id="usertbl">
                    <tr>
                        <td>Bil</td>
                        <td>Nama</td>
                        <td>Email</td>
                        <td>Action</td>
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

