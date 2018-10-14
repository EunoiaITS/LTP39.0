@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Settings <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">Assign Hour Rate</h4>
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
                    <div class="assign-create">
                        <button class="btn-info btn btn-login" data-toggle="modal" data-target="#myModal2">Create</button>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="employee-table-center clearfix">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>ID</th>
                                <th>Vehicle Type Number</th>
                                <th>Base Hour</th>
                                <th>Base Fair</th>
                                <th>Subsequent Hour Rate</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($pr as $p)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>R00{{ $p->id }}</td>
                                <td>{{ $p->vehicle->type_name }}</td>
                                <td>{{ $p->base_hour }}</td>
                                <td>{{ $p->base_rate }}</td>
                                <td>{{ $p->sub_rate }}</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#edit-{{ $p->id }}">Edit</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#delete-{{ $p->id }}">Delete</button>
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