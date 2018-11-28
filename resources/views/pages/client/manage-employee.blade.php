@extends('layout')
@section('content')
<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>Manage Employees</h2>
                @include('includes.messages')
                @if(isset($errors))
                    @foreach($errors as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-sm-12">
                <div class="employee-table-center clearfix">
                    <table id="example" class="table" style="width:100%">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>E-mail</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 0; @endphp
                        @foreach($employees as $e)
                        @php $count++; @endphp
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $e->employee_id }}</td>
                            <td>{{ $e->name }}</td>
                            <td>{{ $e->phone }}</td>
                            <td>{{ $e->email }}</td>
                            <td>
                                <div class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModalEmp-{{ $e->id }}">Edit</div>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModalPass-{{ $e->id }}">Edit Password</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModalBlock-{{ $e->id }}">@if($e->status == 'unblock') {{ 'Block' }} @else {{ 'Unblock' }} @endif</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModalDel-{{ $e->id }}">Delete</button>
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
